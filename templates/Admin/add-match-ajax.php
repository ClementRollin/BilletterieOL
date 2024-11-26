<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matchDate = $_POST['match_date'];
    $awayTeamId = $_POST['away_team_id'];
    $remainingSeats = (int)$_POST['remaining_seats'];

    $pdo = getDbConnection();
    $stmt = $pdo->prepare('INSERT INTO matches (match_date, home_team_id, away_team_id, remaining_seats) VALUES (?, 1, ?, ?)');
    $stmt->execute([$matchDate, $awayTeamId, $remainingSeats]);

    $newMatchId = $pdo->lastInsertId();
    $stmt = $pdo->prepare('SELECT name FROM clubs WHERE id = ?');
    $stmt->execute([$awayTeamId]);
    $awayTeamName = $stmt->fetchColumn();

    echo json_encode([
        'success' => true,
        'match' => [
            'id' => $newMatchId,
            'match_name' => 'OL vs ' . $awayTeamName,
            'match_date' => $matchDate,
            'away_team_name' => $awayTeamName,
            'remaining_seats' => $remainingSeats
        ]
    ]);
    exit;
}
?>