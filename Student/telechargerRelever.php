<?php
require 'vendor/autoload.php';
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['userId'])) {
    die("Erreur : Aucun étudiant connecté !");
}

$studentId = intval($_SESSION['userId']); // ID de l'utilisateur connecté

// Récupérer les informations de l'étudiant
$query = mysqli_query($conn, "SELECT firstName, lastName FROM tblstudents WHERE Id = '$studentId'");
if (!$row = mysqli_fetch_assoc($query)) {
    die("Erreur : Étudiant non trouvé !");
}

$studentName = $row['firstName'] . " " . $row['lastName'];

// Récupérer les notes de l'étudiant avec la bonne structure
$queryGrades = mysqli_query($conn, "SELECT id, classId, sessionTermId, studentId, subject, note, noteType, classArmId, notes FROM tblgrades WHERE studentId = '$studentId'");

$gradesData = [];

while ($data = mysqli_fetch_assoc($queryGrades)) {
    $gradesData[] = $data;
}

// Création du PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Titre
$pdf->Cell(190, 10, 'Relevé de Notes', 0, 1, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 10, 'Année Scolaire : 2024/2025', 0, 1, 'L');
$pdf->Cell(190, 10, 'Nom de l\'étudiant : ' . utf8_decode($studentName), 0, 1, 'L');
$pdf->Ln(5);

// En-tête du tableau (correspondant à la base de données)
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 10, 'ID', 1, 0, 'C');
$pdf->Cell(15, 10, 'Class', 1, 0, 'C');
$pdf->Cell(25, 10, 'Session', 1, 0, 'C');

$pdf->Cell(25, 10, 'Matière', 1, 0, 'C');
$pdf->Cell(15, 10, 'Note', 1, 0, 'C');
$pdf->Cell(25, 10, 'Type', 1, 0, 'C');
$pdf->Cell(20, 10, 'ClassArm', 1, 0, 'C');
$pdf->Cell(30, 10, 'Remarque', 1, 1, 'C');

// Affichage des notes
$pdf->SetFont('Arial', '', 10);
foreach ($gradesData as $data) {
    $pdf->Cell(10, 10, $data['id'], 1, 0, 'C');
    $pdf->Cell(15, 10, $data['classId'], 1, 0, 'C');
    $pdf->Cell(25, 10, $data['sessionTermId'], 1, 0, 'C');
    
    $pdf->Cell(25, 10, utf8_decode($data['subject']), 1, 0, 'C');
    $pdf->Cell(15, 10, $data['note'], 1, 0, 'C');
    $pdf->Cell(25, 10, $data['noteType'], 1, 0, 'C');
    $pdf->Cell(20, 10, $data['classArmId'], 1, 0, 'C');
    $pdf->Cell(30, 10, utf8_decode($data['notes']), 1, 1, 'C');
}

// Ajouter la date et signature
$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 10, 'Fait à [Nom de l\'École], le ' . date('d/m/Y'), 0, 1, 'L');
$pdf->Ln(15);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, 'Signature du Directeur', 0, 1, 'R');
$pdf->Ln(15);

// Ajouter un espace pour la signature
$pdf->Line(150, $pdf->GetY(), 190, $pdf->GetY()); // Ligne pour la signature

// Génération et téléchargement du PDF
$pdf->Output('D', 'Releve_Notes_' . str_replace(' ', '_', $studentName) . '.pdf');
exit;
?>
