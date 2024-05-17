<?php
// Démarre la session
session_start();

// Détruit toutes les variables de session
$_SESSION = array();

// Détruit la session
session_destroy();

// Redirige vers une page appropriée après la déconnexion
header("Location: index.php");
exit;
?>
