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
    
    // Vérification si l'enchère existe dans la base de données
    $stmt = $pdo->prepare('SELECT * FROM encheres WHERE id = ?');
    $stmt->execute([$enchere_id]);
    $enchere = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$enchere) {
        // Rediriger l'utilisateur vers une page d'erreur ou de liste d'enchères par exemple
        header("Location: list_encheres.php");
        exit();
    }
} else {
    // Rediriger l'utilisateur vers une page d'erreur ou de liste d'enchères par exemple
    header("Location: list_encheres.php");
    exit();
}

// Traitement de la soumission du formulaire d'édition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $montant = isset($_POST['montant']) ? $_POST['montant'] : '';

    // Mise à jour de l'enchère dans la base de données
    $stmt = $pdo->prepare('UPDATE encheres SET montant = ? WHERE id = ?');
    $stmt->execute([$montant, $enchere_id]);

    // Redirection vers une page de succès ou de détails de l'enchère
    header("Location: encheres_details.php?id=".$enchere_id);
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VEnche</title>
    <!-- Mettez ici vos liens vers les fichiers CSS -->
</head>
<body>
    <h1>Modifier une enchère</h1>
    <form method="post" action="">
        <div>
            <label for="montant">Nouveau montant :</label>
            <input type="text" id="montant" name="montant" value="<?php echo $enchere['montant']; ?>" required>
        </div>
        <button type="submit">Enregistrer les modifications</button>
    </form>
</body>
</html>
