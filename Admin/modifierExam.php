<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM emploi_exam WHERE id='$id'");
    $row = mysqli_fetch_assoc($query);
}

if (isset($_POST['update'])) {
    $classId = $_POST['classId'];
    $classArmId = $_POST['classArmId'];
    $subject = $_POST['subject'];
    $exam_date = $_POST['exam_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $exam_hall = $_POST['exam_hall'];

    $updateQuery = "UPDATE emploi_exam SET 
        classId='$classId', 
        classArmId='$classArmId', 
        subject='$subject', 
        exam_date='$exam_date', 
        start_time='$start_time', 
        end_time='$end_time', 
        exam_hall='$exam_hall' 
        WHERE id='$id'";

    if (mysqli_query($conn, $updateQuery)) {
        header("location:emploiExamSt.php");
    } else {
        echo "Erreur lors de la modification!";
    }
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
                xmlhttp.open("GET", "ajaxClassArms.php?cid=" + str, true);
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
                        <h1 class="h3 mb-0 text-gray-800">Gestion de l'Emploi du Temps</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Gestion de l'Emploi du Temps</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Form Basic -->
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Gestion de l'Emploi du Temps</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">

                                                <label>Classe</label>
                                                <select name="classId" class="form-control" required>
                                                    <?php
                                                    $result = mysqli_query($conn, "SELECT * FROM tblclass");
                                                    while ($class = mysqli_fetch_assoc($result)) {
                                                        $selected = ($class['Id'] == $row['classId']) ? "selected" : "";
                                                        echo "<option value='{$class['Id']}' $selected>{$class['className']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>


                                            <div class="col-xl-6">
                                                <label>Section</label>
                                                <select name="classArmId" class="form-control" required>
                                                    <?php
                                                    $result = mysqli_query($conn, "SELECT * FROM tblclassarms");
                                                    while ($section = mysqli_fetch_assoc($result)) {
                                                        $selected = ($section['Id'] == $row['classArmId']) ? "selected" : "";
                                                        echo "<option value='{$section['Id']}' $selected>Section {$section['classArmName']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label>Matière</label>
                                                <input type="text" name="subject" class="form-control" value="<?php echo $row['subject']; ?>" required>
                                            </div>

                                            <div class="col-xl-6">
                                                <label>Date de l'examen</label>
                                                <input type="date" name="exam_date" class="form-control" value="<?php echo $row['exam_date']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label>Heure de début</label>
                                                <input type="time" name="start_time" class="form-control" value="<?php echo $row['start_time']; ?>" required>
                                            </div>

                                            <div class="col-xl-6">
                                                <label>Heure de fin</label>
                                                <input type="time" name="end_time" class="form-control" value="<?php echo $row['end_time']; ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label>Salle d'examen</label>
                                                <input type="text" name="exam_hall" class="form-control" value="<?php echo $row['exam_hall']; ?>" required>
                                            </div>
                                        </div>
                                        <div>

                                            <button type="submit" name="update" class="btn btn-primary mt-3">Mettre à jour</button>
                                            <a href="emploiExamSt.php" class="btn btn-secondary mt-3">Annuler</a>
                                        </div>
                                    </form>
                                </div>
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

</body>

</html>