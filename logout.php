<?php
require_once 'functions.php';

// Déconnexion simple : destruction de la session uniquement
// Le compte utilisateur reste dans la base de données (conforme à la section 4.6 du TP)
if (isLoggedIn()) {
    session_destroy();
}

redirect(BASE_URL . 'login.php');
