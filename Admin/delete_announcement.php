<?php
session_start();
include '../Includes/dbcon.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['announcement_id'])) {
    $announcement_id = intval($_POST['announcement_id']); // Secure ID input

    // Delete query
    $query = "DELETE FROM tblannonces WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $announcement_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Annonce supprimée avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de la suppression de l'annonce.";
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the announcement page
    header("Location: voirAnnonce.php");
    exit();
} else {
    $_SESSION['error'] = "Requête invalide.";
    header("Location: voirAnnonce.php");
    exit();
}
?>
  
    
