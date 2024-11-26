<?php
require_once 'controllers.php';

// Récupération de l'URI
$requestUri = strtok($_SERVER['REQUEST_URI'], '?');

// Routes principales
if ($requestUri === '/' || $requestUri === '/register') {
    include 'templates/register.php'; // Nouvelle page d'inscription par défaut
    exit;
} elseif ($requestUri === '/home') {
    home_action(); // Page d'accueil avec la liste des matchs pour les supporters
    exit;
} elseif (preg_match('/^\/booking\/(\d+)$/', $requestUri, $matches)) {
    booking_action((int)$matches[1]); // Réservation d'un match
    exit;
} elseif ($requestUri === '/Supporters/login') {
    include 'templates/Supporters/login.php'; // Connexion supporter
    exit;
} elseif ($requestUri === '/Admin/login') {
    include 'templates/Admin/login.php'; // Connexion admin
    exit;
} elseif ($requestUri === '/logout') {
    include 'templates/logout.php'; // Déconnexion
    exit;
} elseif ($requestUri === '/admin/dashboard') {
    include 'templates/Admin/dashboard.php'; // Dashboard admin
    exit;
} else {
    // Page 404 par défaut
    http_response_code(404);
    echo "Page non trouvée.";
    exit;
}
?>