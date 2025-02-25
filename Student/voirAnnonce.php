<?php
include '../Includes/dbcon.php'; // Connexion à la BDD
include '../Includes/session.php'; // Vérifier la connexion admin

// Récupérer toutes les annonces créées par l'admin
$query = "SELECT * FROM tblannonces ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voir les Annonces</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include "Includes/sidebar.php";?>
        <!-- Sidebar -->
        
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <?php include "Includes/topbar.php";?>
                <!-- Topbar -->
                
                <div class="container-fluid" id="container-wrapper">
                <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php endif; ?>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">📢 Toutes les Annonces</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Accueil</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Annonces</li>
                        </ol>
                    </div>

                    <div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th style="min-width: 150px;">Titre</th>
                        <th style="max-width: 300px; overflow: hidden; text-overflow: ellipsis;">Contenu</th>
                        <th style="white-space: nowrap;">Date</th>
                        <th>Image</th>
                        <th style="white-space: nowrap;">Lien</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$count}</td>
                            <td>{$row['titre']}</td>
                            <td style='max-width: 300px; white-space: normal; word-wrap: break-word; text-overflow: ellipsis;'>{$row['contenu']}</td>
                            <td>{$row['created_at']}</td>
                            <td>";
                        
                        if (!empty($row['image'])) {
                            echo "<img src='../uploads/{$row['image']}' alt='Annonce Image' style='max-width: 100px; height: auto;'>";
                        } else {
                            echo "Aucune";
                        }

                        echo "</td>
                            <td>";
                        
                        if (!empty($row['lien'])) {
                            echo "<a href='{$row['lien']}' target='_blank'>Voir le lien</a>";
                        } else {
                            echo "Aucun";
                        }

                        echo "</td>
                        </tr>";
                        $count++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

                </div>
            </div>
            <!-- Footer -->
            <?php include 'includes/footer.php';?>
            <!-- Footer -->
        </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
    <!-- <script>
        function confirmDelete() {
            return confirm("Êtes-vous sûr de vouloir supprimer cette annonce ?");
        }
    </script> -->
</body>
</html>
