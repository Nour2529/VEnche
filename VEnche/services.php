<?php
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VEnche </title>

     <!-- Favicon-->
     <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
     <!-- Font Awesome icons (free version)-->
     <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
     <!-- Google fonts-->
     <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
     <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
     <!-- Core theme CSS (includes Bootstrap)-->
     <link href="css/styles.css" rel="stylesheet" />
     <?php include 'navbar.php'; ?><br>
</head>
<body>
    <section class="page-section" id="services">
    <div class="container-fluid page-header py-5">
    <div class="text-center">
                <h2 class="section-heading text-uppercase" style="color: white; text-decoration: none;">Services</h2>
                <h3 class="section-subheading" style="color: white; text-decoration: none;">Nous proposons une gamme de services pour faciliter la vente et l'achat des immobiliers</h3>
            </div>           
        </div>
        <div class="row mt-4"></div>
        <div class="container">
            
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-shopping-cart fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Mise en vente des immobiliers</h4>
                    <p class="text-muted"> Notre Site permet aux vendeurs de publier leurs biens sur la plateforme, offrant une visibilité accrue aux biens mis en vente. Grâce à des descriptions détaillées, des photos et parfois même des visites virtuelles, les vendeurs peuvent présenter leurs propriétés de manière attrayante aux acheteurs potentiels.</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-laptop fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Organisation des enchères </h4>
                    <p class="text-muted">Ces sites fournissent une plateforme pour l'organisation d'enchères en ligne, offrant aux acheteurs la possibilité de faire des offres sur les biens qui les intéressent. Les enchères sont souvent régies par des règles strictes visant à assurer la transparence et l'équité, et peuvent être ouvertes à tous ou limitées à des acheteurs qualifiés.</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-lock fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Assistance et soutien</h4>
                    <p class="text-muted">Notre Site offre souvent un soutien complet tout au long du processus d'enchères et de vente. Cela peut inclure des conseils sur la tarification initiale, l'assistance juridique pour la rédaction de contrats, la coordination des inspections et des évaluations, ainsi que l'aide à la clôture de la transaction. Ce service vise à rendre le processus d'achat et de vente aussi fluide que possible pour toutes les parties impliquées.</p>
                </div>
            </div>
        </div>
    </section>
    
</body>
<footer>
<?php include 'footer.php'; ?>
</footer>
</html>
