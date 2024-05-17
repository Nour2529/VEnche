<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=enchere','root','');

// Récupération des données soumises via le formulaire
$id = $_POST['id'];
$titre = $_POST['titre'];
$description = $_POST['description'];
$prix = $_POST['prix'];
$categorie_id = $_POST['categorie'];
$sous_categorie_id = $_POST['sous_categorie'];

// Mise à jour de l'annonce dans la base de données
$stmt = $pdo->prepare('UPDATE annonces SET titre = ?, description = ?, prix = ?, category_id = ?, subcategory_id = ? WHERE id = ?');
$stmt->execute([$titre, $description, $prix, $categorie_id, $sous_categorie_id, $id]);

// Redirection vers une page de confirmation ou une autre page appropriée
header('Location: annonce.php');
exit;
?>
