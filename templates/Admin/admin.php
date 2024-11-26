<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isAdmin()) {
$awayTeam = $_POST['away_team'];
$seats = (int)$_POST['seats'];
$price = (float)$_POST['price'];

$pdo = getDbConnection();
$stmt = $pdo->prepare('INSERT INTO matches (home_team_id, away_team_id, total_seats, price) VALUES (?, ?, ?, ?)');
$stmt->execute([1, $awayTeam, $seats, $price]); // 1 = ID de l'OL.
}
?>