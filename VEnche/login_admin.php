<?php
session_start();

// Vérifier si l'administrateur est déjà connecté, le rediriger vers la page d'administration
if (isset($_SESSION["admin_id"])) {
    header("Location: panel_admin.php");
    exit();
}
$pdo = new PDO('mysql:host=localhost;dbname=enchere', 'root', '');
// Inclure le fichier de configuration de la base de données
//include_once 'config.php';

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Requête pour récupérer les informations de l'administrateur depuis la base de données
    $stmt = $pdo->prepare('SELECT id, email, mot_de_passe FROM administrateurs WHERE email = ?');
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (password_verify($password, $admin['mot_de_passe'])) {
        // Authentification réussie, créer une session pour l'administrateur
        $_SESSION['admin_id'] = $admin['id'];
        // Rediriger vers la page d'administration
        header("Location: panel_admin.php"); // Correction de la redirection
        exit();
    }
    

    // Vérifier si un administrateur a été trouvé avec cet email
    if ($admin) {
        // Vérifier si le mot de passe correspond
        if (password_verify($password, $admin['mot_de_passe'])) {
            // Authentification réussie, créer une session pour l'administrateur
            $_SESSION['admin_id'] = $admin['id'];
            // Rediriger vers la page d'administration
            header("Location: panel_admin.php");
            exit();
        } else {
            // Mot de passe incorrect
            $error_message = "Mot de passe incorrect";
        }
    } else {
        // Aucun administrateur trouvé avec cet email
        $error_message = "Aucun administrateur trouvé avec cet email";
    }
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
            <div class="col-lg-5">
                <div class="card justify-content-center mt-5">
                    <div class="card-body justify-content-center mt-5">
                        <h1 class="card-title text-center mb-7">Connexion administrateur</h1>
                        <?php if (isset($error_message)) : ?>
                            <p class="text-danger text-center"><?php echo $error_message; ?></p>
                        <?php endif; ?>
                        <form action="panel_admin.php" method="POST">
                        <div class="mb-3">
                                <label for="email" class="form-label">Email :</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe :</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Se connecter</button>
                            </div>
                        </form>
                        <p class="text-center mt-3">Vous n'avez pas de compte ? <br><a href="register_admin.php">Inscrivez-vous maintenant</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>