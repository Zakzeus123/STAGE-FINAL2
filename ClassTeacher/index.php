<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';

$userId = $_SESSION['userId'];

// Fetch the latest announcement for the user's classes and groups
$query = "SELECT classId, classArmId FROM tblclassteacher WHERE Id = '$userId'
          UNION
          SELECT classId, classArmId FROM tblstudents WHERE Id = '$userId'";

$result = mysqli_query($conn, $query);
$latestAnnouncement = null;

while ($row = mysqli_fetch_assoc($result)) {
    $classId = $row['classId'];
    $classArmId = $row['classArmId'];

    // Get only the latest announcement
    $announcementQuery = "SELECT * FROM tblannonces 
                          WHERE FIND_IN_SET('$classId', classId) OR FIND_IN_SET('$classArmId', classArmId) 
                          ORDER BY created_at DESC LIMIT 1";
    $announcementResult = mysqli_query($conn, $announcementQuery);

    if ($announcement = mysqli_fetch_assoc($announcementResult)) {
        $latestAnnouncement = $announcement;
        break; // Stop the loop once the latest announcement is found
    }
}

// Fetch the teacher's class and group
$query = "SELECT tblclass.className, tblclassarms.classArmName 
          FROM tblclassteacher
          INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
          INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
          WHERE tblclassteacher.Id = '$userId'";

$rs = $conn->query($query);
$rrw = $rs->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tableau de Bord</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include "Includes/sidebar.php";?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "Includes/topbar.php";?>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tableau de Bord (<?php echo $rrw['className'].' - '.$rrw['classArmName'];?>)</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Accueil</a></li>
                            <li class="breadcrumb-item active">Tableau de Bord</li>
                        </ol>
                    </div>
                    <div class="row">
                        <?php 
                        $students = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tblstudents"));
                        $classes = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tblclass"));
                        $classArms = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tblclassarms"));
                        $totAttendance = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tblattendance"));
                        ?>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase">Étudiants</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $students;?></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-users fa-2x text-info"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase">Classes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $classes;?></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-chalkboard fa-2x text-primary"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase">Sections</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $classArms;?></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-code-branch fa-2x text-success"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase">Présences</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totAttendance;?></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-calendar fa-2x text-warning"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Latest Announcement Modal -->
                    <script>
   document.addEventListener("DOMContentLoaded", function () {
    let latestAnnouncement = <?php echo json_encode($latestAnnouncement); ?>;
    console.log("Latest Announcement Data:", latestAnnouncement); // Debugging output

    if (latestAnnouncement) {
        let imageTag = latestAnnouncement.image ? 
            `<div class="text-center my-3">
                <img src="../uploads/${latestAnnouncement.image}" class="img-fluid rounded shadow" 
                     alt="Annonce Image" style="max-width: 100%; max-height: 300px; object-fit: contain;">
            </div>` 
            : '';

        // Ensure the `lien` is not null or empty
        let linkTag = (latestAnnouncement.lien && latestAnnouncement.lien.trim() !== '') ? 
            `<div class="text-center mt-3">
                <a href="${latestAnnouncement.lien}" target="_blank" class="btn btn-primary" 
                   style="width: 100%; max-width: 200px; display: inline-block;">
                    🔗 Voir plus
                </a>
            </div>` 
            : '<div class="text-center mt-3 text-muted">Aucun lien disponible</div>';

        let modalContent = `
            <div class="p-3 text-center">
                <h4 class="text-primary font-weight-bold">${latestAnnouncement.titre}</h4>
                <hr>
                ${imageTag}
                <p class="text-dark text-justify" style="font-size: 16px; line-height: 1.5; word-wrap: break-word;">
                    ${latestAnnouncement.contenu}
                </p>
                ${linkTag}
            </div>`;

        let modal = `
            <div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="modalTitle">📢 Dernière Annonce</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">${modalContent}</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>`;

        document.body.insertAdjacentHTML('beforeend', modal);
        $('#announcementModal').modal('show');
    }
});




                    </script>

                </div>
            </div>
            <?php include 'includes/footer.php';?>
        </div>
    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>
</html>