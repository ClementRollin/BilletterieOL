<?php
require_once __DIR__ . '/../../auth.php';
if (!isAuthenticated() || !isAdmin()) {
    header('Location: /admin/login');
    exit;
}

$matches = getMatches();

?>

<h2 class="text-primary">Tableau de Bord - Administration</h2>

<a href="/admin/add-match" class="btn btn-success mb-3">Ajouter un Match</a>
<table class="table">
    <thead>
    <tr>
        <th>Match</th>
        <th>Date</th>
        <th>Places restantes</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($matches as $match): ?>
        <tr>
            <td><?= htmlspecialchars($match['home_team_name'] . ' vs ' . $match['away_team_name']) ?></td>
            <td><?= htmlspecialchars($match['match_date']) ?></td>
            <td><?= htmlspecialchars($match['remaining_seats']) ?></td>
            <td>
                <a href="/admin/edit-match/<?= $match['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                <a href="/admin/delete-match/<?= $match['id'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>