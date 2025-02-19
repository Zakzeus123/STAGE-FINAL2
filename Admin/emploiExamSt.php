<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if (isset($_POST['submit'])) {
    $classId = $_POST['classId'];
    $classArmId = $_POST['classArmId'];
    $subject = $_POST['subject'];
    $exam_date = $_POST['exam_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $exam_hall = $_POST['exam_hall']; // Ajouter un champ pour la salle d'examen

    $query = "INSERT INTO emploi_exam (classId, classArmId, subject, exam_date, start_time, end_time, exam_hall)
              VALUES ('$classId', '$classArmId', '$subject', '$exam_date', '$start_time', '$end_time',  '$exam_hall')";
}



//--------------------------------DELETE------------------------------------------------------------------
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM emploi_exam WHERE id='$id'");
    header("location: haf.php");
}
$scheduleQuery = mysqli_query($conn, "SELECT * FROM emploi_exam ORDER BY classId, classArmId, subject, exam_date, start_time, end_time, exam_hall");



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/attnlg.jpg" rel="icon">
    <?php include 'includes/title.php'; ?>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">



    <script>
        function classArmDropdown(str) {
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
                xmlhttp.open("GET", "ajaxClassArms2.php?cid=" + str, true);
                xmlhttp.send();
            }
        }
    </script>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include "Includes/sidebar.php"; ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include "Includes/topbar.php"; ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Ajout d'Examen</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Ajout d'Examen</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Form Basic -->
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Create Exam</h6>
                                    <?php echo $statusMsg; ?>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Classe</label>
                                                <select name="classId" class="form-control" required>
                                                    <?php
                                                    $result = mysqli_query($conn, "SELECT * FROM tblclass");
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='{$row['Id']}'>{$row['className']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Section</label>
                                                <select name="classArmId" class="form-control" required>
                                                    <?php
                                                    $result = mysqli_query($conn, "SELECT * FROM tblclassarms");
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='{$row['Id']}'>Section {$row['classArmName']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Matière</label>
                                                <input type="text" name="subject" class="form-control" required>
                                            </div>
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Date de l'examen</label>
                                                <input type="date" name="exam_date" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Heure de début</label>
                                                <input type="time" name="start_time" class="form-control" required>
                                            </div>
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Heure de fin</label>
                                                <input type="time" name="end_time" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label>Salle d'examen</label>
                                                <input type="text" name="exam_hall" class="form-control" required>
                                            </div>
                                        </div>

                                        <div>
                                            <button type="submit" name="submit" class="btn btn-success mt-3">Ajouter l'examen</button>
                                        </div>
                                        <br>

                                    </form>
                                </div>
                            </div>

                            <!-- Input Group -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card mb-4">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">All Student</h6>
                                        </div>
                                        <div class="table-responsive p-3">
                                            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Matière</th>
                                                        <th>Date</th>
                                                        <th>Heure de début</th>
                                                        <th>Heure de fin</th>
                                                        <th>Salle d'examen</th>
                                                        <th>Modifier</th>
                                                        <th>supprimer</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <?php
                                                    $query = "SELECT * FROM emploi_exam ORDER BY exam_date, start_time";
                                                    $result = mysqli_query($conn, $query);
                                                    $sn = 1;
                                                    while ($row = mysqli_fetch_assoc($result)) { ?>

                                                        <tr>
                                                            <td><?php echo $sn++; ?></td>
                                                            <td><?php echo $row['subject'] ?></td>
                                                            <td><?php echo $row['exam_date'] ?></td>
                                                            <td><?php echo $row['start_time'] ?></td>
                                                            <td><?php echo $row['end_time'] ?></td>
                                                            <td><?php echo $row['exam_hall'] ?></td>
                                                            <td>

                                                                <a href="modifierExam.php?id=<?php echo $row['id']; ?>" class="mx-2">
                                                                    <i class="bi bi-pencil-square text-primary fs-5"></i>
                                                                </a>
                                                            </td>
                                                            <td> <a href="emploiExamSt.php?delete=<?php echo $row['id']; ?>" class="mx-2"
                                                                    onclick="return confirm('Voulez-vous vraiment supprimer cette séance ?');">
                                                                    <i class="bi bi-trash text-primary fs-5"></i>
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
                        <!--Row-->

                        <!-- Documentation Link -->
                        <!-- <div class="row">
            <div class="col-lg-12 text-center">
              <p>For more documentations you can visit<a href="https://getbootstrap.com/docs/4.3/components/forms/"
                  target="_blank">
                  bootstrap forms documentations.</a> and <a
                  href="https://getbootstrap.com/docs/4.3/components/input-group/" target="_blank">bootstrap input
                  groups documentations</a></p>
            </div>
          </div> -->

                    </div>
                    <!---Container Fluid-->
                </div>
                <!-- Footer -->
                <?php include "Includes/footer.php"; ?>
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
</body>

</html>