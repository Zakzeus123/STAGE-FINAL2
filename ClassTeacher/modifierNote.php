<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../Includes/dbcon.php';
include '../Includes/session.php';


if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("location: gerNote.php");
    exit();
}

$noteId = intval($_GET['id']);


$query = "SELECT * FROM tblnotes WHERE Id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $noteId);
$stmt->execute();
$result = $stmt->get_result();
$note = $result->fetch_assoc();

if (!$note) {
    header("location: gerNote.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = trim($_POST["subject"]);
    $controle = isset($_POST["controle"]) && $_POST["controle"] !== "" ? floatval($_POST["controle"]) : null;
    $EFM = isset($_POST["EFM"]) && $_POST["EFM"] !== "" ? floatval($_POST["EFM"]) : null;
    $regional = isset($_POST["regional"]) && $_POST["regional"] !== "" ? floatval($_POST["regional"]) : null;
    $notes = trim($_POST["notes"]);

  
    $finalGrade = ($controle !== null && $EFM !== null && $regional !== null) 
                  ? ($controle + $EFM + $regional) / 3 
                  : null;

    
    $updateQuery = "UPDATE tblnotes 
                    SET subject=?, controle=?, EFM=?, regional=?, finalGrade=?, notes=? 
                    WHERE Id=?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sdddssi", $subject, $controle, $EFM, $regional, $finalGrade, $notes, $noteId);

    if ($updateStmt->execute()) {
        header("location: gerNote.php?update_success=1");
        exit();
    } else {
        echo "<script>alert('Erreur lors de la mise à jour.');</script>";
    }
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
    <title>Modifier Note</title>
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
                    <h1 class="h3 mb-4 text-gray-800">Modifier la Note</h1>

                    <div class="card mb-4">
                        <div class="card-header">Modifier une note</div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label>Matière</label>
                                        <input type="text" name="subject" class="form-control" value="<?= htmlspecialchars($note['subject']) ?>" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Contrôle</label>
                                        <input type="number" name="controle" step="0.01" class="form-control" value="<?= $note['controle'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label>EFM</label>
                                        <input type="number" name="EFM" step="0.01" class="form-control" value="<?= $note['EFM'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Régional</label>
                                        <input type="number" name="regional" step="0.01" class="form-control" value="<?= $note['regional'] ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Remarque</label>
                                    <input type="text" name="notes" class="form-control" value="<?= htmlspecialchars($note['notes']) ?>">
                                </div>

                                <button type="submit" class="btn btn-success">Mettre à jour</button>
                                <a href="gerNote.php" class="btn btn-secondary">Annuler</a>
                            </form>
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