<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'model.php';
require_once 'auth.php';

function home_action() {
    if (!isSupporter()) {
        header('Location: /Supporters/login');
        exit;
    }

    $matches = getMatches();
    include 'templates/Supporters/home.php';
}

function booking_action($matchId) {
    if (!isSupporter()) {
        header('Location: /Supporters/login?redirect=/booking/' . $matchId);
        exit;
    }

    $match = getMatchById($matchId);
    if (!$match) {
        http_response_code(404);
        echo "Match non trouvé.";
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $seats = (int)$_POST['seats'];

        try {
            createReservation($matchId, $name, $surname, $email, $seats);
            header('Location: /home');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    include 'templates/Supporters/booking.php';
}