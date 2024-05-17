<?php
session_start();


// Vérifie si l'utilisateur est déjà connecté, redirige vers une autre page si c'est le cas
if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['user_mail'])) {
?>
        <p class="hello"> Bonjour <?php echo $_SESSION['user_mail']; ?></p>

        <form action="<?= $this->base_url() ?>deconnexion" method="POST">
            <button type="submit">DECONNEXION</button>
        </form>

<?php
        //header("Location: index.php");
        //exit;
    }
}

// Vérifie si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_submit'])) {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=enchere', 'root', '');

    // Validation des données du formulaire (nettoyage)
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['mdp']; // Afin de ne pas altérer le mot de passe

    // Requête pour récupérer les informations de l'utilisateur avec cet email
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérification si l'utilisateur existe et le mot de passe est correct
    if ($user && password_verify($password, $user['mdp'])) {
        // Démarre la session et stocke l'ID et les informations de l'utilisateur dans la session
        session_start();
        $_SESSION['utilisateur_id'] = $user['id'];
        $_SESSION['nom_utilisateur'] = $user['nom'];
        $_SESSION['prenom_utilisateur'] = $user['prenom'];

        // Redirige vers la page du tableau de bord
        header("Location: index.php");
        exit;
    }

    // Vérification si l'utilisateur existe et le mot de passe est correct
    if ($user && password_verify($password, $user['mdp'])) {
        // Démarre la session et stocke l'ID de l'utilisateur
        $_SESSION['utilisateur_id'] = $user['id'];

        // Redirige vers la page du tableau de bord
        header("Location: index.php");
        exit;
    } else {
        // Affiche un message d'erreur si l'authentification échoue
        $error_message = "Identifiants incorrects. Veuillez réessayer.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>VEnche</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        /* CSS pour centrer le formulaire */
        body,
        html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .mainContainer {
            width: 1000 px;
            /* Largeur du formulaire */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
            /* Centrer le titre */
        }

        form {
            text-align: center;
            /* Centrer le formulaire */
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 10px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            text-align: center;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 120vh; /* Hauteur minimum de la fenêtre du navigateur */
        }

        footer {
            width: 100%;
            position:fixed;
            bottom: 0;
            left: 0;
        }
    
    </style>
</head>

<body id="page-top">
    <!-- Navigation-->
    <?php include 'navbar.php'; ?>


    <div class="mainContainer justify-content-center mt-5">
        <div class="row lg-5">
            <div class="col lg-6">

                <section class="page-section bg-light" id="login">
                    <div class="container ">
                        <div class="text-center">
                            <h2>Connexion</h2>
                            <?php if (isset($error_message)) : ?>
                                <p style="color: red;"><?php echo $error_message; ?></p>
                            <?php endif; ?>
                            <form action="" method="POST">
                                <form action="" method="POST">
                                    <div class="card justify-content-center mt-5" style="width: 40rem;">
                                        <div class="card-body">

                                            <label for="email">Email</label>
                                            <input type="email" id="email" name="email" class="form-control" required />
                                            <label for="mdp">Mot de passe</label>
                                            <input type="password" id="mdp" name="mdp" class="form-control" required />
                                            <br>
                                            <input type="submit" name="login_submit" value="Se connecter">
                                </form>
                                <br>
                                <p>Vous n'avez pas de compte ? <br><a href="register.php">Inscrivez-vous maintenant</a>.</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

</body>
<footer><!-- Footer -->
<?php include 'footer.php'; ?> </footer><br>

</html>