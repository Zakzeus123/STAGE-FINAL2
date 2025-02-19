<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if (isset($_POST['add'])) {
    // جلب القيم من الـ POST
    $termId = $_POST['termId'];
    $classId = $_POST['classId'];
    $day = $_POST['day'];
    $classArmId = $_POST['classArmId'];
    $teacherId = $_POST['teacherId'];
    $subject = $_POST['subject'];

    // استعلام لإضافة البيانات إلى الجدول
    $query = "INSERT INTO tblschedule (termId, classId, day, classArmId, teacherId, subject) 
              VALUES ('$termId', '$classId', '$day', '$classArmId', '$teacherId', '$subject')";

    if (mysqli_query($conn, $query)) {
        $msg = "Ajout réussi!";
    } else {
        $msg = "Erreur lors de l'ajout!";
    }
}

//--------------------------------FETCH SCHEDULE DATA----------------------------------------------------
$scheduleQuery = mysqli_query($conn, "
    SELECT s.id, s.day, t.termName, c.className, ca.classArmName, te.firstName, te.lastName, s.subject 
    FROM tblschedule s
    JOIN tblterm t ON s.termId = t.id
    JOIN tblclass c ON s.classId = c.id
    JOIN tblclassarms ca ON s.classArmId = ca.id
    JOIN tblclassteacher te ON s.teacherId = te.id
    ORDER BY s.day, s.classId, s.classArmId
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Gestion de l'Emploi du Temps</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Insertion des emplois</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Ajouter</li>
                        </ol>
                    </div>
                    <!-- Form Basic -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group row mb-3">
                                    <div class="col-xl-6">
                                        <label>Trimestre</label>
                                        <select name="termId" class="form-control" required>
                                            <?php
                                            $result = mysqli_query($conn, "SELECT * FROM tblterm");
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='{$row['Id']}'>{$row['termName']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-xl-6">
                                        <label>Classe</label>
                                        <select name="classId" class="form-control" required>
                                            <?php
                                            $result = mysqli_query($conn, "SELECT * FROM tblclass");
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='{$row['Id']}'>{$row['className']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-xl-6">
                                        <label>Jour</label>
                                        <select name="day" class="form-control">
                                            <option value="Lundi">Lundi</option>
                                            <option value="Mardi">Mardi</option>
                                            <option value="Mercredi">Mercredi</option>
                                            <option value="Jeudi">Jeudi</option>
                                            <option value="Vendredi">Vendredi</option>
                                            <option value="Samedi">Samedi</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-6">
                                        <label>Section</label>
                                        <select name="classArmId" class="form-control" required>
                                            <?php
                                            $result = mysqli_query($conn, "SELECT * FROM tblclassarms");
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='{$row['Id']}'>{$row['classArmName']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-xl-6">
                                        <label>Enseignant</label>
                                        <select name="teacherId" class="form-control" required>
                                            <?php
                                            $result = mysqli_query($conn, "SELECT * FROM tblclassteacher");
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='{$row['Id']}'>{$row['firstName']} {$row['lastName']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-xl-6">
                                        <label>Matière</label>
                                        <input type="text" name="subject" class="form-control" required>
                                    </div>
                                </div>

                                <div>
                                    <button type="submit" name="add" class="btn btn-success mt-3">Ajouter</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Table for displaying added exams -->
                    <div class="card mb-4">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Jour</th>
                                        <th>Trimestre</th>
                                        <th>Classe</th>
                                        <th>Section</th>
                                        <th>Enseignant</th>
                                        <th>Matière</th>
                                        <th>Modifier</th>
                                        <th>Supprimer</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $sn = 1;
                                    while ($row = mysqli_fetch_assoc($scheduleQuery)) { ?>
                                        <tr>
                                            <td><?php echo $sn++; ?></td>
                                            <td><?php echo $row['day']; ?></td>
                                            <td><?php echo $row['termName']; ?></td>
                                            <td><?php echo $row['className']; ?></td>
                                            <td><?php echo $row['classArmName']; ?></td>
                                            <td><?php echo $row['firstName'] . " " . $row['lastName']; ?></td>
                                            <td><?php echo $row['subject']; ?></td>
                                            <td>
                                                <a href="modifierTech.php?id=<?php echo $row['id']; ?>" class="mx-2">
                                                    <i class="bi bi-pencil-square text-primary fs-5"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="emploiTempsselector.php?delete=<?php echo $row['id']; ?>" class="mx-2"
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

            <!-- Container Fluid-->



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
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
            $('#dataTableHover').DataTable();
        });
    </script>
</body>

</html>