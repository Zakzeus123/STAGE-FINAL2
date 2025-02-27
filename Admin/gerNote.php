<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Récupération des données pour les listes déroulantes
$classes = $conn->query("SELECT Id, className FROM tblclass");
$sessions = $conn->query("SELECT Id, sessionName FROM tblsessionterm");
$students = $conn->query("SELECT Id, firstName, lastName FROM tblstudents");

// Ajout d'une note lorsqu'on soumet le formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $classId = $_POST["classId"];
    $sessionTermId = $_POST["sessionTermId"];
    $studentId = $_POST["studentId"];
    $subject = $_POST["subject"];
    $controle = $_POST["controle"] ?: null;
    $EFM = $_POST["EFM"] ?: null;
    $regional = $_POST["regional"] ?: null;
    $notes = $_POST["notes"];

    // Utilisation de requêtes préparées pour éviter les injections SQL
    $sql = $conn->prepare("INSERT INTO tblnotes (classId, sessionTermId, studentId, subject, controle, EFM, regional, notes) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("iiisddds", $classId, $sessionTermId, $studentId, $subject, $controle, $EFM, $regional, $notes);
    $sql->execute();
}

// Récupération des notes pour affichage
$sql = "SELECT n.Id, c.className, s.sessionName, st.firstName, st.lastName, 
               n.subject, n.controle, n.EFM, n.regional, n.finalGrade, n.notes 
        FROM tblnotes n
        JOIN tblclass c ON n.classId = c.Id
        JOIN tblsessionterm s ON n.sessionTermId = s.Id
        JOIN tblstudents st ON n.studentId = st.Id";
$result = $conn->query($sql);

// Suppression d'une note
if (isset($_GET['delete'])) {
    $Id = $_GET['delete'];
    $conn->query("DELETE FROM tblnotes WHERE Id='$Id'");
    header("location: gerNote.php");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/attnlg.jpg" rel="icon">
  <title>Gestion des notes</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
       <?php include "Includes/sidebar.php"; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "Includes/topbar.php"; ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Gestion des notes</h1>

                    <!-- Formulaire d'ajout de notes -->
                    <div class="card mb-4">
                        <div class="card-header">Ajouter une note</div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Classe</label>
                                        <select name="classId" class="form-control" required>
                                            <option value="">Sélectionner</option>
                                            <?php while ($row = $classes->fetch_assoc()) { ?>
                                                <option value="<?= $row['Id'] ?>"><?= $row['className'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Semestre</label>
                                        <select name="sessionTermId" class="form-control" required>
                                            <option value="">Sélectionner</option>
                                            <?php while ($row = $sessions->fetch_assoc()) { ?>
                                                <option value="<?= $row['Id'] ?>"><?= $row['sessionName'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Étudiant</label>
                                        <select name="studentId" class="form-control" required>
                                            <option value="">Sélectionner</option>
                                            <?php while ($row = $students->fetch_assoc()) { ?>
                                                <option value="<?= $row['Id'] ?>"><?= $row['firstName'] . ' ' . $row['lastName'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label>Matière</label>
                                        <input type="text" name="subject" class="form-control" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Contrôle</label>
                                        <input type="number" name="controle" step="0.01" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label>EFM</label>
                                        <input type="number" name="EFM" step="0.01" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Régional</label>
                                        <input type="number" name="regional" step="0.01" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Remarque</label>
                                    <input type="text" name="notes" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-success">Ajouter</button>
                            </form>
                        </div>
                    </div>

                    <!-- Tableau des notes -->
                    <div class="card mb-4">
                        <div class="card-header">Tableau des notes</div>
                        <div class="table-responsive p-3">
                            <table class="table table-hover" id="dataTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Classe</th>
                                        <th>Semestre</th>
                                        <th>Étudiant</th>
                                        <th>Matière</th>
                                        <th>Contrôle</th>
                                        <th>EFM</th>
                                        <th>Régional</th>
                                        <th>Moyenne</th>
                                        <th>Remarque</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?= $row['Id'] ?></td>
                                            <td><?= $row['className'] ?></td>
                                            <td><?= $row['sessionName'] ?></td>
                                            <td><?= $row['firstName'] . ' ' . $row['lastName'] ?></td>
                                            <td><?= $row['subject'] ?></td>
                                            <td><?= $row['controle'] ?: '-' ?></td>
                                            <td><?= $row['EFM'] ?: '-' ?></td>
                                            <td><?= $row['regional'] ?: '-' ?></td>
                                            <td><strong><?= number_format($row['finalGrade'], 2) ?></strong></td>
                                            <td><?= $row['notes'] ?></td>
                                            <td>
                                                <a href='modifierNote.php?id=<?= $row['Id'] ?>' class='text-primary'><i class='bi bi-pencil-square'></i></a>
                                                <a href='gerNote.php?delete=<?= $row['Id'] ?>' class='text-danger' onclick="return confirm('Confirmer la suppression ?');"><i class='bi bi-trash'></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <?php include "Includes/footer.php"; ?>
            </div>
        </div>
    </div>
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>

</html>
