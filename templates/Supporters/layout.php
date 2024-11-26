<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OL Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
        }
        .header {
            background-color: #003DA5;
            color: white;
        }
        .headerContent {
            display: flex;
            justify-content: space-between;
            padding: 20px 0;
            text-align: center;
        }
        .footer {
            background-color: #003DA5;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
<div class="container-fluid header">
    <header class="container headerContent">
        <h1>Olympique Lyonnais - Billetterie</h1>
        <?php if (!isAuthenticated()): ?>
            <div class="text-end mb-3">
                <a href="/Supporters/login" class="btn btn-primary">Se connecter (Supporter)</a>
                <a href="/Admin/login" class="btn btn-secondary">Se connecter (Admin)</a>
            </div>
        <?php else: ?>
            <div class="text-end mb-3">
                <a href="/" class="btn btn-danger">Se déconnecter</a>
            </div>
        <?php endif; ?>
    </header>
</div>
<main class="container my-4">
    <?= $content ?>
</main>
<footer class="footer">
    <p>&copy; <?= date('Y') ?> Olympique Lyonnais. Tous droits réservés.</p>
</footer>
</body>
</html>