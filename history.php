<?php
require_once 'functions.php';
requireLogin();

// Récupération de l'historique de l'utilisateur connecté
$stmt = $pdo->prepare(
    'SELECT string1, string2, is_anagram, created_at 
     FROM verifications 
     WHERE user_id = ? 
     ORDER BY created_at DESC'
);
$stmt->execute([$_SESSION['user_id']]);
$verifications = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon historique — Anagramme</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>style.css">
</head>
<body>
    <div class="header">
        <a href="<?= BASE_URL ?>index.php" class="logo">Anagramme</a>
        <span style="font-size: 0.85rem; color: #64748b;">Bonjour, <?= htmlspecialchars($_SESSION['pseudo']) ?></span>
        <a href="<?= BASE_URL ?>logout.php" class="btn-connect">Déconnexion</a>
    </div>

    <div class="container">
        <h1>Mon historique des vérifications</h1>

        <a href="<?= BASE_URL ?>index.php" class="btn-secondary">Nouvelle vérification</a>

        <?php if (empty($verifications)): ?>
            <p style="margin-top: 20px; text-align: center; color: #64748b;">
                Aucun historique pour le moment.
            </p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>String 1</th>
                        <th>String 2</th>
                        <th>Résultat</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($verifications as $index => $v): ?>
                        <tr>
                            <td><?= htmlspecialchars($index + 1) ?></td>
                            <td><?= htmlspecialchars($v['string1']) ?></td>
                            <td><?= htmlspecialchars($v['string2']) ?></td>
                            <td>
                                <span style="<?= $v['is_anagram'] ? 'color:#166534' : 'color:#991b1b'; ?> font-weight:600;">
                                    <?= $v['is_anagram'] ? 'Anagrammes ✓' : 'Pas des anagrammes ✗' ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($v['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
