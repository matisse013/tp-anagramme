<?php
require_once 'functions.php';

// Consigne du TP : la déconnexion entraîne la suppression de l'utilisateur de la base de données
if (isLoggedIn()) {
    $userId = $_SESSION['user_id'];

    try {
        $pdo->beginTransaction();

        // Supprimer l'historique des vérifications de l'utilisateur
        $stmt = $pdo->prepare('DELETE FROM verifications WHERE user_id = ?');
        $stmt->execute([$userId]);

        // Supprimer l'utilisateur
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$userId]);

        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        // On continue quand même pour détruire la session
    }

    session_destroy();
}

redirect(BASE_URL . 'login.php');
