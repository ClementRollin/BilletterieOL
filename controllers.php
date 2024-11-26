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
            // Créer la réservation
            createReservation($matchId, $name, $surname, $email, $seats);

            // Générer le PDF
            require_once 'utils/pdf_generator.php';
            $pricePerSeat = getPrice($matchId);
            $logos = [
                'home' => $match['home_logo'],
                'away' => $match['away_logo']
            ];
            $pdfContent = generateTicketPDF($name, $surname, $match['name'], $seats, $logos, $pricePerSeat);

            $pdfDirectory = __DIR__ . '/public/pdf/';
            if (!is_dir($pdfDirectory)) {
                mkdir($pdfDirectory, 0755, true);
            }

            $files = glob($pdfDirectory . '*.pdf');
            $now = time();

            foreach ($files as $file) {
                if (is_file($file) && $now - filemtime($file) >= 86400) {
                    unlink($file);
                }
            }

            // Enregistrer le fichier PDF
            $pdfFileName = 'ticket_' . uniqid('', true) . '.pdf';
            $pdfFilePath = $pdfDirectory . $pdfFileName;

            if (file_put_contents($pdfFilePath, $pdfContent) === false) {
                throw new Exception('Impossible d’écrire le fichier PDF.');
            }

            // URL du fichier pour l'accès public
            $pdfUrl = '/public/pdf/' . $pdfFileName;

            // Redirection avec toutes les données nécessaires
            header('Location: /confirmation?name=' . urlencode($name) .
                '&surname=' . urlencode($surname) .
                '&match_id=' . $matchId .
                '&seats=' . $seats .
                '&email=' . urlencode($email) .
                '&pdf=' . urlencode($pdfUrl));
            exit;

        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    include 'templates/Supporters/booking.php';
}