<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'controllers.php'; // Inclure les fonctions nécessaires

// Récupération de l'URI sans les paramètres GET
$requestUri = strtok($_SERVER['REQUEST_URI'], '?');

// Debugging log
error_log("Requête : " . $requestUri);
error_log("Session : " . json_encode($_SESSION));

// Gestion des routes principales
switch ($requestUri) {
    case '/':
        include __DIR__ . '/templates/register.php'; // Page d'inscription par défaut
        break;

    case '/home':
    case '/Supporters/home': // Ajout d'une route alternative pour la cohérence
        if (isSupporter()) {
            home_action(); // Page d'accueil pour les supporters
        } else {
            header('Location: /Supporters/login');
        }
        break;

    case '/Supporters/login':
        include __DIR__ . '/templates/Supporters/login.php'; // Page de connexion des supporters
        break;

    case '/Admin/login':
        include __DIR__ . '/templates/Admin/login.php'; // Page de connexion des administrateurs
        break;

    case '/Admin/dashboard':
        if (isAuthenticated() && isAdmin()) {
            $_SESSION['admin_logged_in'] = true;
            include __DIR__ . '/templates/Admin/dashboard.php'; // Dashboard admin
        } else {
            header('Location: /Admin/login');
        }
        break;

    case '/generate-pdf':
        if (isSupporter() && isset($_GET['match_id'])) {
            $matchId = (int)$_GET['match_id'];
            $name = $_GET['name'];
            $surname = $_GET['surname'];
            $seats = (int)$_GET['seats'];

            $match = getMatchById($matchId);
            if ($match) {
                $logos = [
                    'home' => $match['home_logo'],
                    'away' => $match['away_logo']
                ];
                $pricePerSeat = getPrice($matchId);

                require_once 'utils/pdf_generator.php';
                $pdfContent = generateTicketPDF($name, $surname, $match['name'], $seats, $logos, $pricePerSeat);

                header('Content-Type: application/pdf');
                echo $pdfContent;
                exit;
            }
        }
        http_response_code(404);
        echo "Page non trouvée.";
        break;

    case '/confirmation':
        include __DIR__ . '/templates/Supporters/confirmation.php';
        break;

    default:
        if (preg_match('/^\\/booking\\/(\\d+)$/', $requestUri, $matches)) {
            booking_action((int)$matches[1]);
        } else {
            http_response_code(404);
            echo "Page non trouvée.";
        }
        break;
}