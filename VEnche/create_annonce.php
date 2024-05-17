<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    // Rediriger l'utilisateur vers la page de connexion
    header("Location: login.php");
    exit;
}

// Récupérer l'ID de l'utilisateur à partir de la session
$utilisateur_id = $_SESSION['utilisateur_id'];

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=enchere', 'root', '');

// Récupération des catégories depuis la base de données
$stmt_categories = $pdo->query('SELECT * FROM categories');
$categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

// Récupération des sous-catégories depuis la base de données
$stmt_sous_categories = $pdo->query('SELECT * FROM subcategories');
$sous_categories = $stmt_sous_categories->fetchAll(PDO::FETCH_ASSOC);

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $categorie_id = $_POST['categorie'];
    $sous_categorie_id = $_POST['sous_categorie'];
    $image = $_FILES['image']['name'];

    // Déplacement de l'image téléchargée vers le dossier souhaité
    move_uploaded_file($_FILES['image']['tmp_name'], 'assets/' . $image);

    // Insertion de la nouvelle annonce dans la base de données avec l'ID de l'utilisateur
    $stmt_insert = $pdo->prepare('INSERT INTO annonces (titre, description, image, prix, category_id, subcategory_id, utilisateur_id) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt_insert->execute([$titre, $description, $image, $prix, $categorie_id, $sous_categorie_id, $utilisateur_id]);

    // Redirection vers la page d'annonces
    header('Location: annonce.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Annonce</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />

    <style>
        /* Style pour le formulaire */
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        /* Style pour les étiquettes */
        label {
            font-weight: bold;
        }

        /* Style pour les champs de saisie */
        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            /* Pour inclure la bordure dans la largeur totale */
        }

        /* Style pour le bouton */
        button[type="submit"] {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Style pour le bouton au survol */
        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Style pour les messages d'erreur */
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Style pour le titre */
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>

</head>

<body>
    <?php include 'navbar.php'; ?><br>
    <section>
        <h1>Créer une Nouvelle Annonce</h1>
        <form action="" method="post" enctype="multipart/form-data">

            <label for="titre">Titre :</label><br>
            <input type="text" id="titre" name="titre"><br>

            <label for="description">Description :</label><br>
            <textarea id="description" name="description"></textarea><br>

            <label for="prix">Prix :</label><br>
            <input type="text" id="prix" name="prix"><br>

            <label for="categorie">Catégorie :</label><br>
            <select name="categorie" id="categorie">
                <?php foreach ($categories as $categorie) : ?>
                    <option value="<?php echo $categorie['id']; ?>"><?php echo $categorie['nom']; ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="sous_categorie">Sous-catégorie :</label><br>
            <select name="sous_categorie" id="sous_categorie">
                <?php foreach ($sous_categories as $sous_categorie) : ?>
                    <option value="<?php echo $sous_categorie['id']; ?>"><?php echo $sous_categorie['nom']; ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="image">Image :</label><br> <!-- Champ pour l'image -->
            <input type="file" id="image" name="image"><br>


            <button type="submit" style="margin-top: 20px;">Créer Annonce</button>

        </form>
    </section>
</body>

</html>