<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;

function generateTicketPDF($name, $surname, $matchName, $seats, $logos)
{
    $dompdf = new Dompdf();

    // Autoriser les ressources distantes
    $dompdf->set_option('isRemoteEnabled', true);

    $html = "
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            width: 100%;
            padding: 20px;
            text-align: center;
        }
        .header {
            background-color: #003DA5;
            color: white;
            padding: 20px 0;
        }
        .header h1 {
            margin: 0;
        }
        .logos {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }
        .logos img {
            max-width: 100px;
            margin: 0 20px;
        }
        .details {
            text-align: left;
            background-color: white;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 70%;
        }
        .details h2 {
            color: #003DA5;
            margin-bottom: 10px;
        }
        .details p {
            margin: 8px 0;
            font-size: 14px;
            color: #333;
        }
        .footer {
            margin-top: 20px;
            color: #888;
            font-size: 12px;
        }
    </style>
    <div class='container'>
        <div class='header'>
            <h1>Billet Olympique Lyonnais</h1>
        </div>
        <div class='logos'>
            <img src='{$logos['home']}' alt='Logo équipe domicile'>
            <h2>VS</h2>
            <img src='{$logos['away']}' alt='Logo équipe extérieure'>
        </div>
        <div class='details'>
            <h2>Détails du billet</h2>
            <p><strong>Match :</strong> {$matchName}</p>
            <p><strong>Nom :</strong> {$name} {$surname}</p>
            <p><strong>Nombre de places :</strong> {$seats}</p>
        </div>
        <div class='footer'>
            <p>Merci pour votre réservation. Rendez-vous au Groupama Stadium !</p>
        </div>
    </div>
    ";

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    return $dompdf->output();
}