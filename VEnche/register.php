<?php
session_start();

// Vérifie si le formulaire d'inscription a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_submit'])) {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=enchere', 'root', '');

    // Validation des données du formulaire (nettoyage)
    $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
    $prenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['mdp'], PASSWORD_DEFAULT);// PASSWORD_DEFAULT); // Hachage du mot de passe
    $region = filter_var($_POST['region'], FILTER_SANITIZE_STRING);
    $pays = filter_var($_POST['pays'], FILTER_SANITIZE_STRING);
    $adresse = filter_var($_POST['adresse'], FILTER_SANITIZE_STRING);
    $numero_tel = filter_var($_POST['numero_tel'], FILTER_SANITIZE_STRING);

    // Requête pour insérer un nouvel utilisateur dans la base de données
    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, mdp,  region, pays, adresse, numero_tel) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $email, $password, $region, $pays, $adresse, $numero_tel]);

    // Redirige vers la page de connexion après l'inscription
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

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
            height: 130%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #mainContainer {
            width: 600px;
            /* Largeur du formulaire */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .bloc-formulaire-inscription {
            text-align: center;
            margin-top: 50px;
        }

        /* Ajout de styles pour les étiquettes */
        label {
            display: block;
            /* Affiche chaque étiquette sur une nouvelle ligne */
            text-align: center;
            /* Centre le texte de l'étiquette */
            margin-bottom: 10px;
            /* Ajoute de l'espace en bas de chaque étiquette */
        }

        /* Ajout de styles pour les champs de texte */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 80%;
            /* Définit la largeur des champs de texte à 100% */
            padding: 10px;
            /* Ajoute de l'espace autour du texte dans les champs */
            margin-bottom: 10px;
            /* Ajoute de l'espace en bas de chaque champ de texte */
            box-sizing: border-box;
            /* Inclut le padding et la bordure dans la largeur totale */
        }

        /* Ajout de styles pour le bouton */
        button {
            width: 100%;
            /* Définit la largeur du bouton à 100% */
            padding: 10px;
            /* Ajoute de l'espace autour du texte dans le bouton */
            background-color: #007bff;
            /* Couleur de fond du bouton */
            color: #fff;
            /* Couleur du texte du bouton */
            border: none;
            /* Supprime la bordure du bouton */
            border-radius: 4px;
            /* Arrondit les coins du bouton */
            cursor: pointer;
            /* Change le curseur en pointeur au survol */
        }

        /* Styles supplémentaires pour le bouton au survol */
        button:hover {
            background-color: #0056b3;
            /* Couleur de fond du bouton au survol */

        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Hauteur minimum de la fenêtre du navigateur */
        }

        footer {
            margin-top: auto; /* Le footer sera toujours en bas de la page */
        }
    </style>
      <!-- Navigation-->
      <?php include 'navbar.php'; ?><br>
</head>

<body id="page-top">
<div id="mainContainer"><br>
    <div >
            <div class="bloc-formulaire-inscription" ><br>
                <div class="inscription justify-content-center mt-7">
                    <h1>CREATION DE COMPTE</h1>
                    <?php if (!isset($result)) { ?>
                        <p>
                            Pour créer un compte, veuillez remplir le formulaire ci-dessous et valider.
                        </p>
                    <?php } else if ($result === true) { ?>
                        <p>Votre compte a bien été enregistré.</p>
                    <?php } else { ?>
                        <p>Une erreur s'est produite, veuillez réessayer.</p>
                    <?php } ?>
                </div>
                <div class="inscription-input">
                    <form action="" method="POST">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" required />

                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" required />

                        <label for="region">Région</label>
                        <input type="text" id="region" name="region" />

                        <label for="pays">Pays</label>
                        <input type="text" id="pays" name="pays"  />

                        <label for="adresse">Adresse</label>
                        <input type="text" id="adresse" name="adresse" required />

                        <label for="numero_tel">Numéro de téléphone</label>
                        <input type="tel" id="numero_tel" name="numero_tel" required />

                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required />

                        <label for="mdp">Mot de passe</label>
                        <input type="password" id="mdp" name="mdp" required />


                        <button type="submit" name="register_submit">Valider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
<?php include 'footer.php'; ?>

</html>
