<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../Includes/dbcon.php';
include '../Includes/session.php';

// استرداد ID الصف من رابط الـ URL
if (isset($_GET['id'])) {
    $examId = $_GET['id'];

    // استعلام لجلب البيانات الحالية للصف
    $query = "SELECT * FROM tblschedule WHERE id = '$examId'";
    $result = mysqli_query($conn, $query);
    $examData = mysqli_fetch_assoc($result);

    // إذا لم يتم العثور على الصف، توجيه المستخدم إلى الصفحة الرئيسية
    if (!$examData) {
        header("Location: emploiTempsselector.php");
        exit();
    }
}

//------------------------UPDATE--------------------------------------------------

if (isset($_POST['update'])) {
    // جلب القيم من الـ POST
    $termId = $_POST['termId'];
    $classId = $_POST['classId'];
    $day = $_POST['day'];
    $classArmId = $_POST['classArmId'];
    $teacherId = $_POST['teacherId'];
    $subject = $_POST['subject'];

    // استعلام لتحديث البيانات
    $query = "UPDATE tblschedule SET termId='$termId', classId='$classId', day='$day', classArmId='$classArmId', teacherId='$teacherId', subject='$subject' WHERE id='$examId'";

    if (mysqli_query($conn, $query)) {
        $msg = "Examen modifié avec succès!";
        header("Location: emploiTempsselector.php");
        exit();
    } else {
        $msg = "Erreur lors de la modification!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Modifier Examen</title>
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
                    <h1 class="h3 mb-0 text-gray-800">Modifier Examen</h1>

                    <!-- Form to Edit -->
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
                                                $selected = $row['Id'] == $examData['termId'] ? 'selected' : '';
                                                echo "<option value='{$row['Id']}' $selected>{$row['termName']}</option>";
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
                                                $selected = $row['Id'] == $examData['classId'] ? 'selected' : '';
                                                echo "<option value='{$row['Id']}' $selected>{$row['className']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <div class="col-xl-6">
                                        <label>Jour</label>
                                        <select name="day" class="form-control">
                                            <option value="Lundi" <?php echo ($examData['day'] == 'Lundi' ? 'selected' : ''); ?>>Lundi</option>
                                            <option value="Mardi" <?php echo ($examData['day'] == 'Mardi' ? 'selected' : ''); ?>>Mardi</option>
                                            <option value="Mercredi" <?php echo ($examData['day'] == 'Mercredi' ? 'selected' : ''); ?>>Mercredi</option>
                                            <option value="Jeudi" <?php echo ($examData['day'] == 'Jeudi' ? 'selected' : ''); ?>>Jeudi</option>
                                            <option value="Vendredi" <?php echo ($examData['day'] == 'Vendredi' ? 'selected' : ''); ?>>Vendredi</option>
                                            <option value="Samedi" <?php echo ($examData['day'] == 'Samedi' ? 'selected' : ''); ?>>Samedi</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-6">
                                        <label>Section</label>
                                        <select name="classArmId" class="form-control" required>
                                            <?php
                                            $result = mysqli_query($conn, "SELECT * FROM tblclassarms");
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $selected = $row['Id'] == $examData['classArmId'] ? 'selected' : '';
                                                echo "<option value='{$row['Id']}' $selected>{$row['classArmName']}</option>";
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
                                                $selected = $row['Id'] == $examData['teacherId'] ? 'selected' : '';
                                                echo "<option value='{$row['Id']}' $selected>{$row['firstName']} {$row['lastName']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-xl-6">
                                        <label>Matière</label>
                                        <input type="text" name="subject" class="form-control" value="<?php echo $examData['subject']; ?>" required>
                                    </div>
                                </div>

                                <div>
                                    <button type="submit" name="update" class="btn btn-success mt-3">Mettre à jour l'examen</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Container Fluid-->
            </div>
        </div>

        <?php include "Includes/footer.php"; ?>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>
</html>