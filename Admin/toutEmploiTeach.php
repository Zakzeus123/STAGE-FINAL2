<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';
$teacherQuery = mysqli_query($conn, "
    SELECT DISTINCT te.id, te.firstName, te.lastName
    FROM tblschedule s
    JOIN tblclassteacher te ON s.teacherId = te.id
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
            </div>
            <!-- Container Fluid-->
            <div class="container-fluid" id="container-wrapper">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Emploi du Temps</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Emploi du Temps</li>
                    </ol>
                </div>

                <?php
                while ($teacher = mysqli_fetch_assoc($teacherQuery)) {
                    echo "<div class='mt-5'>";
                    echo "<h4 class='text-primary'>Enseignant: " . $teacher['firstName'] . " " . $teacher['lastName'] . "</h4>";

                    $scheduleQuery = mysqli_query($conn, "
        SELECT s.day, t.termName, c.className, ca.classArmName, s.subject
        FROM tblschedule s
        JOIN tblterm t ON s.termId = t.id
        JOIN tblclass c ON s.classId = c.id
        JOIN tblclassarms ca ON s.classArmId = ca.id
        WHERE s.teacherId = '{$teacher['id']}'
        ORDER BY s.day, s.classId, s.classArmId
    ");

                ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Emploi du Temps - Classe </h6>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                            <tr>
                                                <th>Jour</th>
                                                <th>Trimestre</th>
                                                <th>Classe</th>
                                                <th>Section</th>
                                                <th>Matière</th>
                                            </tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($scheduleQuery)) {
                                                echo "<tr>
                        <td>{$row['day']}</td>
                        <td>{$row['termName']}</td>
                        <td>{$row['className']}</td>
                        <td>{$row['classArmName']}</td>
                        <td>{$row['subject']}</td>
                      </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php }  ?>


            </div>
            <?php include "Includes/footer.php"; ?>
        </div>
    </div>



    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>