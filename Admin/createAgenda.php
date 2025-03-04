<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Vérifier si l'admin est connecté
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$statusMsg = "";

// Ajouter un événement
if (isset($_POST['save'])) {
    $eventTitle = mysqli_real_escape_string($conn, $_POST['eventTitle']);
    $eventDescription = mysqli_real_escape_string($conn, $_POST['eventDescription']);
    $eventDate = $_POST['eventDate'];
    $eventTime = $_POST['eventTime'];
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $createdBy = $_SESSION['userId']; // ID de l'admin connecté

    $query = "INSERT INTO tblEvents (eventTitle, eventDescription, eventDate, eventTime, location, createdBy) 
              VALUES ('$eventTitle', '$eventDescription', '$eventDate', '$eventTime', '$location', '$createdBy')";

    if (mysqli_query($conn, $query)) {
        $statusMsg = "<div class='alert alert-success'>Événement ajouté avec succès !</div>";
    } else {
        $statusMsg = "<div class='alert alert-danger'>Erreur lors de l'ajout de l'événement.</div>";
    }
}

// Supprimer un événement
if (isset($_GET['delete'])) {
    $eventId = $_GET['delete'];
    $query = "DELETE FROM tblEvents WHERE Id = $Id";
    if (mysqli_query($conn, $query)) {
        $statusMsg = "<div class='alert alert-success'>Événement supprimé avec succès !</div>";
    } else {
        $statusMsg = "<div class='alert alert-danger'>Erreur lors de la suppression.</div>";
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
  <title>Creer un evenement</title>
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
<div class="container mt-5">
    <h2 class="mb-4">Créer un Événement</h2>
    <?php echo $statusMsg; ?>
    <form method="post">
        <div class="form-group">
            <label>Titre de l'événement</label>
            <input type="text" class="form-control" name="eventTitle" required>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" class="form-control" name="eventDate" required>
        </div>
        <div class="form-group">
            <label>Heure</label>
            <input type="time" class="form-control" name="eventTime" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="eventDescription" required></textarea>
        </div>
        <div class="form-group">
            <label>Lieu</label>
            <textarea class="form-control" name="location" required></textarea>
        </div>
        <button type="submit" name="save" class="btn btn-primary">Enregistrer</button>
    </form>
    <hr>
    <h3 class="mt-4">Liste des événements</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Description</th>
                <th>Lieu</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = mysqli_query($conn, "SELECT * FROM tblevents ORDER BY eventDate ASC");
            $sn = 0;
            while ($row = mysqli_fetch_assoc($query)) {
                $sn++;
                echo "<tr>
                        <td>$sn</td>
                        <td>{$row['eventTitle']}</td>
                        <td>{$row['eventDate']}</td>
                        <td>{$row['eventTime']}</td>
                        <td>{$row['eventDescription']}</td>
                        <td>{$row['location']}</td>
                        <td><a href='?action=delete&Id={$row['Id']}' class='btn btn-danger btn-sm'>Supprimer</a></td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</div>
<?php include "Includes/footer.php"; ?>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>
</html>
