<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'model.php';

function login($email, $password) {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_role'] = $user['role'];
        return true;
    }
    return false;
}

function isAuthenticated() {
    return isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
}

function isAdmin() {
    return isAuthenticated() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function isSupporter() {
    return isAuthenticated() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'supporter';
}