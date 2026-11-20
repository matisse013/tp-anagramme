<?php
require_once 'functions.php';

// Accès libre au vérificateur (pas de requireLogin ici)
$isLoggedIn = isLoggedIn();

$string1 = '';
$string2 = '';
$result = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $string1 = trim($_POST['string1'] ?? '');
    $string2 = trim($_POST['string2'] ?? '');

    if ($string1 === '' || $string2 === '') {
        $error = 'Veuillez remplir les deux champs.';
    } elseif (!isValidString($string1) || !isValidString($string2)) {
        $error = 'Caractères non autorisés. Seules les lettres, chiffres et espaces sont acceptés.';
    } else {
        $result = isAnagram($string1, $string2);

        // Enregistrement en base UNIQUEMENT si l'utilisateur est connecté
        if ($isLoggedIn) {
            $stmt = $pdo->prepare(
                'INSERT INTO verifications (user_id, string1, string2, is_anagram) VALUES (?, ?, ?, ?)'
            );
            $stmt->execute([
                $_SESSION['user_id'],
                $string1,
                $string2,
                $result ? 1 : 0,
            ]);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérificateur d'anagrammes — Anagramme</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>style.css">
</head>
<body>
    <div class="header">
        <a href="#" class="logo">Anagramme</a>
        <?php if ($isLoggedIn): ?>
            <span class="user-info">Bonjour, <?= htmlspecialchars($_SESSION['pseudo']) ?></span>
            <a href="<?= BASE_URL ?>logout.php" class="btn-logout">Déconnexion</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>login.php" class="btn-connect">Se connecter</a>
        <?php endif; ?>
    </div>

    <div class="container">
        <h1>Vérificateur d'anagrammes</h1>
        <p class="subtitle">Saisissez deux chaînes de caractères pour vérifier si elles sont des anagrammes.</p>

        <?php if ($error): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="" novalidate>
            <div class="verify-grid">
                <div class="field-group">
                    <label class="field-label" for="string1">String 1</label>
                    <input type="text" id="string1" name="string1"
                           value="<?= htmlspecialchars($string1) ?>"
                           class="field-input <?= $result === false ? 'border-red' : ($result === true ? 'border-green' : '') ?>"
                           placeholder="ex: anagram"
                           required>
                </div>
                <div class="field-group">
                    <label class="field-label" for="string2">String 2</label>
                    <input type="text" id="string2" name="string2"
                           value="<?= htmlspecialchars($string2) ?>"
                           class="field-input <?= $result === false ? 'border-red' : ($result === true ? 'border-green' : '') ?>"
                           placeholder="ex: nagaram"
                           required>
                </div>
            </div>

            <button type="submit" class="btn-submit">Vérifier les anagrammes</button>
        </form>

        <?php if ($result !== null): ?>
            <div class="result-box <?= $result ? 'success' : 'error' ?>">
                <?= $result
                    ? '✓ Les deux chaînes sont des <strong>anagrammes</strong>'
                    : '✗ Les deux chaînes ne sont <strong>pas des anagrammes</strong>' ?>
            </div>

            <?php if (!$isLoggedIn): ?>
                <div class="alert" style="background:#e2e8f0; color:#475569; border:1px solid #cbd5e1; margin-top:15px;">
                    Connectez-vous pour <strong>enregistrer</strong> cette vérification et consulter votre <strong>historique</strong>.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="actions">
            <?php if ($isLoggedIn): ?>
                <a href="<?= BASE_URL ?>history.php">Voir mon historique des vérifications</a>
            <?php else: ?>
                <a href="<?= BASE_URL ?>login.php">Se connecter pour accéder à l'historique</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
