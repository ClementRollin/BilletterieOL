<?php
error_log("Données reçues dans confirmation.php : " . json_encode($_GET));

$name = $_GET['name'] ?? null;
$surname = $_GET['surname'] ?? null;
$matchId = $_GET['match_id'] ?? null;
$seats = $_GET['seats'] ?? null;
$email = $_GET['email'] ?? null;
$pdf = $_GET['pdf'] ?? null;

// Chargez les informations du match
require_once __DIR__ . '/../../model.php';
$match = $matchId ? getMatchById($matchId) : null;

// Validation
if (!$name || !$surname || !$match || !$seats || !$email) {
    echo "Erreur : données manquantes ou invalides.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Réservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .ol-primary {
            background-color: #003DA5;
            color: white;
        }
        .ol-secondary {
            background-color: #E30613;
            color: white;
        }
        .ol-accent {
            color: #E30613;
        }
        .card-header.ol-primary {
            border-bottom: 5px solid #E30613;
        }
        .btn-primary {
            background-color: #003DA5;
            border-color: #003DA5;
        }
        .btn-primary:hover {
            background-color: #002b7f;
            border-color: #002b7f;
        }
        .btn-secondary {
            background-color: #E30613;
            border-color: #E30613;
        }
        .btn-secondary:hover {
            background-color: #a5040e;
            border-color: #a5040e;
        }
        .list-group-item {
            font-size: 16px;
        }
        .list-group-item strong {
            color: #003DA5;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header ol-primary text-center">
            <h2>Réservation Confirmée</h2>
        </div>
        <div class="card-body">
            <p class="mb-3 text-center">Merci <strong><?= htmlspecialchars($name) ?> <?= htmlspecialchars($surname) ?></strong> pour votre réservation.</p>
            <p class="mb-3 text-center">Voici les détails de votre réservation :</p>

            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>Match :</strong> <?= htmlspecialchars($match['name']) ?></li>
                <li class="list-group-item"><strong>Date :</strong> <?= htmlspecialchars($match['match_date']) ?></li>
                <li class="list-group-item"><strong>Nombre de places :</strong> <?= htmlspecialchars($seats) ?></li>
                <li class="list-group-item"><strong>Email :</strong> <?= htmlspecialchars($email) ?></li>
            </ul>

            <p class="mb-4 text-center">Un billet électronique au format PDF vous a été généré. Vous pouvez le télécharger ci-dessous :</p>

            <div class="d-flex justify-content-center">
                <a href="<?= htmlspecialchars($pdf) ?>" class="btn btn-primary me-3" target="_blank">Afficher le billet</a>
                <a href="/home" class="btn btn-secondary">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>