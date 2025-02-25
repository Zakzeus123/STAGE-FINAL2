<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$classes = $conn->query("SELECT id, className FROM tblclass");
$sections = $conn->query("SELECT id, classArmName FROM tblclassarms");

$students = [];
$gradesList = [];

$coefficients = [
    'controle' => 1,
    'Projet' => 1,
    'regional' => 5,
    'Examen' => 3
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['classId']) && isset($_POST['classArmId'])) {
    $classId = $_POST['classId'];
    $classArmId = $_POST['classArmId'];

    $studentsQuery = $conn->query("SELECT id, firstName, lastName FROM tblstudents WHERE classId = '$classId' AND classArmId = '$classArmId'");
    while ($row = $studentsQuery->fetch_assoc()) {
        $students[] = $row;
    }

    foreach ($students as $student) {
        $studentId = $student['id'];
        $studentName = $student['firstName'] . " " . $student['lastName'];

        $sql = "SELECT g.note, g.noteType FROM tblgrades g WHERE g.studentId = '$studentId'";
        $result = $conn->query($sql);

        $totalWeightedScore = 0;
        $totalCoefficient = 0;

        while ($row = $result->fetch_assoc()) {
            $note = floatval($row['note']);
            $type = $row['noteType'];

            if (isset($coefficients[$type])) {
                $totalWeightedScore += $note * $coefficients[$type];
                $totalCoefficient += $coefficients[$type];
            }
        }

        $average = ($totalCoefficient > 0) ? round($totalWeightedScore / $totalCoefficient, 2) : 0;
        $gradesList[] = ['name' => $studentName, 'grade' => $average];
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
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Calcul de la Note Finale</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Calcul de la Note Finale</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Sélectionner la classe et la section</h6>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group">
                                            <label for="classId">Sélectionner une Classe:</label>
                                            <select name="classId" id="classId" class="form-control" required>
                                                <option value="">-- Choisir une classe --</option>
                                                <?php while ($row = $classes->fetch_assoc()) { ?>
                                                    <option value="<?= $row['id'] ?>"><?= $row['className'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="classArmId">Sélectionner une Section:</label>
                                            <select name="classArmId" id="classArmId" class="form-control" required>
                                                <option value="">-- Choisir une section --</option>
                                                <?php while ($row = $sections->fetch_assoc()) { ?>
                                                    <option value="<?= $row['id'] ?>"><?= $row['classArmName'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Afficher les Étudiants</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($students)) { ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Notes Finales des Étudiants</h6>
                                    </div>
                                    <div class="table-responsive p-3">
                                        <table class="table align-items-center table-flush table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Étudiant</th>
                                                    <th>Note Finale</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($gradesList as $student) { ?>
                                                    <tr>
                                                        <td><?= $student['name'] ?></td>
                                                        <td><?= $student['grade'] ?>/20</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
                        <div class="alert alert-warning">Aucun étudiant trouvé pour cette classe et cette section.</div>
                    <?php } ?>
                </div>
            </div>
        <?php include "Includes/footer.php"; ?>
    </div>
    </div>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>

</html>