<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isAuthenticated()) {
    $ticketId = $_POST['ticket_id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];

    $pdo = getDbConnection();
    $stmt = $pdo->prepare('UPDATE tickets SET name = ?, surname = ? WHERE id = ?');
    $stmt->execute([$name, $surname, $ticketId]);

    // Envoi d'email
    mail($email, "Votre billet pour le match", "Voici votre billet personnalisé.", "From: no-reply@ol.fr");
}
?>