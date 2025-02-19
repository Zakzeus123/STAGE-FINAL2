<?php
require 'vendor/autoload.php';
include '../Includes/dbcon.php';
include '../Includes/session.php'; // Inclure la session pour obtenir l'utilisateur connecté

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['userId'])) {
    die("Erreur : Aucun étudiant connecté !");
}

$studentId = intval($_SESSION['userId']); // ID de l'utilisateur connecté

// Récupérer les informations de l'étudiant et de son examen
$query = mysqli_query($conn, "SELECT 
                                tblstudents.firstName, 
                                tblstudents.lastName, 
                                tblclass.className, 
                                tblexams.examDate, 
                                tblexams.examTime, 
                                tblexams.examSubject, 
                                tblexams.examRoom 
                              FROM tblstudents 
                              INNER JOIN tblclass ON tblclass.Id = tblstudents.classId
                              INNER JOIN tblexams ON tblexams.classId = tblclass.Id
                              WHERE tblstudents.Id = '$studentId'");

$row = mysqli_fetch_assoc($query);

if (!$row) {
    die("Erreur : Aucune convocation trouvée !");
}

// Initialiser le PDF
$pdf = new FPDF();
$pdf->AddPage();

// Titre
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Convocation d\'Examen', 0, 1, 'C');
$pdf->Ln(10);

// Informations de l'étudiant
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Nom et Prénom : ' . utf8_decode($row['firstName'] . ' ' . $row['lastName']), 0, 1);
$pdf->Cell(0, 10, 'Classe : ' . utf8_decode($row['className']), 0, 1);
$pdf->Ln(5);

// Détails de l'examen
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Détails de l\'Examen', 0, 1, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Matière : ' . utf8_decode($row['examSubject']), 0, 1);
$pdf->Cell(0, 10, 'Date : ' . date('d/m/Y', strtotime($row['examDate'])), 0, 1);
$pdf->Cell(0, 10, 'Heure : ' . date('H:i', strtotime($row['examTime'])), 0, 1);
$pdf->Cell(0, 10, 'Salle : ' . utf8_decode($row['examRoom']), 0, 1);
$pdf->Ln(10);

// Règles de l'examen
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Règles de l\'Examen', 0, 1, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->MultiCell(0, 8, utf8_decode("- Arrivez 15 minutes avant l'heure de l'examen.\n- Tout retard supérieur à 30 minutes entraîne l'exclusion.\n- L'utilisation de téléphones et de calculatrices non autorisées est interdite.\n- Toute tentative de fraude entraîne l'annulation de l'examen.\n- Apportez votre carte d'étudiant et votre convocation."), 0, 'L');
$pdf->Ln(10);

// Signature
$pdf->Cell(0, 10, 'Signature du Responsable : ___________________', 0, 1);

// Télécharger le PDF
$pdf->Output('D', 'Convocation_' . $row['firstName'] . '.pdf'); 

?>
