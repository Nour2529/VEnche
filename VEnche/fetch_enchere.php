<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=enchere', 'root', '');

// Récupération de l'ID de l'annonce à partir de la requête GET
$annonce_id = isset($_GET['id']) ? $_GET['id'] : '';

// Requête SQL pour récupérer les nouvelles enchères
$stmt = $pdo->prepare('SELECT * FROM enchere WHERE annonce_id = ? ORDER BY date_enchere  DESC LIMIT 5');
$stmt->execute([$annonce_id]);
$encheres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Envoi des données au format JSON
header('Content-Type: application/json');
echo json_encode($encheres);
?>
