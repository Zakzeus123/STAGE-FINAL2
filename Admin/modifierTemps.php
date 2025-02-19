<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = mysqli_query($conn, "SELECT * FROM emploi_du_temps WHERE id='$id'");
  $row = mysqli_fetch_assoc($query);
}

if (isset($_POST['update'])) {
  $classId = $_POST['classId'];
  $jour = $_POST['jour'];
  $periode = $_POST['periode'];
  $matiere = $_POST['matiere'];

  $updateQuery = "UPDATE emploi_du_temps SET classId='$classId', jour='$jour', periode='$periode', matiere='$matiere' WHERE id='$id'";

  if (mysqli_query($conn, $updateQuery)) {
    header("location: emploiTempsSt.php");
  } else {
    echo "Erreur lors de la modification!";
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <title>Modifier la Séance</title>
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">




  <script>
    function classArmDropdown(str) {
      if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
      } else {
        if (window.XMLHttpRequest) {
          // code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp = new XMLHttpRequest();
        } else {
          // code for IE6, IE5
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "ajaxClassArms.php?cid=" + str, true);
        xmlhttp.send();
      }
    }
  </script>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include "Includes/sidebar.php"; ?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php include "Includes/topbar.php"; ?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <h1 class="h3 mb-0 text-gray-800">Modifier Examen</h1>

          <!-- Form to Edit -->
          <div class="card mb-4">
            <div class="card-body">
              <form method="POST">
                <div class="form-group row mb-3">
                  <div class="col-xl-6">
                    <label>Classe</label>
                    <input type="text" name="classId" value="<?php echo $row['classId']; ?>" class="form-control" required>
                  </div>
                  <div class="col-xl-6">
                    <label>Jour</label>
                    <select name="jour" class="form-control">
                      <option value="LUNDI" <?php if ($row['jour'] == "LUNDI") echo "selected"; ?>>Lundi</option>
                      <option value="MARDI" <?php if ($row['jour'] == "MARDI") echo "selected"; ?>>Mardi</option>
                      <option value="MERCREDI" <?php if ($row['jour'] == "MERCREDI") echo "selected"; ?>>Mercredi</option>
                      <option value="JEUDI" <?php if ($row['jour'] == "JEUDI") echo "selected"; ?>>Jeudi</option>
                      <option value="VENDREDI" <?php if ($row['jour'] == "VENDREDI") echo "selected"; ?>>Vendredi</option>
                      <option value="SAMEDI" <?php if ($row['jour'] == "SAMEDI") echo "selected"; ?>>Samedi</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <div class="col-xl-6">
                    <label>Période</label>
                    <select name="periode" class="form-control">
                      <option value="1" <?php if ($row['periode'] == "1") echo "selected"; ?>>08:30 - 11:00</option>
                      <option value="2" <?php if ($row['periode'] == "2") echo "selected"; ?>>11:00 - 13:30</option>
                      <option value="3" <?php if ($row['periode'] == "3") echo "selected"; ?>>13:30 - 16:00</option>
                      <option value="4" <?php if ($row['periode'] == "4") echo "selected"; ?>>16:00 - 18:30</option>
                    </select>
                  </div>
                  <div class="col-xl-6">
                    <label>Matière</label>
                    <input type="text" name="matiere" value="<?php echo $row['matiere']; ?>" class="form-control" required>
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <div class="col-xl-6">
                    <button type="submit" name="update" class="btn btn-success">Modifier</button>
                    <a href="emploiTempst.php" class="btn btn-secondary">Annuler</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <?php include "Includes/footer.php"; ?>
        </div>
      </div>

      <script src="../vendor/jquery/jquery.min.js"></script>
      <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
      <script src="js/ruang-admin.min.js"></script>
</body>

</html>