<?php ob_start(); ?>
<style>
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
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }
    .card-title {
        color: #003DA5;
        margin-bottom: 10px;
    }
    .card-body {
        padding: 20px;
    }
    .btn-primary {
        background-color: #003DA5;
        border-color: #003DA5;
    }
    .btn-primary:hover {
        background-color: #002b7f;
        border-color: #002b7f;
    }
    .btn-primary:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 61, 165, 0.5);
    }
</style>
<h2 class="text-primary mb-4">Réservez vos places</h2>
<div class="row">
    <?php foreach ($matches as $match): ?>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body text-center">
                    <div class="logos mb-3">
                        <img src="<?= htmlspecialchars($match['home_logo']) ?>" alt="Logo <?= htmlspecialchars($match['home_team_name']) ?>" class="img-fluid" style="max-height: 50px; margin-right: 10px;">
                        <span>VS</span>
                        <img src="<?= htmlspecialchars($match['away_logo']) ?>" alt="Logo <?= htmlspecialchars($match['away_team_name']) ?>" class="img-fluid" style="max-height: 50px; margin-left: 10px;">
                    </div>
                    <h5 class="card-title"><?= htmlspecialchars($match['name']) ?></h5>
                    <p>Date : <?= htmlspecialchars($match['match_date']) ?></p>
                    <p>Places restantes : <?= htmlspecialchars($match['remaining_seats']) ?></p>
                    <p><strong>Prix :</strong> <?= number_format($match['price'], 2) ?> €</p>
                    <a href="/booking/<?= $match['id'] ?>" class="btn btn-primary">Réserver</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php include 'layout.php'; ?>