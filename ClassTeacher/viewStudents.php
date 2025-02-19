<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['classId']) || !isset($_SESSION['classArmId'])) {
  die("Erreur : Les variables de session 'classId' et 'classArmId' ne sont pas définies !");
}

$query = "SELECT tblclass.className,tblclassarms.classArmName 
    FROM tblclassteacher
    INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
    INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
    Where tblclassteacher.Id = '$_SESSION[userId]'";

    $rs = $conn->query($query);
    $num = $rs->num_rows;
    $rrw = $rs->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Tableau de bord de gestion des élèves">
  <meta name="author" content="">
  <link href="img/logo/attnlg.jpg" rel="icon">
  <title>Tableau de bord</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

<script>
    function classArmDropdown(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // Code pour IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // Code pour IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajaxClassArms2.php?cid="+str,true);
        xmlhttp.send();
    }
}
</script>
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

        <!-- Conteneur Fluid -->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tous les élèves de (<?php echo $rrw['className'].' - '.$rrw['classArmName'];?>)</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Accueil</a></li>
              <li class="breadcrumb-item active" aria-current="page">Élèves de la classe</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
                 <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Liste des élèves</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Autre prénom</th>
                        <th>N° Admission</th>
                        <th>Classe</th>
                        <th>Section</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                  <?php
                      $classId = intval($_SESSION['classId']);
                      $classArmId = intval($_SESSION['classArmId']);
                      
                      $query = "SELECT tblstudents.Id, tblclass.className, tblclassarms.classArmName, 
                                tblclassarms.Id AS classArmId, tblstudents.firstName, tblstudents.lastName, 
                                tblstudents.otherName, tblstudents.emailAddress, tblstudents.dateCreated 
                                FROM tblstudents 
                                INNER JOIN tblclass ON tblclass.Id = tblstudents.classId 
                                INNER JOIN tblclassarms ON tblclassarms.Id = tblstudents.classArmId 
                                WHERE tblstudents.classId = $classId 
                                AND tblstudents.classArmId = $classArmId";
                      
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                      $sn=0;
                      $status="";
                      if($num > 0)
                      { 
                        while ($rows = $rs->fetch_assoc())
                          {
                             $sn = $sn + 1;
                            echo"
                              <tr>
                                <td>".$sn."</td>
                                <td>".$rows['firstName']."</td>
                                <td>".$rows['lastName']."</td>
                                <td>".$rows['otherName']."</td>
                                <td>".$rows['emailAddress']."</td>
                                <td>".$rows['className']."</td>
                                <td>".$rows['classArmName']."</td>
                              </tr>";
                          }
                      }
                      else
                      {
                           echo   
                           "<div class='alert alert-danger' role='alert'>
                            Aucun enregistrement trouvé !
                            </div>";
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
      </div>
      <!-- Pied de page -->
       <?php include "Includes/footer.php";?>
      <!-- Pied de page -->
    </div>
  </div>

  <!-- Bouton de retour en haut -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <!-- Plugins DataTables -->
  <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Scripts personnalisés -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID de la table de données
      $('#dataTableHover').DataTable(); // ID de la table avec survol
    });
  </script>
</body>
</html>