<?php
require_once 'config.php';

/**
 * Détermine si deux chaînes sont des anagrammes.
 * Complexité temporelle : O(n log n) à cause du tri.
 * Complexité spatiale : O(n).
 */
function isAnagram(string $s1, string $s2): bool
{
    // Nettoyage : supprimer les espaces et mettre en minuscules
    $clean1 = strtolower(str_replace(' ', '', $s1));
    $clean2 = strtolower(str_replace(' ', '', $s2));

    // Si les longueurs diffèrent, ce ne sont pas des anagrammes
    if (strlen($clean1) !== strlen($clean2)) {
        return false;
    }

    // Tri des caractères puis comparaison
    return str_split($clean1) === str_split($clean2) ||
           implode('', str_split($clean1)) === implode('', str_split($clean2)) ||
           (function () use ($clean1, $clean2) {
               $arr1 = str_split($clean1);
               $arr2 = str_split($clean2);
               sort($arr1);
               sort($arr2);
               return $arr1 === $arr2;
           })();
}

/**
 * Vérifie qu'une chaîne ne contient que des caractères autorisés
 * (lettres, chiffres, espaces).
 */
function isValidString(string $s): bool
{
    return preg_match('/^[a-zA-Z0-9À-ÿ\s]*$/', $s) === 1;
}

/**
 * Redirige vers une URL et arrête l'exécution.
 */
function redirect(string $url): void
{
    header("Location: $url");
    exit;
}

/**
 * Vérifie si l'utilisateur est connecté.
 */
function isLoggedIn(): bool
{
    return !empty($_SESSION['user_id']);
}

/**
 * Exige une connexion, redirige vers le login sinon.
 */
function requireLogin(): void
{
    if (!isLoggedIn()) {
        redirect(BASE_URL . 'login.php');
    }
}
