<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Ensure the user is a teacher (Modify the condition based on your role management system)

$sql = "SELECT hw.homeworkId, s.firstName, s.lastName AS studentName, hw.subjectName, hw.filePath, hw.uploadDate 
        FROM tblhomework hw
        JOIN tblstudents s ON hw.studentId = s.Id
        ORDER BY hw.uploadDate DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Devoirs soumis</title>
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
                <h2>Devoirs soumis</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Matière</th>
                            <th>Date de soumission</th>
                            <th>Fichier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['studentName']); ?></td>
                                <td><?php echo htmlspecialchars($row['subjectName']); ?></td>
                                <td><?php echo htmlspecialchars($row['uploadDate']); ?></td>
                                <td><a href="<?php echo htmlspecialchars($row['filePath']); ?>" target="_blank" class="btn btn-success btn-sm">Voir le fichier</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
