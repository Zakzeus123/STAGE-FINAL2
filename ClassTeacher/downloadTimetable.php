<?php
require 'vendor/autoload.php';
include '../Includes/dbcon.php';
include '../Includes/session.php';



$teacherId = $_SESSION['userId'];

// Récupérer les infos du professeur
$teacherQuery = mysqli_query($conn, "SELECT firstName, lastName, emailAddress FROM tblclassteacher WHERE id = '$teacherId'");
$teacher = mysqli_fetch_assoc($teacherQuery);

if (!$teacher) {
    die("Erreur : Professeur introuvable !");
}

$scheduleQuery = mysqli_query($conn, "
    SELECT s.day, t.termName, c.className, ca.classArmName, s.subject
    FROM tblschedule s
    JOIN tblterm t ON s.termId = t.id
    JOIN tblclass c ON s.classId = c.id
    JOIN tblclassarms ca ON s.classArmId = ca.id
    WHERE s.teacherId = '$teacherId'
    ORDER BY s.day, s.classId, s.classArmId
");

if (mysqli_num_rows($scheduleQuery) == 0) {
    die("Aucun emploi du temps trouvé !");
}

// Création du PDF
$pdf = new FPDF();
$pdf->AddPage();

// Titre
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Emploi du Temps - Enseignant', 0, 1, 'C');
$pdf->Ln(5);

// Infos du professeur
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, "Nom du professeur : " . utf8_decode($teacher['firstName'] . ' ' . $teacher['lastName']), 0, 1);
$pdf->Cell(0, 10, "Email : " . utf8_decode($teacher['emailAddress']), 0, 1);
$pdf->Ln(10);

// En-tête du tableau
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 10, '#', 1, 0, 'C');
$pdf->Cell(30, 10, 'Jour', 1, 0, 'C');
$pdf->Cell(40, 10, 'Session', 1, 0, 'C');
$pdf->Cell(40, 10, 'Classe', 1, 0, 'C');
$pdf->Cell(30, 10, 'Section', 1, 0, 'C');
$pdf->Cell(40, 10, 'Matière', 1, 1, 'C');

// Contenu du tableau
$pdf->SetFont('Arial', '', 12);
$sn = 1;
while ($row = mysqli_fetch_assoc($scheduleQuery)) {
    $pdf->Cell(20, 10, $sn, 1, 0, 'C');
    $pdf->Cell(30, 10, utf8_decode($row['day']), 1, 0, 'C');
    $pdf->Cell(40, 10, utf8_decode($row['termName']), 1, 0, 'C');
    $pdf->Cell(40, 10, utf8_decode($row['className']), 1, 0, 'C');
    $pdf->Cell(30, 10, utf8_decode($row['classArmName']), 1, 0, 'C');
    $pdf->Cell(40, 10, utf8_decode($row['subject']), 1, 1, 'C');
    $sn++;
}

// Signature
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Signature du Directeur : ___________________', 0, 1);

// Téléchargement du PDF
$pdf->Output('D', 'Emploi_du_Temps_' . $teacher['lastName'] . '.pdf'); 
?>
