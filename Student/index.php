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

    $query = "SELECT tblclass.className,tblclassarms.classArmName 
    FROM tblclassteacher
    INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
    INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
    WHERE tblclassteacher.Id = '{$_SESSION['userId']}'";

    $rs = $conn->query($query);
    $num = $rs->num_rows;
    $rrw = $rs->fetch_assoc();

    if (!$rs) {
      die("Erreur SQL : " . $conn->error);
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
  <title>Tableau de bord</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Barre latérale -->
    <?php include "Includes/sidebar.php";?>
    <!-- Barre latérale -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- Barre supérieure -->
        <?php include "Includes/topbar.php";?>
        <!-- Barre supérieure -->
        <!-- Conteneur fluide-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tableau de bord de Student</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Accueil</a></li>
              <li class="breadcrumb-item active" aria-current="page">Tableau de bord</li>
            </ol>
          </div>

          <div class="row mb-3">
          <!-- Carte des étudiants -->
          <?php 
$query1=mysqli_query($conn,"SELECT * from tblstudents");                       
$students = mysqli_num_rows($query1);
?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Étudiants</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $students;?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <!-- <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 20.4%</span>
                        <span>Depuis le mois dernier</span> -->
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Carte des classes -->
             <?php 
$query1=mysqli_query($conn,"SELECT * from tblclass");                       
$class = mysqli_num_rows($query1);
?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Classes</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $class;?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <!-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                        <span>Depuis le mois dernier</span> -->
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-chalkboard fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Carte des bras de classe -->
             <?php 
$query1=mysqli_query($conn,"SELECT * from tblclassarms");                       
$classArms = mysqli_num_rows($query1);
?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Bras de classe</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $classArms;?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <!-- <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                        <span>Depuis l'année dernière</span> -->
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-code-branch fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Carte de la présence des étudiants -->
            <?php 
$query1=mysqli_query($conn,"SELECT * from tblattendance");                       
$totAttendance = mysqli_num_rows($query1);
?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Présence totale des étudiants</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totAttendance;?></div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <!-- <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                        <span>Depuis hier</span> -->
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-secondary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Carte des enseignants -->
            <?php 
            $query1=mysqli_query($conn,"SELECT * from tblclassteacher");                       
            $classTeacher = mysqli_num_rows($query1);
            ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                          <div class="card h-100">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-uppercase mb-1">Enseignants de classe</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $classTeacher;?></div>
                                  <div class="mt-2 mb-0 text-muted text-xs">
                                    <!-- <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                                    <span>Depuis l'année dernière</span> -->
                                  </div>
                                </div>
                                <div class="col-auto">
                                  <i class="fas fa-chalkboard-teacher fa-2x text-danger"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
          

                         <!-- Carte des sessions et termes -->
            <?php 
            $query1=mysqli_query($conn,"SELECT * from tblsessionterm");                       
            $sessTerm = mysqli_num_rows($query1);
            ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                          <div class="card h-100">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-uppercase mb-1">Sessions & Termes</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sessTerm;?></div>
                                  <div class="mt-2 mb-0 text-muted text-xs">
                                    <!-- <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                                    <span>Depuis l'année dernière</span> -->
                                  </div>
                                </div>
                                <div class="col-auto">
                                  <i class="fas fa-calendar-alt fa-2x text-warning"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>


                        <!-- Carte des termes -->
            <?php 
            $query1=mysqli_query($conn,"SELECT * from tblterm");                       
            $termonly = mysqli_num_rows($query1);
            ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                          <div class="card h-100">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-uppercase mb-1">Termes</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $termonly;?></div>
                                  <div class="mt-2 mb-0 text-muted text-xs">
                                    <!-- <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                                    <span>Depuis l'année dernière</span> -->
                                  </div>
                                </div>
                                <div class="col-auto">
                                  <i class="fas fa-th fa-2x text-info"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
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
          <!--Row-->

        </div>
        <!---Conteneur fluide-->
      </div>
      <!-- Footer -->
      <?php include 'includes/footer.php';?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="../vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>

</html>