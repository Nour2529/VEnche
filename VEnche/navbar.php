<html>
    <!-- Navigation-->
    <nav class="navbar navbar-marketing navbar-expand-lg shadow bg-black navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <!--logo -->
        <!--<a class="navbar-brand" href="#page-top"><img src="assets/img/navbar-logo.svg" alt="..." /></a>-->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">

                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="annonce.php">Annonce</a></li>
                <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
<!--                 <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#team">Team</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li> -->
                <br>
                <!-- Dropdown avec les informations de l'utilisateur et le bouton de déconnexion -->
                <li class="nav-item dropdown">
                    <?php if (isset($_SESSION["utilisateur_id"])) { ?>
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo isset($_SESSION['prenom_utilisateur']) && isset($_SESSION["nom_utilisateur"]) ? '<i class="fas fa-user fa-fw"></i> ' . $_SESSION["prenom_utilisateur"] . " " . $_SESSION["nom_utilisateur"] : "Utilisateur"; ?>
</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <form action="profil.php" method="POST">
                                <button type="submit" class="dropdown-item"><i class="fa fa-cog"></i>  Profil</button>
                            </form>
  
                            <form action="logout.php" method="POST">
                                <button type="submit" class="dropdown-item"> <i class="fa fa-sign-out" aria-hidden="true"></i>  Déconnexion</button>
                            </form>
                        </div>
                    <?php } else { ?>
        <a class="nav-link dropdown-toggle" href="#" id="loginDropdownToggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Connexion
        </a>
        <div class="dropdown-menu" aria-labelledby="loginDropdownToggle">
        <form action="login.php" method="POST">
                                <button type="submit" class="dropdown-item">  Espace utilisateur</button>
                            </form>
                            <form action="login_admin.php" method="POST">
                                <button type="submit" class="dropdown-item">  Espace administrateur</button>
                            </form>
           
        </div>
    <?php } ?>
</li>
            </ul>
        </div>
    </div>
</nav>
</html>