<?php
include '../Includes/dbcon.php'; // Connexion à la BDD
include '../Includes/session.php'; // Vérifier la connexion admin

$message = ""; // Message d'alerte après soumission

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = mysqli_real_escape_string($conn, $_POST['titre']);
    $contenu = mysqli_real_escape_string($conn, $_POST['contenu']);
    $source = "Administrateur";
    $lien = !empty($_POST['lien']) ? mysqli_real_escape_string($conn, $_POST['lien']) : NULL;
    $image = NULL;

    // Gestion de l'upload de l'image
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/";
        $image = basename($_FILES["image"]["name"]);
        $image = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $image);

        $target_file = $target_dir . $image;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Vérification du type de fichier
        $extensionsAutorisees = ["jpg", "jpeg", "png", "gif"];
        if (in_array($imageFileType, $extensionsAutorisees)) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        } else {
            $message = "Format d'image non valide (jpg, jpeg, png, gif uniquement)";
            $image = NULL;
        }
    }

    // Convert multiple selections into comma-separated strings
    $classId = isset($_POST['classId']) ? implode(',', $_POST['classId']) : NULL;
    $teacherId = isset($_POST['teacherId']) ? implode(',', $_POST['teacherId']) : NULL;
    $classArmId = isset($_POST['classArmId']) ? implode(',', $_POST['classArmId']) : NULL;

    // Insérer l'annonce dans la BDD
    $query = "INSERT INTO tblannonces (titre, contenu, image, lien, source, classId, teacherId, classArmId) 
              VALUES ('$titre', '$contenu', '$image', '$lien', '$source', '$classId', '$teacherId', '$classArmId')";

    if (mysqli_query($conn, $query)) {
        $message = "Annonce publiée avec succès !";
    } else {
        $message = "Erreur lors de la publication : " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Créer une Annonce</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include "Includes/sidebar.php";?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "Includes/topbar.php";?>
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Créer une Annonce</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Créer une Annonce</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <?php if (!empty($message)): ?>
                                <div class="alert alert-info"> <?php echo $message; ?> </div>
                            <?php endif; ?>

                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="titre">Titre :</label>
                                    <input type="text" name="titre" id="titre" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="contenu">Contenu :</label>
                                    <textarea name="contenu" id="contenu" class="form-control" rows="5" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="classId">Classes :</label>
                                    <select name="classId[]" id="classId" class="form-control" multiple required>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM tblclass");
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$row['Id']}'>{$row['className']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="teacherId">Enseignants :</label>
                                    <select name="teacherId[]" id="teacherId" class="form-control" multiple required>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM tblclassteacher");
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$row['Id']}'>{$row['firstName']} {$row['lastName']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="classArmId">Groupes :</label>
                                    <select name="classArmId[]" id="classArmId" class="form-control" multiple required>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT * FROM tblclassarms");
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$row['Id']}'>{$row['classArmName']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="lien">Lien (optionnel) :</label>
                                    <input type="url" name="lien" id="lien" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="image">Image (optionnelle) :</label>
                                    <input type="file" name="image" id="image" class="form-control-file">
                                </div>
                                <button type="submit" class="btn btn-primary">Publier</button>
                                <a href="index.php" class="btn btn-secondary">Annuler</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'Includes/footer.php';?>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
