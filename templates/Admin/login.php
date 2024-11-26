<?php
require_once __DIR__ . '/../../auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $loginSuccess = login($email, $password);

    if ($loginSuccess) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_role'] = 'admin';
        header('Location: /Admin/dashboard');
        exit;
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>

<h2>Connexion Administrateur</h2>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required class="form-control mb-2">
    <input type="password" name="password" placeholder="Mot de passe" required class="form-control mb-2">
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>