<?php
require_once '../model.php';
require_once '../auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash le mot de passe
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insérer l'utilisateur dans la base de données
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('INSERT INTO users (email, password, role) VALUES (?, ?, ?)');
    $stmt->execute([$email, $hashedPassword, $role]);

    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        echo "Un utilisateur avec cet email existe déjà.";
        exit;
    }

    // Connexion de l'utilisateur et redirection selon son rôle
    $_SESSION['user'] = [
        'email' => $email,
        'role' => $role
    ];

    if ($role === 'admin') {
        header('Location: /admin/dashboard');
    } else {
        header('Location: /home');
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Inscription</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Je suis un</label>
            <select class="form-select" id="role" name="role" required>
                <option value="supporter">Supporter</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
</div>
</body>
</html>