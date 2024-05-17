<?php
session_start();
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=enchere', 'root', '');
// Récupération de l'ID de l'utilisateur à partir de la session
$user_id = isset($_SESSION['utilisateur_id']) ? $_SESSION['utilisateur_id'] : null;


// Récupération de l'ID de l'annonce à partir de la requête GET
$annonce_id = isset($_GET['id']) ? $_GET['id'] : '';

// Traitement de la soumission du formulaire d'enchère
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Vérifier si l'utilisateur est connecté
    if ($user_id) {
        // Validation des données du formulaire (vous pouvez ajouter des validations supplémentaires ici)
        $montant = isset($_POST['montant']) ? $_POST['montant'] : '';

        // Insertion de l'enchère dans la base de données
        $stmt = $pdo->prepare('INSERT INTO encheres (annonce_id, montant, date_enchere, utilisateur_id) VALUES (?, ?, NOW(), ?)');
        $stmt->execute([$annonce_id, $montant, $user_id]);
    } else {
        // Rediriger l'utilisateur vers la page de connexion
        header("Location: login.php");
        exit; // Arrêter l'exécution du script après la redirection
    }
}

// Requête SQL pour récupérer les détails de l'annonce avec les catégories et sous-catégories correspondantes
$stmt = $pdo->prepare('SELECT annonces.*, categories.nom AS nom_categorie, subcategories.nom AS nom_sous_categorie ,utilisateurs.nom AS nom_utilisateur, utilisateurs.prenom AS prenom_utilisateur
                       FROM annonces 
                       INNER JOIN subcategories ON annonces.subcategory_id = subcategories.id 
                       INNER JOIN categories ON subcategories.category_id = categories.id 
                       INNER JOIN utilisateurs ON annonces.utilisateur_id = utilisateurs.id
                       WHERE annonces.id = ?');
$stmt->execute([$annonce_id]);
$annonce = $stmt->fetch(PDO::FETCH_ASSOC);


// Inclure la connexion à la base de données et autres fichiers nécessaires
//include_once 'config.php'; // Changez "config.php" par le fichier contenant la configuration de votre base de données

// Récupérer les enchères de la base de données avec le nom et prénom de l'utilisateur
$stmt = $pdo->prepare('SELECT e.*, u.nom AS nom_utilisateur, u.prenom AS prenom_utilisateur 
                      FROM encheres e 
                      INNER JOIN utilisateurs u ON e.utilisateur_id = u.id 
                      WHERE e.annonce_id = ? 
                      ORDER BY e.date_enchere DESC');
$stmt->execute([$annonce_id]);
$encheres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
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

    <!-- Navigation-->
    <?php include 'navbar.php'; ?>

</head>


<body>
    <section class="page-section bg-light" id="portfolio">
        <div class="container mt-4">
        <a href="annonce.php">            <div class="close-modal" id="closeButton" data-bs-dismiss="modal"><img src="assets/img/image.png" alt="Close modal" width="40" height="40" /></div>
</a>

            <div class="text-center">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="container">
                            <div class="row">
                                <!-- Colonne pour l'image de l'annonce -->
                                <div class="col-lg-8">
                                    <div class="modal-body">
                                        <?php if (isset($annonce) && $annonce !== null) : ?>
                                            <h2><?php echo htmlspecialchars($annonce['titre']); ?></h2>
                                            <p>Publié le <?php echo htmlspecialchars($annonce['duree']); ?> par <?php echo htmlspecialchars($annonce['prenom_utilisateur']); ?> <?php echo htmlspecialchars($annonce['nom_utilisateur']); ?></p>
                                            <?php
                                            // Vérifier si le lien de l'image est externe ou local
                                            $imageUrl = $annonce['image'];
                                            if (strpos($imageUrl, 'http://') === 0 || strpos($imageUrl, 'https://') === 0) {
                                                // Si c'est un lien externe, utiliser le lien directement
                                                echo "<img src='$imageUrl' alt='Annonce Image' style='max-width: 100%; height: auto;'>";
                                            } else {
                                                // Sinon, c'est une image stockée localement dans le dossier "assets"
                                                echo "<img src='assets/$imageUrl' alt='Annonce Image' style='max-width: 100%; height: auto;'>";
                                            }
                                            ?>
                                            <p>Catégorie: <?php echo htmlspecialchars($annonce['nom_categorie']); ?></p>
                                            <p>Sous-catégorie: <?php echo htmlspecialchars($annonce['nom_sous_categorie']); ?></p>
                                            <p>Prix: <?php echo htmlspecialchars($annonce['prix']); ?> TND</p>
                                            <p>Superficie: <?php echo htmlspecialchars($annonce['superficie']); ?> m²</p>
                                            <p>Description: <?php echo htmlspecialchars($annonce['description']); ?></p>



                                        <?php else : ?>
                                            <p>Aucun détail d'annonce trouvé.</p>
                                        <?php endif; ?>
                                        <br>
                                        <!-- Bouton de suppression -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal">Supprimer</button>




                                        <!-- Bouton de modification -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modifierAnnonceModal">
                                            Modifier
                                        </button>
                                    </div>
                                </div>
                                <!-- Colonne pour le formulaire d'enchère -->
                                <div class="col-lg-4">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <!-- Formulaire pour soumettre une enchère -->
                                            <h5 class="card-title">Enchère</h5>
                                            <form method="post" action="">
                                                <input type="hidden" name="annonce_id" value="<?php echo htmlspecialchars($annonce_id); ?>">
                                                <div class="mb-3">
                                                    <label for="montant" class="form-label">Votre mise</label>
                                                    <input type="text" class="form-control" id="montant" name="montant" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Soumettre une enchère</button>
                                            </form>
                                        </div>
                                    </div>


                                    <!-- Colonne pour la liste des enchères -->

                                    <div class="card">
                                        <div class="card-body">
                                            <!-- Liste des enchères -->
                                            <h5 class="card-title">Liste des enchères</h5>
                                            <ul class="list-group list-group-flush">
                                                <?php foreach ($encheres as $enchere) : ?>
                                                    <li class="list-group-item">
                                                        <div>
                                                            <strong>Mise:</strong> <?php echo $enchere['montant']; ?> TND<br>
                                                            <strong>Date:</strong> <?php echo $enchere['date_enchere']; ?><br>
                                                            <strong>Par:</strong> <?php echo $enchere['prenom_utilisateur'] . ' ' . $enchere['nom_utilisateur']; ?>
                                                        </div>

                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- Intégration du code JavaScript -->
                                <script>
                                    // Écouteur d'événement pour les clics sur les boutons d'édition
                                    document.querySelectorAll('.edit-btn').forEach(btn => {
                                        btn.addEventListener('click', function() {
                                            const enchereId = this.getAttribute('data-id');
                                            // Rediriger vers la page d'édition avec l'ID de l'enchère
                                            window.location.href = `edit_enchere.php?id=${enchereId}`;
                                        });
                                    });

                                    // Écouteur d'événement pour les clics sur les boutons de suppression
                                    document.querySelectorAll('.delete-btn').forEach(btn => {
                                        btn.addEventListener('click', function() {
                                            if (confirm('Voulez-vous vraiment supprimer cette enchère ?')) {
                                                const enchereId = this.getAttribute('data-id');
                                                // Effectuer une requête AJAX pour supprimer l'enchère
                                                fetch(`delete_enchere.php?id=${enchereId}`, {
                                                    method: 'DELETE'
                                                }).then(response => {
                                                    if (response.ok) {
                                                        // Recharger la page pour refléter les changements
                                                        window.location.reload();
                                                    }
                                                });
                                            }
                                        });
                                    });
                                </script>

                            </div>
                            <!-- Ajout du conteneur pour les nouvelles enchères -->
                            <div id="encheres-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal de modification de l'annonce -->
    <div class="modal fade" id="modifierAnnonceModal" tabindex="-1" aria-labelledby="modifierAnnonceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifierAnnonceModalLabel">Modifier l'annonce</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenu de formulaire de modification d'annonce -->
                    <form action="modifier_annonce.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $annonce['id']; ?>">
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre :</label>
                            <input type="text" name="titre" id="titre" class="form-control" value="<?php echo $annonce['titre']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description :</label>
                            <textarea name="description" id="description" class="form-control"><?php echo $annonce['description']; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="prix" class="form-label">Prix :</label>
                            <input type="text" name="prix" id="prix" class="form-control" value="<?php echo $annonce['prix']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="categorie" class="form-label">Catégorie :</label>
                            <select name="categorie" id="categorie" class="form-select">
                                <?php
                                // Récupération des catégories depuis la base de données
                                $stmt_categories = $pdo->query('SELECT * FROM categories');
                                while ($categorie = $stmt_categories->fetch(PDO::FETCH_ASSOC)) {
                                    // Pré-sélection de la catégorie associée à l'annonce
                                    $selected = ($annonce['nom_categorie'] == $categorie['nom']) ? 'selected' : '';
                                    echo '<option value="' . $categorie['id'] . '" ' . $selected . '>' . $categorie['nom'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sous_categorie" class="form-label">Sous-catégorie :</label>
                            <select name="sous_categorie" id="sous_categorie" class="form-select">
                                <?php
                                // Récupération des sous-catégories depuis la base de données
                                $stmt_sous_categories = $pdo->query('SELECT * FROM subcategories');
                                while ($sous_categorie = $stmt_sous_categories->fetch(PDO::FETCH_ASSOC)) {
                                    // Pré-sélection de la sous-catégorie associée à l'annonce
                                    $selected = ($annonce['nom_sous_categorie'] == $sous_categorie['nom']) ? 'selected' : '';
                                    echo '<option value="' . $sous_categorie['id'] . '" ' . $selected . '>' . $sous_categorie['nom'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

 <!-- Modal de suppression de l'annonce -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmation de suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cette annonce ?
            </div>
            <div class="modal-footer">
                <!-- Bouton pour annuler l'action -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <!-- Bouton pour confirmer l'action -->
                <form id="deleteForm" action="supprimer_annonce.php" method="post" style="display: inline;">
                    <input type="hidden" name="id" value="<?php echo $annonce['id']; ?>">
                    <button type="submit" class="btn btn-danger">Confirmer</button>
                </form>
            </div>
        </div>
    </div>
</div>




    <!-- Intégration du code JavaScript -->
    <script>
        // Fonction pour récupérer les nouvelles enchères
        function getNewEncheres() {
            // Utilisation de fetch pour envoyer une requête GET au serveur
            fetch('fetch_enchere.php?id=<?php echo $annonce_id; ?>')
                .then(response => response.json())
                .then(data => {
                    // Sélection de l'élément où les nouvelles enchères seront affichées
                    let encheresContainer = document.getElementById('encheres-container');
                    // Effacement du contenu précédent
                    encheresContainer.innerHTML = '';
                    // Parcours des données récupérées et création des éléments HTML pour chaque enchère
                    data.forEach(enchere => {
                        let enchereElement = document.createElement('div');
                        enchereElement.classList.add('enchere');
                        enchereElement.innerHTML = ` `;


                        // Ajout de l'élément enchère au conteneur
                        encheresContainer.appendChild(enchereElement);
                    });
                });
        }

        // Appeler la fonction getNewEncheres toutes les 5 secondes
        setInterval(getNewEncheres, 5000);
    </script>
    <script>
        // Sélectionnez le bouton de fermeture
        var closeButton = document.getElementById('closeButton');
        // Ajoutez un événement de clic au bouton de fermeture
        closeButton.addEventListener('click', function() {
            // Cachez la modal
            document.querySelector('.modal-content').style.display = 'none';
        });
    </script>
    <script>
        document.getElementById("annonceDetailsModal_closeButton").addEventListener("click", function() {
            var modal = document.getElementById("annonceDetailsModal");
            modal.modal('hide');
        });
    </script>

<script>
    // Récupérer le formulaire de suppression
    var deleteForm = document.getElementById('deleteForm');

    // Écouter l'événement du clic sur le bouton de confirmation
    document.getElementById('confirmModal').addEventListener('click', function() {
        // Soumettre le formulaire de suppression lors de la confirmation
        deleteForm.submit();
    });
</script>



</body>
<?php include 'footer.php'; ?>


</html>
