<?php ob_start(); ?>
<h2 class="text-success mb-4">Réservation confirmée !</h2>
<p class="mb-3">Merci <strong><?= htmlspecialchars($name) ?> <?= htmlspecialchars($surname) ?></strong> pour votre réservation.</p>
<p class="mb-3">Voici les détails de votre réservation :</p>

<ul class="list-group mb-4">
    <li class="list-group-item"><strong>Match :</strong> <?= htmlspecialchars($match['name']) ?></li>
    <li class="list-group-item"><strong>Date :</strong> <?= htmlspecialchars($match['match_date']) ?></li>
    <li class="list-group-item"><strong>Nombre de places :</strong> <?= htmlspecialchars($seats) ?></li>
    <li class="list-group-item"><strong>Email :</strong> <?= htmlspecialchars($email) ?></li>
</ul>

<p class="mb-4">Un billet électronique au format PDF vous a été envoyé à l'adresse <strong><?= htmlspecialchars($email) ?></strong>. Vous pouvez le télécharger ci-dessous :</p>

<a href="/generate-pdf/<?= htmlspecialchars($match['id']) ?>?name=<?= urlencode($name) ?>&surname=<?= urlencode($surname) ?>&seats=<?= htmlspecialchars($seats) ?>" class="btn btn-primary">Télécharger le billet</a>

<a href="/home" class="btn btn-secondary mt-3">Retour à l'accueil</a>
<?php $content = ob_get_clean(); ?>
<?php include 'layout.php'; ?>