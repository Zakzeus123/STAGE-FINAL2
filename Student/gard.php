<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../Includes/dbcon.php';
include '../Includes/session.php';

$studentName = null;
$gradesList = [];
$coefficients = [
  'controle' => 1,
  'Projet' => 1,
  'regional' => 5,
  'Examen' => 3
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['emailAddress'])) {
  $emailAddress = mysqli_real_escape_string($conn, $_POST['emailAddress']);

  $query = mysqli_query($conn, "SELECT firstName, lastName FROM tblstudents WHERE emailAddress = '$emailAddress'");
  if ($row = mysqli_fetch_assoc($query)) {
    $studentName = $row['firstName'] . " " . $row['lastName'];

    $queryGrades = mysqli_query($conn, "SELECT g.subject, g.note, g.noteType, g.notes
                                            FROM tblgrades g
                                            WHERE g.studentId = (SELECT Id FROM tblstudents WHERE emailAddress = '$emailAddress')");

    $gradesData = [];
    while ($data = mysqli_fetch_assoc($queryGrades)) {
      $subject = $data['subject'];
      $note = floatval($data['note']);
      $type = $data['noteType'];
      $remark = $data['notes'];

      if (!isset($gradesData[$subject])) {
        $gradesData[$subject] = [
          'controle' => '-',
          'Projet' => '-',
          'regional' => '-',
          'Examen' => '-',
          'finalGrade' => 0,
          'totalCoefficient' => 0,
          'remark' => $remark
        ];
      }

      $gradesData[$subject][$type] = $note;

      if (isset($coefficients[$type])) {
        $gradesData[$subject]['finalGrade'] += $note * $coefficients[$type];
        $gradesData[$subject]['totalCoefficient'] += $coefficients[$type];
      }
    }

    foreach ($gradesData as $subject => $data) {
      $gradesData[$subject]['finalGrade'] = ($data['totalCoefficient'] > 0) ? round($data['finalGrade'] / $data['totalCoefficient'], 2) : 0;
    }

    $gradesList = $gradesData;
  } else {
    $errorMsg = "L'e-mail est incorrect ou il n'y a pas d'étudiant avec cet e-mail.";
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
  <?php include 'includes/title.php'; ?>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <style>
    .card-body {
  padding-top: 0; /* إزالة التباعد العلوي */
}

.table {
  margin-top: 0; /* إزالة التباعد العلوي من الجدول */
}

.card-header h6 {
  margin-bottom: 0; /* إزالة المسافة بين العنوان والـ card */
  line-height: 1.2; /* تعديل المسافة بين السطور داخل العنوان */
}
  </style>

  <script>
    function typeDropDown(str) {
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
        xmlhttp.open("GET", "ajaxCallTypes.php?tid=" + str, true);
        xmlhttp.send();
      }
    }
  </script>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include "Includes/sidebar.php"; ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div>
        <?php include "Includes/topbar.php"; ?>
      </div>

      <!-- Container Fluid-->
      <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Consulter les Notes</h1>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Notes de l'Étudiant</li>
          </ol>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="card mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Saisir l'Email de l'Étudiant</h6>
              </div>
              <div class="card-body">
                <form method="post">
                  <div class="form-group">
                    <label for="emailAddress">Entrez votre Email :</label>
                    <input type="email" name="emailAddress" id="emailAddress" class="form-control" required>
                  </div>
                  <button type="submit" class="btn btn-primary">Afficher les Notes</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <?php if (isset($studentName) && !empty($gradesList)) { ?>
          <div class="row ">
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Notes de <strong><?php echo htmlspecialchars($studentName); ?></strong></h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th>Matière</th>
                        <th>Contrôle</th>
                        <th>Projet</th>
                        <th>Régional</th>
                        <th>Examen</th>
                        <th>Note Finale</th>
                        <th>Remarque</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($gradesList as $subject => $data) { ?>
                        <tr>
                          <td><?= htmlspecialchars($subject) ?></td>
                          <td><?= is_numeric($data['controle']) ? $data['controle'] : '-' ?></td>
                          <td><?= is_numeric($data['Projet']) ? $data['Projet'] : '-' ?></td>
                          <td><?= is_numeric($data['regional']) ? $data['regional'] : '-' ?></td>
                          <td><?= is_numeric($data['Examen']) ? $data['Examen'] : '-' ?></td>
                          <td><strong><?= $data['finalGrade'] ?>/20</strong></td>
                          <td><?= htmlspecialchars($data['remark']) ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        <?php } elseif (isset($errorMsg)) { ?>
          <div class="alert alert-danger"><?= $errorMsg ?></div>
        <?php } ?>


      </div>
      <?php include "Includes/footer.php"; ?>
    </div>
  </div>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>