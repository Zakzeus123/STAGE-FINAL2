<?php
require 'vendor/autoload.php';
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['userId'])) {
    die("Erreur : Aucun étudiant connecté !");
}

$studentId = intval($_SESSION['userId']); // ID de l'étudiant connecté

// Récupérer les informations de l'étudiant
$query = mysqli_query($conn, "SELECT firstName, lastName FROM tblstudents WHERE Id = '$studentId'");
if (!$row = mysqli_fetch_assoc($query)) {
    die("Erreur : Étudiant non trouvé !");
}

$studentName = $row['firstName'] . " " . $row['lastName'];

// Définition des coefficients
$coefficients = [
    'controle' => 1,
    'EFM' => 3,
    'regional' => 5
];

// Récupérer les notes de l'étudiant
$queryGrades = mysqli_query($conn, "SELECT subject, controle, EFM, regional FROM tblnotes WHERE studentId = '$studentId'");

$gradesData = [];
$totalGrades = 0;
$subjectCount = 0;

while ($data = mysqli_fetch_assoc($queryGrades)) {
    $totalWeighted = 0;
    $totalCoeff = 0;

    foreach ($coefficients as $type => $coef) {
        if (!is_null($data[$type])) {
            $totalWeighted += $data[$type] * $coef;
            $totalCoeff += $coef;
        }
    }

    $finalGrade = ($totalCoeff > 0) ? round($totalWeighted / $totalCoeff, 2) : 0;

    $gradesData[] = [
        'subject' => $data['subject'],
        'finalGrade' => $finalGrade
    ];

    $totalGrades += $finalGrade;
    $subjectCount++;
}

$generalAverage = ($subjectCount > 0) ? round($totalGrades / $subjectCount, 2) : 0;

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

// En-tête du tableau
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(90, 10, 'Matière', 1, 0, 'C');
$pdf->Cell(50, 10, 'Note Finale', 1, 1, 'C');

// Affichage des notes
$pdf->SetFont('Arial', '', 10);
foreach ($gradesData as $data) {
    $pdf->Cell(90, 10, utf8_decode($data['subject']), 1, 0, 'C');
    $pdf->Cell(50, 10, $data['finalGrade'] . "/20", 1, 1, 'C');
}

// Affichage de la moyenne générale
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(10);
$pdf->Cell(190, 10, 'Moyenne Générale: ' . $generalAverage . "/20", 0, 1, 'C');

// Ajouter la date et signature
$pdf->Ln(15);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 10, 'Fait a Ista Khemisset, le ' . date('d/m/Y'), 0, 1, 'L');
$pdf->Ln(15);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, 'Signature du Directeur', 0, 1, 'R');
$pdf->Ln(15);

// Ajouter un espace pour la signature
$pdf->Line(150, $pdf->GetY(), 190, $pdf->GetY());

// Génération et téléchargement du PDF
$pdf->Output('D', 'Releve_Notes_' . str_replace(' ', '_', $studentName) . '.pdf');
exit;
?>
