<?php
require_once __DIR__ . '/../model.php';
require_once __DIR__ . '/../auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $pdo = getDbConnection();
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
    $stmt->execute([$email]);

    if ($stmt->fetchColumn() > 0) {
        $error = "Cet email est déjà utilisé.";
    } else {
        $stmt = $pdo->prepare('INSERT INTO users (email, password, role) VALUES (?, ?, ?)');
        $stmt->execute([$email, $hashedPassword, $role]);

        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_role'] = $role;
        header('Location: ' . ($role === 'admin' ? '/admin/dashboard' : '/home'));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container text-center mt-5">
    <h1>Bienvenue sur la Billetterie de l'Olympique Lyonnais</h1>
    <div class="mt-4">
        <a href="/Admin/login" class="btn btn-primary btn-lg me-3">Espace Administrateur</a>
        <a href="/Supporters/login" class="btn btn-secondary btn-lg">Espace Supporter</a>
    </div>
</div>

<div class="container mt-5">
    <h2>Inscription</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
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