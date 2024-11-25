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
            padding: 20px 0;
            text-align: center;
        }
        .footer {
            background-color: #D71920;
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
<header class="header">
    <h1>Olympique Lyonnais - Billetterie</h1>
</header>
<main class="container my-4">
    <?= $content ?>
</main>
<footer class="footer">
    <p>&copy; <?= date('Y') ?> Olympique Lyonnais. Tous droits réservés.</p>
</footer>
</body>
</html>