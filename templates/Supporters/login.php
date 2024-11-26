<?php
require_once __DIR__ . '/../../auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (login($email, $password)) {
        header('Location: /home');
        exit;
    } else {
        $error = "Identifiants incorrects";
    }
}
?>

<h2>Connexion Supporters</h2>
<?php if (!empty($error)): ?>
    <div><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="POST">
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="Mot de passe">
    <button type="submit">Se connecter</button>
</form>