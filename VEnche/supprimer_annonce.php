<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=enchere','root','');

// Vérification de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération de l'ID de l'annonce à supprimer depuis le formulaire
    $annonce_id = isset($_POST['id']) ? $_POST['id'] : '';

    // Suppression de l'annonce de la base de données
    $stmt = $pdo->prepare('DELETE FROM annonces WHERE id = ?');
    $stmt->execute([$annonce_id]);

    // Redirection vers une page de confirmation ou une autre page appropriée
    header('Location: annonce.php');
    exit;
}
?>
