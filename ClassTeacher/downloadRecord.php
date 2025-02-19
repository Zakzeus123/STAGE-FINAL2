<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$teacherId = $_SESSION['userId'];

$scheduleQuery = mysqli_query($conn, "
    SELECT s.id, s.day, t.termName, c.className, ca.classArmName, s.subject
    FROM tblschedule s
    JOIN tblterm t ON s.termId = t.id
    JOIN tblclass c ON s.classId = c.id
    JOIN tblclassarms ca ON s.classArmId = ca.id
    WHERE s.teacherId = '$teacherId'
    ORDER BY s.day, s.classId, s.classArmId
");
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
    <?php include 'includes/title.php'; ?>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include "Includes/sidebar.php"; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "Includes/topbar.php"; ?>
                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    </div>

                    <!-- Container Fluid-->
                    <div class="container-fluid" id="container-wrapper">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Emploi du Temps</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Emploi du Temps </li>
                            </ol>
                        </div>

                        <!-- جدول الامتحانات -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Emploi du Temps </h6>
                                    </div>
                                    <div class="table-responsive p-3">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Jour</th>
                                                    <th>Session</th>
                                                    <th>Classe</th>
                                                    <th>Section</th>
                                                    <th>Matière</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sn = 1;
                                                while ($row = mysqli_fetch_assoc($scheduleQuery)) {
                                                    echo "<tr>
                                                               <td>{$sn}</td>
                                                               <td>{$row['day']}</td>
                                                               <td>{$row['termName']}</td>
                                                               <td>{$row['className']}</td>
                                                               <td>{$row['classArmName']}</td>
                                                               <td>{$row['subject']}</td>
                                                             </tr>";
                                                    $sn++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php include "Includes/footer.php"; ?>
            </div>
        </div>

        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>