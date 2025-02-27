<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../Includes/dbcon.php';
include '../Includes/session.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = $conn->query("SELECT * FROM tblgrades WHERE id='$id'");
    $row = $query->fetch_assoc();
}

$classes = $conn->query("SELECT id, className FROM tblclass");
$classArms = $conn->query("SELECT id, classArmName FROM tblclassarms");
$sessions = $conn->query("SELECT id, sessionName FROM tblsessionterm");
$students = $conn->query("SELECT id, firstName, lastName FROM tblstudents");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $classId = $_POST["classId"];
    $classArmId = $_POST["classArmId"];
    $sessionTermId = $_POST["sessionTermId"];
    $studentId = $_POST["studentId"];
    $subject = $_POST["subject"];
    $note = $_POST["note"];
    $noteType = $_POST["noteType"];
    $notes = $_POST["notes"];


    $sql = "UPDATE tblgrades SET 
                classId='$classId', 
                classArmId='$classArmId', 
                sessionTermId='$sessionTermId', 
                studentId='$studentId', 
                subject='$subject', 
                note='$note', 
                noteType='$noteType',
                notes='$notes'
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: gerNote.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="img/logo/attnlg.jpg" rel="icon">
    <?php include 'includes/title.php'; ?>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">

    

    <script>
        function typeDropDown(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "ajaxCallTypes.php?tid=" + str, true);
                xmlhttp.send();
            }
        }
    </script>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include "Includes/sidebar.php"; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "Includes/topbar.php"; ?>
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Modifier les notes</h1> 
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Modifier les notes des élèves</li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Modifier Tableau des notes</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group row mb-3">
                                            <!-- Sélection Classe -->
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Classe</label>
                                                <select name="classId" class="form-control" required>
                                                    <?php while ($c = $classes->fetch_assoc()) { ?>
                                                        <option value="<?= $c['id'] ?>" <?= ($row['classId'] == $c['id']) ? 'selected' : '' ?>>
                                                            <?= $c['className'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <!-- Sélection Section -->
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Section</label>
                                                <select name="classArmId" class="form-control" required>
                                                    <?php while ($a = $classArms->fetch_assoc()) { ?>
                                                        <option value="<?= $a['id'] ?>" <?= ($row['classArmId'] == $a['id']) ? 'selected' : '' ?>>
                                                            <?= $a['classArmName'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <!-- Sélection Semestre -->
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Semestre</label>
                                                <select name="sessionTermId" class="form-control" required>
                                                    <?php while ($s = $sessions->fetch_assoc()) { ?>
                                                        <option value="<?= $s['id'] ?>" <?= ($row['sessionTermId'] == $s['id']) ? 'selected' : '' ?>>
                                                            <?= $s['sessionName'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <!-- Sélection Étudiant -->
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Étudiant</label>
                                                <select name="studentId" class="form-control" required>
                                                    <?php while ($st = $students->fetch_assoc()) { ?>
                                                        <option value="<?= $st['id'] ?>" <?= ($row['studentId'] == $st['id']) ? 'selected' : '' ?>>
                                                            <?= $st['firstName'] . " " . $st['lastName'] ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Matière</label>
                                                <input type="text" name="subject" value="<?= $row['subject']; ?>" required class="form-control">
                                            </div>
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Note</label>
                                                <input type="text" name="note" value="<?= $row['note']; ?>" required class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Type de note</label>
                                                <select name="noteType" class="form-control" required>
                                                    <option value="Examen" <?= ($row['noteType'] == 'Examen') ? 'selected' : '' ?>>Examen fin module</option>
                                                    <option value="controle" <?= ($row['noteType'] == 'controle') ? 'selected' : '' ?>>Contrôle</option>
                                                    <option value="regional" <?= ($row['noteType'] == 'regional') ? 'selected' : '' ?>>Régional</option>
                                                    <option value="Projet" <?= ($row['noteType'] == 'Projet') ? 'selected' : '' ?>>Projet</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Remarque</label>
                                                <input type="text" name="notes" class="form-control" required>
                                            </div>
                                        </div>

                                        <div>
                                            <button type="submit" class="btn btn-success mt-3">Modifier</button>
                                            <a href="gerNote.php" class="btn btn-success mt-3">Annuler</a>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include "Includes/footer.php"; ?>
            </div>
        </div>
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="js/ruang-admin.min.js"></script>
        <!-- Page level plugins -->
        <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable(); // ID From dataTable 
                $('#dataTableHover').DataTable(); // ID From dataTable with Hover
            });
        </script>
    </div>
</body>

</html>
