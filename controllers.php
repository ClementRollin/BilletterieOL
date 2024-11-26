<?php
require_once 'model.php';
require_once __DIR__ . '/utils/pdf_generator.php';
require_once 'auth.php';


function home_action()
{
    $matches = getMatches();
    include 'templates/home.php';
}

function booking_action($matchId)
{
    if(!isAuthenticated()) {
        header('Location: /Supporters/login?redirect=/booking/' . $matchId);
        exit();
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

            $logos = [
                'home' => $match['home_logo'] ?? '',
                'away' => $match['away_logo'] ?? ''
            ];
            $pricePerSeat = $match['price'] ?? 0;

            $pdf = generateTicketPDF($name, $surname, $match['name'], $seats, $logos, $pricePerSeat);

            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="ticket.pdf"');
            echo $pdf;
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    include 'templates/booking.php';
}

function get_logos($home, $away)
{
    return [
        'home' => $home,
        'away' => $away,
    ];
}
?>