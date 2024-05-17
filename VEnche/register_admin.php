<?php
session_start();
// Inclure le fichier de configuration de la base de données
//include_once 'config.php';
$pdo = new PDO('mysql:host=localhost;dbname=enchere','root','');
// Vérifier si le formulaire d'inscription a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Hasher le mot de passe avant de le stocker dans la base de données
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Requête pour insérer le nouvel administrateur dans la base de données
    $stmt = $pdo->prepare('INSERT INTO administrateurs (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)');
    $stmt->execute([$nom, $prenom, $email, $hashed_password]);

    // Rediriger vers la page de connexion après l'inscription
    header("Location: login_admin.php");
    exit();
}
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


    <title>VEnche</title>
</head>

<body>
    <div class="container justify-content-center mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-6">
                <div class="card justify-content-center mt-5">
                    <div class="card-body justify-content-center mt-5">
                        <h1 class="card-title text-center mb-9">Inscription administrateur</h1>
                        <form action="register_admin.php" method="POST">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom :</label>
                                <input type="text" id="nom" name="nom" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="prenom" class="form-label">Prénom :</label>
                                <input type="text" id="prenom" name="prenom" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email :</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe :</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">S'inscrire</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include 'footer.php'; ?>

</html>
