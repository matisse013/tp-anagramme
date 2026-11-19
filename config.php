<?php
// Démarrage de la session
session_start();

// Connexion PDO à MySQL (WAMP : root sans mot de passe par défaut)
$host = 'localhost';
$dbname = 'tp_anagramme';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Chemin racine du projet
define('BASE_URL', '/tp-anagramme/');
