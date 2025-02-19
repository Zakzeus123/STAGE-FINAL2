<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

// جلب معلومات التلميذ
$studentId = $_SESSION['userId'];
$query = mysqli_query($conn, "SELECT classId FROM tblstudents WHERE Id = '$studentId'");
$row = mysqli_fetch_assoc($query);
$classId = $row['classId'];

// جلب استعمال الزمن من قاعدة البيانات
$scheduleQuery = mysqli_query($conn, "SELECT * FROM emploi_du_temps WHERE classId = '$classId'");
$scheduleData = [];

while ($data = mysqli_fetch_assoc($scheduleQuery)) {
  $scheduleData[$data['jour']][$data['periode']] = $data['matiere'];
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
        
          </div>
           <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Emploi du Temps</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Emploi du Temps</li>
            </ol>
          </div>





          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Emploi du Temps - Classe <?php echo $classId; ?></h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table table-bordered">
                    <thead class="thead-light">
                      <tr>
                        <th>Jour</th>
                        <th>08:30 - 11:00</th>
                        <th>11:00 - 13:30</th>
                        <th>13:30 - 16:00</th>
                        <th>16:00 - 18:30</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $jours = ["LUNDI", "MARDI", "MERCREDI", "JEUDI", "VENDREDI", "SAMEDI"];
                      foreach ($jours as $jour) {
                        echo "<tr>";
                        echo "<th>$jour</th>";
                        for ($i = 1; $i <= 4; $i++) {
                          echo "<td>" . ($scheduleData[$jour][$i] ?? "—") . "</td>";
                        }
                        echo "</tr>";
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