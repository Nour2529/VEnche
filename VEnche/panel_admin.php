<?php
session_start();

// Vérifier si l'administrateur est connecté
if (!isset($_SESSION["admin_id"])) {
    header("Location: login_admin.php");
    exit();
}
$pdo = new PDO('mysql:host=localhost;dbname=enchere','root','');
// Inclure le fichier de configuration de la base de données
//include_once 'config.php';

// Récupérer la liste des utilisateurs depuis la base de données
$stmt = $pdo->prepare('SELECT * FROM utilisateurs');
$stmt->execute();
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    <script src="js/scripts.js"></script>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />

    <!-- Navigation-->
    <?php include 'navbar.php'; ?>

</head>
    <title>VEnche</title>
</head>

<body>
    <h1>Liste des utilisateurs</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <!-- Ajoutez d'autres colonnes si nécessaire -->
        </tr>
        <?php foreach ($utilisateurs as $utilisateur) : ?>
            <tr>
                <td><?php echo $utilisateur['id']; ?></td>
                <td><?php echo $utilisateur['nom']; ?></td>
                <td><?php echo $utilisateur['prenom']; ?></td>
                <td><?php echo $utilisateur['email']; ?></td>
                <!-- Ajoutez d'autres cellules si nécessaire -->
            </tr>
        <?php endforeach; ?>
    </table>
</body>
<?php include 'footer.php'; ?>

</html>
