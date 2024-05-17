<?php
// Inclure le fichier de configuration de la base de données et initialiser la session
//include_once 'config.php';
session_start();
try {
    // Paramètres de connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=enchere', 'root', '');
    // Configuration des options PDO pour afficher les erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En cas d'erreur, affichage du message d'erreur
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    // Arrêt du script
    exit();
}


// Vérifier si l'utilisateur est connecté, sinon le rediriger vers la page de connexion
if (!isset($_SESSION["utilisateur_id"])) {
    header("Location: login.php");
    exit();
}

// Récupérer les informations de l'utilisateur depuis la base de données
$stmt = $pdo->prepare('SELECT * FROM utilisateurs WHERE id = ?');
$stmt->execute([$_SESSION['utilisateur_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


// Traitement du formulaire de mise à jour des informations du compte
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_info'])) {
    // Validation des données (vous pouvez ajouter des validations supplémentaires ici)
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $region = isset($_POST['region']) ? $_POST['region'] : '';
    $pays = isset($_POST['pays']) ? $_POST['pays'] : '';
    $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';
    $numero_tel = isset($_POST['numero_tel']) ? $_POST['numero_tel'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Mettre à jour les informations dans la base de données
    $stmt = $pdo->prepare('UPDATE utilisateurs SET nom = ?, prenom = ?, region = ?, pays = ?, adresse = ?, numero_tel = ? WHERE id = ?');
    $stmt->execute([$nom, $prenom, $region, $pays, $adresse, $numero_tel, $_SESSION['utilisateur_id']]);

  // Lorsque l'utilisateur met à jour son mot de passe
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    // Validate and retrieve form data
    $mdp = isset($_POST['mdp']) ? $_POST['mdp'] : '';
    $nouveau_mdp = isset($_POST['nouveau_mdp']) ? $_POST['nouveau_mdp'] : '';
    $confirm_mdp = isset($_POST['confirm_mdp']) ? $_POST['confirm_mdp'] : '';

    if ($nouveau_mdp === $confirm_mdp) {
        // Update both hashed and unhashed password fields
        $hashed_password = password_hash($nouveau_mdp, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE utilisateurs SET mdp = ?, mdp_non_hashed = ? WHERE id = ?');
        $stmt->execute([$hashed_password, $nouveau_mdp, $_SESSION['utilisateur_id']]);
        // Redirect to profile page after password change
        header("Location: parametres.php");
        exit();
    } else {
        // Handle password mismatch error
        $password_error = "Erreur : Mot de passe incorrect ou la confirmation du nouveau mot de passe ne correspond pas.";
    }
}
    // Rediriger vers la page de profil après la mise à jour
    header("Location: profil.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'navbar.php'; ?><br>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VEnche</title>
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
</head>

<body>
    <?php include 'navbar.php'; ?><br>
    <form action="parametres.php" method="POST">
        <div class="card mx-auto mt-4" style="width: 40rem;">
            <div class="card-body">
                <h5 class="card-title">Profil</h5>
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom :</label>
                    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="region" class="form-label">Région :</label>
                    <input type="text" id="region" name="region" value="<?php echo htmlspecialchars($user['region']); ?>" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="pays" class="form-label">Pays :</label>
                    <input type="text" id="pays" name="pays" value="<?php echo htmlspecialchars($user['pays']); ?>" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="adresse" class="form-label">Adresse :</label>
                    <input type="text" id="adresse" name="adresse" value="<?php echo htmlspecialchars($user['adresse']); ?>" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="numero_tel" class="form-label">Numéro de téléphone :</label>
                    <input type="tel" id="numero_tel" name="numero_tel" value="<?php echo htmlspecialchars($user['numero_tel']); ?>" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-control" readonly>
                </div>
                
                <button type="submit" name="update_info" class="btn btn-primary">Modifier Vos informations</button>
            </div>
        </div>
    </form>
</body>

</html>

    <br><!--
    <form action="profil.php" method="POST">
        <div class="card mx-auto mt-4" style="width: 40rem;">
            <div class="card-body">
                <h5 class="card-title">Changer le Mot de passe</h5>
                <div class="mb-3">
                    <label for="mdp" class="form-label">Mot de passe actuel :</label>
                    <input type="password" id="mdp" name="mdp" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nouveau_mdp" class="form-label">Nouveau Mot de passe :</label>
                    <input type="password" id="nouveau_mdp" name="nouveau_mdp" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_mdp" class="form-label">Confirmer le mot de passe :</label>
                    <input type="password" id="confirm_mdp" name="confirm_mdp" class="form-control" required>
                </div>
                <?php if (isset($password_error)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $password_error; ?>
                    </div>
                <?php } ?>
                <button type="submit" name="change_password" class="btn btn-primary">Changer le mot de passe</button>
            </div>
        </div>
    </form>-->
</body>
<?php include 'footer.php'; ?>

</html>