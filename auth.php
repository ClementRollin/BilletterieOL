<?php
session_start();
require_once 'model.php';

function login($email, $password) {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
        return true;
    }
    return false;
}

function isAuthenticated() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return isAuthenticated() && $_SESSION['user']['role'] === 'admin';
}
?>