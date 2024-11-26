<?php
require_once __DIR__ . '/../../auth.php';
if (!isAuthenticated() || !isAdmin()) {
    header('Location: /admin/login');
    exit;
}

$matches = getMatches();
$awayTeams = getAwayTeams(); // Fonction pour obtenir les équipes adverses.
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Administration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h2 class="text-primary mb-4">Tableau de Bord - Administration</h2>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-secondary">Liste des Matchs</h4>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMatchModal">
            <i class="bi bi-plus-circle"></i> Ajouter un Match
        </button>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
            <tr>
                <th scope="col">Match</th>
                <th scope="col">Date</th>
                <th scope="col">Places restantes</th>
                <th scope="col" class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody id="matchesTableBody">
            <?php foreach ($matches as $match): ?>
                <tr id="matchRow<?= $match['id'] ?>">
                    <td><?= htmlspecialchars('Olympique Lyonnais vs ' . $match['away_team_name']) ?></td>
                    <td><?= htmlspecialchars($match['match_date']) ?></td>
                    <td><?= htmlspecialchars($match['remaining_seats']) ?></td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editMatchModal<?= $match['id'] ?>">
                            <i class="bi bi-pencil"></i> Modifier
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteMatch(<?= $match['id'] ?>)">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Ajout -->
<div class="modal fade" id="addMatchModal" tabindex="-1" aria-labelledby="addMatchModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addMatchForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMatchModalLabel">Ajouter un Match</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addMatchDate" class="form-label">Date</label>
                        <input type="datetime-local" class="form-control" id="addMatchDate" name="match_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="addAwayTeam" class="form-label">Équipe à l'extérieur</label>
                        <select class="form-select" id="addAwayTeam" name="away_team_id" required>
                            <?php foreach ($awayTeams as $team): ?>
                                <option value="<?= $team['id'] ?>"><?= htmlspecialchars($team['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="addSeats" class="form-label">Places disponibles</label>
                        <input type="number" class="form-control" id="addSeats" name="remaining_seats" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JavaScript Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Ajouter un match
    document.getElementById('addMatchForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('/admin/add-match-ajax', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const newRow = `
                    <tr id="matchRow${data.match.id}">
                        <td>Olympique Lyonnais vs ${data.match.away_team_name}</td>
                        <td>${data.match.match_date}</td>
                        <td>${data.match.remaining_seats}</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editMatchModal${data.match.id}">
                                <i class="bi bi-pencil"></i> Modifier
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteMatch(${data.match.id})">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </td>
                    </tr>`;
                    document.getElementById('matchesTableBody').insertAdjacentHTML('beforeend', newRow);
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addMatchModal'));
                    modal.hide();
                } else {
                    alert('Erreur lors de l\'ajout du match.');
                }
            });
    });

    // Supprimer un match
    function deleteMatch(matchId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer ce match ?')) return;
        fetch(`/admin/delete-match-ajax/${matchId}`, {
            method: 'POST'
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.getElementById(`matchRow${matchId}`);
                    if (row) row.remove();
                } else {
                    alert('Erreur lors de la suppression du match.');
                }
            });
    }
</script>
</body>
</html>