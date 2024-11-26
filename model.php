<?php
function getDbConnection()
{
    $host = 'localhost';
    $dbname = 'ol_tickets';
    $username = 'root';
    $password = '';
    try {
        return new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}

function getMatches()
{
    $pdo = getDbConnection();
    $stmt = $pdo->query('
        SELECT 
            matches.*, 
            home_club.name AS home_team_name, 
            home_club.logo_url AS home_logo,
            away_club.name AS away_team_name, 
            away_club.logo_url AS away_logo
        FROM matches
        JOIN clubs AS home_club ON matches.home_team_id = home_club.id
        JOIN clubs AS away_club ON matches.away_team_id = away_club.id
        ORDER BY matches.match_date ASC
    ');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getMatchById($id)
{
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('
        SELECT 
            matches.*, 
            home_club.logo_url AS home_logo,
            away_club.logo_url AS away_logo
        FROM matches
        JOIN clubs AS home_club ON matches.home_team_id = home_club.id
        JOIN clubs AS away_club ON matches.away_team_id = away_club.id
        WHERE matches.id = ?
    ');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getMatchWithTeams($matchId)
{
    $pdo = getDbConnection();
    $stmt = $pdo->query('
        SELECT 
            matches.*, 
            home_club.name AS home_team_name, 
            home_club.logo_url AS home_logo,
            away_club.name AS away_team_name, 
            away_club.logo_url AS away_logo
        FROM matches
        JOIN clubs AS home_club ON matches.home_team_id = home_club.id
        JOIN clubs AS away_club ON matches.away_team_id = away_club.id
        ORDER BY matches.match_date ASC
    ');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createReservation($matchId, $name, $surname, $email, $seats)
{
    $pdo = getDbConnection();
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('SELECT remaining_seats FROM matches WHERE id = ?');
        $stmt->execute([$matchId]);
        $match = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($match['remaining_seats'] < $seats) {
            throw new Exception('Pas assez de places disponibles.');
        }

        $stmt = $pdo->prepare('INSERT INTO reservations (match_id, customer_name, customer_surname, customer_email, seats) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$matchId, $name, $surname, $email, $seats]);

        $stmt = $pdo->prepare('UPDATE matches SET remaining_seats = remaining_seats - ? WHERE id = ?');
        $stmt->execute([$seats, $matchId]);

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function getPrice($matchId)
{
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('SELECT price FROM matches WHERE id = ?');
    $stmt->execute([$matchId]);
    return $stmt->fetchColumn();
}

function getReservationWithTotalPrice($reservationId)
{
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('
        SELECT 
            r.id AS reservation_id,
            r.customer_name,
            r.customer_surname,
            m.name AS match_name,
            r.seats,
            m.price,
            (r.seats * m.price) AS total_price
        FROM reservations r
        JOIN matches m ON r.match_id = m.id
        WHERE r.id = ?
    ');
    $stmt->execute([$reservationId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function generatePDF($name, $surname, $matchName, $seats)
{
    require_once 'utils/pdf_generator.php';
    return generateTicketPDF($name, $surname, $matchName, $seats);
}
?>