<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page introuvable</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; color: #333; margin: 0; padding: 0; }
        .container { max-width: 700px; margin: 80px auto; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 0 20px rgba(0,0,0,.05); text-align: center; }
        h1 { margin: 0 0 10px; color: #333; }
        p { margin: 0 0 20px; }
        a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>404 - Page introuvable</h1>
        <p>La page demandée est introuvable.</p>
        <a href="<?= base_url('/') ?>">Retour à l'accueil</a>
    </div>
</body>
</html>
