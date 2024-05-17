<?php
session_start();
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=enchere', 'root', '');

// Vérification de l'authentification de l'utilisateur
if (!isset($_SESSION['utilisateur_id'])) {
    // Rediriger l'utilisateur vers la page de connexion si non authentifié
    header("Location: login.php");
    exit();
}

// Vérification si l'identifiant de l'enchère est passé en paramètre
if (isset($_GET['id'])) {
    $enchere_id = $_GET['id'];
    
    // Suppression de l'enchère de la base de données
    $stmt = $pdo->prepare('DELETE FROM encheres WHERE id = ?');
    $stmt->execute([$enchere_id]);
}

// Redirection vers une page de succès ou de liste d'enchères
header("Location: list_encheres.php");
exit();
?>
