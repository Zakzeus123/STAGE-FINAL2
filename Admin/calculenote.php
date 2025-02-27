<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Récupérer les étudiants pour le menu déroulant
$students = $conn->query("SELECT Id, firstName, lastName FROM tblstudents");

// Définition des coefficients
$coefficients = [
    'controle' => 1,
    'EFM' => 3,
    'regional' => 5
];

$grades = [];
$generalAverage = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['studentId'])) {
    $studentId = $_POST['studentId'];
    
    // Requête pour récupérer les notes de l'étudiant
    $sql = "SELECT subject, controle, EFM, regional FROM tblnotes WHERE studentId = '$studentId'";
    $result = $conn->query($sql);
    
    $totalGrades = 0;
    $subjectCount = 0;
    
    while ($row = $result->fetch_assoc()) {
        $subject = $row['subject'];
        
        $totalWeighted = 0;
        $totalCoeff = 0;
        
        foreach ($coefficients as $type => $coef) {
            if (!is_null($row[$type])) {
                $totalWeighted += $row[$type] * $coef;
                $totalCoeff += $coef;
            }
        }
        
        $finalGrade = ($totalCoeff > 0) ? round($totalWeighted / $totalCoeff, 2) : 0;
        
        $grades[] = ['subject' => $subject, 'finalGrade' => $finalGrade];
        
        $totalGrades += $finalGrade;
        $subjectCount++;
    }
    
    $generalAverage = ($subjectCount > 0) ? round($totalGrades / $subjectCount, 2) : 0;
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
  <title>Voir les notes</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>
<body>
<div id="wrapper">
       <?php include "Includes/sidebar.php"; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "Includes/topbar.php"; ?>
    <div class="container mt-4">
        <h2>Voir les Notes</h2>
        <form method="post">
            <label for="studentId">Sélectionner un étudiant :</label>
            <select name="studentId" id="studentId" class="form-control" required>
                <option value="">-- Choisir un étudiant --</option>
                <?php while ($row = $students->fetch_assoc()) { ?>
                    <option value="<?= $row['Id'] ?>"><?= $row['firstName'] . ' ' . $row['lastName'] ?></option>
                <?php } ?>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Afficher</button>
        </form>

        <?php if (!empty($grades)) { ?>
            <h3 class="mt-4">Notes de l'étudiant</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Matière</th>
                        <th>Note Finale</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($grades as $grade) { ?>
                        <tr>
                            <td><?= $grade['subject'] ?></td>
                            <td><?= $grade['finalGrade'] ?>/20</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <h4>Moyenne Générale: <strong><?= $generalAverage ?>/20</strong></h4>
        <?php } ?>
    </div>
    <?php include "Includes/footer.php"; ?>
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>
</html>
