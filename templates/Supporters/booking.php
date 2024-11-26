<?php ob_start(); ?>
<h2 class="text-primary mb-4">Réservation pour <?= htmlspecialchars($match['name']) ?></h2>
<p>Date : <?= htmlspecialchars($match['match_date']) ?></p>
<p>Places restantes : <?= htmlspecialchars($match['remaining_seats']) ?></p>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="surname" class="form-label">Prénom</label>
        <input type="text" class="form-control" id="surname" name="surname" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="seats" class="form-label">Nombre de places</label>
        <input type="number" class="form-control" id="seats" name="seats" min="1" max="<?= htmlspecialchars($match['remaining_seats']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Réserver</button>
</form>
<?php $content = ob_get_clean(); ?>
<?php include 'layout.php'; ?>