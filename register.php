<?php
require_once 'functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = trim($_POST['pseudo'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($pseudo === '' || $password === '' || $confirm === '') {
        $error = 'Tous les champs sont obligatoires.';
    } elseif (strlen($pseudo) < 3 || strlen($pseudo) > 50) {
        $error = 'Le pseudonyme doit contenir entre 3 et 50 caractères.';
    } elseif ($password !== $confirm) {
        $error = 'Les mots de passe ne correspondent pas.';
    } elseif (strlen($password) < 4) {
        $error = 'Le mot de passe doit contenir au moins 4 caractères.';
    } else {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE pseudo = ?');
        $stmt->execute([$pseudo]);
        if ($stmt->fetch()) {
            $error = 'Ce pseudonyme est déjà utilisé.';
        } else {
            try {
                $pdo->beginTransaction();

                // Un seul compte (plus de reverse)
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare('INSERT INTO users (pseudo, password) VALUES (?, ?)');
                $stmt->execute([$pseudo, $passwordHash]);

                $pdo->commit();
                $success = 'Compte créé avec succès. Vous pouvez vous connecter.';
            } catch (PDOException $e) {
                $pdo->rollBack();
                $error = 'Erreur lors de l inscription : ' . $e->getMessage();
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — Anagramme</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>style.css">
</head>
<body>
    <div class="header">
        <a href="<?= BASE_URL ?>index.php" class="logo">Anagramme</a>
        <a href="<?= BASE_URL ?>login.php" class="btn-connect">Se connecter</a>
    </div>

    <div class="container">
        <div class="form-card">
            <h1>Créer un compte</h1>
            <p class="subtitle">Rejoignez l'application de vérification d'anagrammes.</p>

            <?php if ($error): ?>
                <div class="alert error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="POST" action="" novalidate>
                <div class="form-group">
                    <label class="field-label" for="pseudo">Pseudonyme</label>
                    <div class="field-wrapper">
                        <input type="text" id="pseudo" name="pseudo" required maxlength="50"
                               class="field-input"
                               placeholder="ex: metisse_flow"
                               value="<?= htmlspecialchars($_POST['pseudo'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="field-label" for="password">Mot de passe</label>
                    <div class="field-wrapper">
                        <input type="password" id="password" name="password" required
                               class="field-input"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="form-group">
                    <label class="field-label" for="confirm">Confirmation du mot de passe</label>
                    <div class="field-wrapper">
                        <input type="password" id="confirm" name="confirm" required
                               class="field-input"
                               placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn-submit">S'inscrire</button>
            </form>

            <div class="actions">
                <a href="<?= BASE_URL ?>login.php">Vous avez déjà un compte ? Se connecter</a>
            </div>
        </div>
    </div>
</body>
</html>
