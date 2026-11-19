-- =====================================================================
-- TP RIT/SIL — Script de création de la base de données
-- Vérificateur d'anagrammes avec PHP & MySQL (PDO)
-- =====================================================================

CREATE DATABASE IF NOT EXISTS tp_anagramme CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tp_anagramme;

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table de l'historique des vérifications
CREATE TABLE IF NOT EXISTS verifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    string1 VARCHAR(255) NOT NULL,
    string2 VARCHAR(255) NOT NULL,
    is_anagram TINYINT(1) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- Instructions d'importation (phpMyAdmin ou ligne de commande) :
--
-- 1. Lancez WAMP (Apache + MySQL).
-- 2. Ouvrez http://localhost/phpmyadmin
-- 3. Créez une base de données nommée tp_anagramme (ou importez ce fichier).
-- 4. Exécutez ce script SQL dans l'onglet SQL.
-- =====================================================================
