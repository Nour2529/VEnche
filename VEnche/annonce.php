<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonces</title>

        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->

        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>


        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet"/>
        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.mni.css" rel="stylesheet">
        <style>
        .button-container {
            margin-bottom: 20px;
            /* Ajustez cet espacement comme vous le souhaitez */
        }
        </style>
</head>
<body>

    <!-- Navigation-->
    <?php include 'navbar.php'; ?>
    <!-- Bouton "Ajouter une annonce" -->
    <!-- Bouton "Ajouter une annonce" -->

     <!-- Single Page Header start -->
    
    
    <section class="page-section" id="portfolio">
    <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">L'Élégance de l'Immobilier</h1>
           
        </div>
        <?php


        // Connexion à la base de données
        $pdo = new PDO('mysql:host=localhost;dbname=enchere','root','');
        $minPrice=0;
        $maxQuery ="SELECT MAX(prix) as prix
        FROM annonces";
        $maxStatement = $pdo->query($maxQuery);
        $m=$maxStatement->fetch(PDO::FETCH_ASSOC);
        $max=$m['prix'];
        $maxPrice=$max;
        $titre="";
        if (isset($_GET['min'])) {
            $minPrice=$_GET['min'];
        }
        if (isset($_GET['max'])) {
            $maxPrice=$_GET['max'];
        }
        if (isset($_GET['titre'])) {
            $titre=$_GET['titre'];
        }
        if (isset($_GET['subCategorieId'])) {
            $subCategorieId = $_GET['subCategorieId'];
            
            // Requête SQL avec des paramètres
            $query = "SELECT annonces.*, subcategories.nom AS nom_sous_categorie, subcategories.description AS description_sous_categorie 
                        FROM annonces 
                        INNER JOIN subcategories ON annonces.subcategory_id = subcategories.id
                        WHERE subcategories.id = :subCategorieId AND annonces.prix >= :minPrice AND annonces.prix <= :maxPrice AND annonces.titre LIKE :titre";
            
            // Préparation de la requête
            $statement = $pdo->prepare($query);
            
            // Liaison des valeurs aux paramètres
            $statement->bindValue(':subCategorieId', $subCategorieId, PDO::PARAM_INT);
            $statement->bindValue(':minPrice', $minPrice, PDO::PARAM_INT);
            $statement->bindValue(':maxPrice', $maxPrice, PDO::PARAM_INT);
            $statement->bindValue(':titre', '%' . $titre . '%', PDO::PARAM_STR);
         } else {
           // Requête SQL avec un paramètre à la place de '%'
            $query ="SELECT annonces.*, subcategories.nom AS nom_sous_categorie, subcategories.description AS description_sous_categorie 
            FROM annonces 
            INNER JOIN subcategories ON annonces.subcategory_id = subcategories.id
            WHERE annonces.prix >= :minPrice AND annonces.prix <= :maxPrice AND annonces.titre LIKE :titre";

            // Préparation de la requête
            $statement = $pdo->prepare($query);

            // Liaison des valeurs aux paramètres
            $statement->bindValue(':minPrice', $minPrice, PDO::PARAM_INT);
            $statement->bindValue(':maxPrice', $maxPrice, PDO::PARAM_INT);
            $statement->bindValue(':titre', '%' . $titre . '%', PDO::PARAM_STR);

            // Exécution de la requête
        }        

        //$statement = $pdo->query($query);
        $statement->execute();






        ?>
                <!-- Fruits Shop Start-->
        <div class="container-fluid fruite">
            <div class="container pt-2">
                <h1 class="mb-4">Annonces</h1>
                <div class="container-fluid button-container">
                    <div class="row justify-content-end">
                        <div class="col-4">
                            <a href="create_annonce.php" class="btn btn-primary" > + Ajouter une annonce</a>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-light mb-2"><a href="annonce.php" style="color: grey; text-decoration: none;">Réinitialiser</a></button>


                        <div class="row g-4">
                        <div class="col-xl-3">
                            <div class="input-group w-100 mx-auto d-flex">
                                <input id="searchInput" type="search" class="form-control p-3" placeholder=<?php 
                                if($titre!==""){
                                    echo $titre;
                                }else{
                                    echo "Rechercher";
                                }?>  aria-describedby="search-icon-1">
                                <span id="searchIcon" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                            
                        <div class="row g-4">
                            <div class="col-lg-3">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="col-lg-12 d-none d-lg-block">
                                            <?php
                                            // Connexion à la base de données
                                            $pdo = new PDO('mysql:host=localhost;dbname=enchere','root','');

                                            // Requête pour récupérer les annonces avec les noms des sous-catégories
                                            $query = "SELECT *
                                                    FROM categories ";

                                            $categories = $pdo->query($query);
                                            while ($category = $categories->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                            
                                                <div>

                                                    <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical1" style="height: 40px; margin-top: -1px; padding: 0 30px;">
                                                        <h6 class="m-0"><?php echo $category['nom'] ?></h6>                                                    </a>
                                                    <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical1">
                                                        <div class="navbar-nav w-100 overflow-hidden" >
                                                        
                                                <?php   
                                                $categoryId = $category['id'];

                                                $querySubCategories = "SELECT *
                                                FROM subcategories
                                                WHERE category_id= $categoryId ";
                                                $subcategories = $pdo->query($querySubCategories);


                                                    while ($subcategory = $subcategories->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                         <a href="annonce.php?subCategorieId=<?php 
                                                         if($titre!==""){
                                                            echo $subcategory['id']."&titre=".$titre;
                                                        }else{
                                                            echo $subcategory['id'];
                                                        }
                                                         ?> " class="nav-item nav-link ml-2"><?php echo $subcategory['nom'] ?></a>

                                                        <?php
                                                    }
                                                    ?>
                                                    </div>
                                                </nav>
                                                </div>

                                                    <?php

                                                }

                                                

                                            ?>

                                           
                                                
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h4 class="mb-2">Prix</h4>
                                            <label for="minPrice">Prix minimum:</label>
                                            <div class="row">
                                               <div class="col-8">
                                               <input type="range" class="form-range" id="rangeInput" name="rangeInput" min="0" max="<?= $max ?>" value="<?= $minPrice ?>" oninput="amount.value=rangeInput.value">
                                               </div>
                                               <div class="col-4">
                                               <output id="amount" name="amount"><?= $minPrice ?></output>
                                               </div>
                                            </div>
                                            <label for="maxPrice">Prix maximum:</label>

                                            <div class="row">
                                                <div class="col-8">
                                                <input type="range" class="form-range" id="maxPrice" name="maxPrice" min="0" max="<?= $max ?>" value="<?= $maxPrice ?>" oninput="maxAmount.value=maxPrice.value">

                                                </div>

                                                <div class="col-4">
                                                <output id="maxAmount" name="maxAmount"><?= $maxPrice ?></output>

                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="row g-4 justify-content-center">  
                                    

                                        <?php

                                        // Parcourir les résultats de la requête
                                        while ($announce = $statement->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <div class="col-md-6 col-lg-6 col-xl-4">
                                                <div class="rounded position-relative fruite-item">
                                                    <div class="fruite-img">
                                                        <?php
                                                        // Vérifier si le lien de l'image est externe ou local
                                                        $imageUrl = $announce['image'];
                                                        if (strpos($imageUrl, 'http://') === 0 || strpos($imageUrl, 'https://') === 0) {
                                                            // Si c'est un lien externe, utiliser le lien directement
                                                            echo "<img class='img-fluid w-100 rounded-top' style='height: 200px' src='$imageUrl' alt='Annonce'>";
                                                        } else {
                                                            // Sinon, c'est une image stockée localement dans le dossier "assets"
                                                            echo "<img class='img-fluid w-100 rounded-top' style='height: 200px' src='assets/$imageUrl' alt='Annonce'>";
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?php echo $announce['nom_sous_categorie']; ?></div>
                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                        <h4><?php echo $announce['titre']; ?></h4>
                                                        <p>
                                                            <?php
                                                            $paragrapheCourt = substr($announce['description'], 0, 60);

                                                            $paragrapheCourt .= '...';
                                                            echo $paragrapheCourt ?></p>
                                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                                            <p class="text-dark fs-5 fw-bold mb-0"><?php echo $announce['prix']; ?> TND</p>
                                                            <a  href='annonce_details.php?id=<?php echo $announce['id']; ?>' data-toggle='modal' data-target='#exampleModal-<?php echo $announce['id']; ?>' class="btn border border-secondary rounded-pill px-3 text-primary" ><i class="fa fa-eye me-2 text-primary"></i> Voir detail</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/scripts.js"></script>

</body>
<?php include 'footer.php'; ?>

</html>
