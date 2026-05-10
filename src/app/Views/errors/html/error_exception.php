<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur serveur - <?= esc($code) ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; color: #333; margin: 0; padding: 0; }
        .container { max-width: 900px; margin: 40px auto; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 0 20px rgba(0,0,0,.05); }
        h1 { margin-top: 0; color: #c00; }
        .code { font-size: 1.2rem; font-weight: bold; }
        .section { margin-top: 20px; }
        .trace pre { white-space: pre-wrap; background: #f1f1f1; padding: 15px; border-radius: 6px; overflow-x: auto; }
        .meta { color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Erreur serveur</h1>
        <p class="meta">Type: <?= esc($type) ?> | Code HTTP: <?= esc($code) ?></p>
        <div class="section">
            <h2>Message</h2>
            <p><?= esc($message) ?></p>
        </div>
        <div class="section">
            <h2>Emplacement</h2>
            <p>Fichier : <strong><?= esc($file) ?></strong></p>
            <p>Ligne : <strong><?= esc($line) ?></strong></p>
        </div>
        <div class="section trace">
            <h2>Trace d’exécution</h2>
            <pre><?= esc(print_r($trace, true)) ?></pre>
        </div>
    </div>
</body>
</html>
