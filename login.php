<?php
require_once 'functions.php';

if (isLoggedIn()) {
    redirect(BASE_URL . 'index.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = trim($_POST['pseudo'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($pseudo === '' || $password === '') {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        $stmt = $pdo->prepare('SELECT id, pseudo, password FROM users WHERE pseudo = ?');
        $stmt->execute([$pseudo]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['pseudo'] = $user['pseudo'];
            redirect(BASE_URL . 'index.php');
        } else {
            $error = 'Pseudonyme ou mot de passe incorrect.';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Anagramme</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>style.css">
</head>
<body>
    <div class="header">
        <a href="<?= BASE_URL ?>index.php" class="logo">Anagramme</a>
    </div>

    <div class="container">
        <div class="form-card">
            <h1>Connexion</h1>
            <p class="subtitle">Connectez-vous à votre compte pour accéder à votre historique.</p>

            <?php if ($error): ?>
                <div class="alert error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" action="" novalidate>
                <div class="form-group">
                    <label class="field-label" for="pseudo">Pseudonyme</label>
                    <div class="field-wrapper">
                        <input type="text" id="pseudo" name="pseudo" required
                               class="field-input"
                               value="<?= htmlspecialchars($_POST['pseudo'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="field-label" for="password">Mot de passe</label>
                    <div class="field-wrapper">
                        <input type="password" id="password" name="password" required
                               class="field-input">
                    </div>
                </div>

                <button type="submit" class="btn-submit">Se connecter</button>
            </form>

            <div class="actions">
                <a href="<?= BASE_URL ?>register.php">Vous n'avez pas encore de compte ? S'inscrire</a>
            </div>
        </div>
    </div>
</body>
</html>
