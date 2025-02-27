<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Ensure student is logged in

$studentId = $_SESSION['userId'];

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['subjectName'])) {
    $subjectName = $_POST['subjectName'];
    $targetDir = "../uploads/homework/";
    
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $fileName = basename($_FILES['homeworkFile']['name']);
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $targetFilePath = $targetDir . $studentId . '_' . time() . '.' . $fileType;
    
    // Allow only PDF files
    if ($fileType != "pdf") {
        echo "<script>alert('Only PDF files are allowed.');</script>";
    } else {
        if (move_uploaded_file($_FILES['homeworkFile']['tmp_name'], $targetFilePath)) {
            $sql = "INSERT INTO tblhomework (studentId, subjectName, filePath, uploadDate) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $studentId, $subjectName, $targetFilePath);
            if ($stmt->execute()) {
                echo "<script>alert('Homework submitted successfully!');</script>";
            } else {
                echo "<script>alert('Database error: Failed to submit homework.');</script>";
            }
        } else {
            echo "<script>alert('File upload failed. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="utf-8">
    <title>Soumettre un devoir</title> 
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div id="wrapper">
 <?php include "Includes/sidebar.php"; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "Includes/topbar.php"; ?>
  <div class="container mt-4">
    <h2>Soumettre un Devoir</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="subjectName" class="mt-2">Écrire le nom de la matière :</label>
        <input type="text" name="subjectName" id="subjectName" class="form-control" required>
        <label for="homeworkFile" class="mt-2">Sélectionner un fichier PDF :</label>
        <input type="file" name="homeworkFile" id="homeworkFile" class="form-control" accept=".pdf" required>
        <button type="submit" class="btn btn-primary mt-2">Soumettre</button>
    </form>
  </div>
 </div>
    <?php include "Includes/footer.php"; ?>
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
