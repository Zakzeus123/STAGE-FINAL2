<?php 

include '../Includes/dbcon.php';
include '../Includes/session.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$query = "SELECT Id, className FROM tblclass";
$rs = $conn->query($query);
$num = $rs->num_rows;


?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Gestion des classes">
  <title>Gérer les classes</title>
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

        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Toutes les classes</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Accueil</a></li>
              <li class="breadcrumb-item active" aria-current="page">Classes</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Liste des classes</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Nom de la classe</th>
                        <th>Date de création</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sn = 0;
                      if ($num > 0) {
                        while ($rows = $rs->fetch_assoc()) {
                          $sn++;
                          echo "<tr>
                                  <td>{$rows['Id']}</td>
                                  <td>{$rows['className']}</td>
                                </tr>";
                        }
                      } else {
                        echo "<tr><td colspan='3' class='text-center text-danger'>Aucune classe trouvée</td></tr>";
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
      <!-- Pied de page -->
      <?php include "Includes/footer.php";?>
      <!-- Pied de page -->
    </div>
  </div>

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>
 

  

  <script>
    $(document).ready(function () {
      $('#dataTableHover').DataTable();
    });
  </script>
</body>
</html>