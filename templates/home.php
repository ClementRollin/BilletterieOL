<?php ob_start(); ?>
<h2 class="text-primary mb-4">Réservez vos places</h2>
<div class="row">
    <?php foreach ($matches as $match): ?>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body text-center">
                    <!-- Ajout des logos -->
                    <div class="logos mb-3">
                        <img src="<?= htmlspecialchars($match['home_logo']) ?>" alt="Logo <?= htmlspecialchars($match['home_team_name']) ?>" class="img-fluid" style="max-height: 50px; margin-right: 10px;">
                        <span>VS</span>
                        <img src="<?= htmlspecialchars($match['away_logo']) ?>" alt="Logo <?= htmlspecialchars($match['away_team_name']) ?>" class="img-fluid" style="max-height: 50px; margin-left: 10px;">
                    </div>
                    <!-- Titre du match -->
                    <h5 class="card-title"><?= htmlspecialchars($match['name']) ?></h5>
                    <p>Date : <?= htmlspecialchars($match['match_date']) ?></p>
                    <p>Places restantes : <?= htmlspecialchars($match['remaining_seats']) ?></p>
                    <a href="/booking/<?= $match['id'] ?>" class="btn btn-primary">Réserver</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php include 'layout.php'; ?>