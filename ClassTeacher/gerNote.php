<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Récupération des données pour les listes déroulantes
$classes = $conn->query("SELECT id, className FROM tblclass");
$classArms = $conn->query("SELECT id, classArmName FROM tblclassarms");
$sessions = $conn->query("SELECT id, sessionName FROM tblsessionterm");
$students = $conn->query("SELECT id, firstName, lastName FROM tblstudents");

// Ajout d'une note lorsqu'on soumet le formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $classId = $_POST["classId"];
    $classArmId = $_POST["classArmId"];
    $sessionTermId = $_POST["sessionTermId"];
    $studentId = $_POST["studentId"];
    $subject = $_POST["subject"];
    $note = $_POST["note"];
    $noteType = $_POST["noteType"];
    $notes = $_POST["notes"];

    $sql = "INSERT INTO tblgrades (classId, classArmId, sessionTermId, studentId, subject, note, noteType, notes) 
            VALUES ('$classId', '$classArmId', '$sessionTermId', '$studentId', '$subject', '$note', '$noteType', '$notes')";
    $conn->query($sql);
}

// Récupération des données pour afficher les notes
$sql = "SELECT g.id, c.className, a.classArmName, s.sessionName, st.firstName, st.lastName, g.subject, g.note, g.noteType, g.notes 
        FROM tblgrades g
        JOIN tblclass c ON g.classId = c.id
        JOIN tblclassarms a ON g.classArmId = a.id
        JOIN tblsessionterm s ON g.sessionTermId = s.id
        JOIN tblstudents st ON g.studentId = st.id";
$result = $conn->query($sql);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM tblgrades WHERE id='$id'");
    header("location: gerNote.php");
}
?>

<!DOCTYPE html>
<html lang="fr">

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
                        <h1 class="h3 mb-0 text-gray-800">Gestion des notes</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Voir les notes des élèves</li>
                        </ol>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Saisir une note</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Classe</label>
                                                <select name="classId" class="form-control" required>
                                                    <option value="">Sélectionner la classe</option>
                                                    <?php while ($row = $classes->fetch_assoc()) { ?>
                                                        <option value="<?= $row['id'] ?>"><?= $row['className'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Section</label>
                                                <select name="classArmId" class="form-control" required>
                                                    <option value="">Sélectionner la section</option>
                                                    <?php while ($row = $classArms->fetch_assoc()) { ?>
                                                        <option value="<?= $row['id'] ?>"><?= $row['classArmName'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Semestre</label>
                                                <select name="sessionTermId" class="form-control" required>
                                                    <option value="">Sélectionner le semestre</option>
                                                    <?php while ($row = $sessions->fetch_assoc()) { ?>
                                                        <option value="<?= $row['id'] ?>"><?= $row['sessionName'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Étudiant</label>
                                                <select name="studentId" class="form-control" required>
                                                    <option value="">Sélectionner Étudiant</option>
                                                    <?php while ($row = $students->fetch_assoc()) { ?>
                                                        <option value="<?= $row['id'] ?>"><?= $row['firstName'] . ' ' . $row['lastName'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Matière</label>
                                                <input type="text" name="subject" class="form-control" required>
                                            </div>
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Note</label>
                                                <input type="text" name="note" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Type de note</label>
                                                <select name="noteType" class="form-control" required>
                                                    <option value="">Sélectionner un type</option>
                                                    <option value="Examen">Examen fin module</option>
                                                    <option value="controle">controle</option>
                                                    <option value="regional">regional</option>
                                                    <option value="Projet">Projet</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Remarque</label>
                                                <input type="text" name="notes" class="form-control" required>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-success mt-3">Ajouter la note</button>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card mb-4">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">Tableau des notes</h6>
                                        </div>
                                        <div class="table-responsive p-3">
                                            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Classe</th>
                                                        <th>Section</th>
                                                        <th>Semestre</th>
                                                        <th>Étudiant</th>
                                                        <th>Matière</th>
                                                        <th>Note</th>
                                                        <th>Type</th>
                                                        <th>Remarque</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                                        <tr>
                                                            <td><?= $row['id'] ?></td>
                                                            <td><?= $row['className'] ?></td>
                                                            <td><?= $row['classArmName'] ?></td>
                                                            <td><?= $row['sessionName'] ?></td>
                                                            <td><?= $row['firstName'] . ' ' . $row['lastName'] ?></td>
                                                            <td><?= $row['subject'] ?></td>
                                                            <td><?= $row['note'] ?></td>
                                                            <td><?= $row['noteType'] ?></td>
                                                            <td><?= $row['notes'] ?></td>
                                                            <td>
                                                                <a href='modifiercreenote.php?id=<?= $row['id'] ?>' class='mx-2'>
                                                                    <i class='bi bi-pencil-square text-primary'></i>
                                                                </a>
                                                                <a href='gerNote.php?delete=<?= $row['id'] ?>' class='mx-2'
                                                                    onclick="return confirm('Voulez-vous vraiment supprimer cette note ?');">
                                                                    <i class='bi bi-trash text-danger'></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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