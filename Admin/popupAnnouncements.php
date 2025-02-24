
<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Get logged-in user details
$userId = $_SESSION['userId'];
$userType = $_SESSION['userType']; // 'student' or 'teacher'
$classId = $_SESSION['classId'] ?? null;
$classArmId = $_SESSION['classArmId'] ?? null;

// Fetch announcements for the specific user
$query = "SELECT * FROM tblannonces WHERE (classId = '$classId' OR classArmId = '$classArmId' OR teacherId = '$userId')";
$result = mysqli_query($conn, $query);
$announcements = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h2>Bienvenue!</h2>
    </div>

    <!-- Popup Modal -->
    <div class="modal fade" id="announcementModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">📢 Annonces</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <?php if (count($announcements) > 0): ?>
                        <?php foreach ($announcements as $annonce): ?>
                            <div class="alert alert-info">
                                <h5><?= $annonce['titre']; ?></h5>
                                <p><?= $annonce['contenu']; ?></p>
                                <?php if ($annonce['image']): ?>
                                    <img src="../uploads/<?= $annonce['image']; ?>" class="img-fluid" alt="Annonce">
                                <?php endif; ?>
                                <?php if ($annonce['lien']): ?>
                                    <a href="<?= $annonce['lien']; ?>" target="_blank">Lire plus</a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucune annonce disponible.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#announcementModal').modal('show');
        });
    </script>
</body>
</html>
