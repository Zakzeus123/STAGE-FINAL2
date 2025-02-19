<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

// جلب معلومات التلميذ
$studentId = $_SESSION['userId'];
$query = mysqli_query($conn, "SELECT classId FROM tblstudents WHERE Id = '$studentId'");
$row = mysqli_fetch_assoc($query);
$classId = $row['classId'];


$examQuery = mysqli_query($conn, "SELECT * FROM emploi_exam WHERE classId = '$classId'");
$examData = [];
while ($exam = mysqli_fetch_assoc($examQuery)) {
    $examData[] = $exam;
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
<?php include 'includes/title.php';?>
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

          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          </div>

            <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Emploi du Examens</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Emploi du Examens</li>
            </ol>
          </div>

          <!-- جدول الامتحانات -->
          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Emploi du Temps des Examens - Classe <?php echo $classId; ?></h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table table-bordered">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Matière</th>
                        <th>Date</th>
                        <th>Heure de début</th>
                        <th>Heure de fin</th>
                        <th>Salle d'examen</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (!empty($examData)) {
                          foreach ($examData as $exam) {
                              echo "<tr>
                                      <td>".$sn."</td>
                                      <td>{$exam['subject']}</td>
                                      <td>{$exam['exam_date']}</td>
                                      <td>{$exam['start_time']}</td>
                                      <td>{$exam['end_time']}</td>
                                      <td>{$exam['exam_hall']}</td>
                                    </tr>";
                          }
                      } else {
                          echo "<tr><td colspan='5' class='text-center'>Aucun examen programmé</td></tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <?php include "Includes/footer.php"; ?>
    </div>
  </div>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
