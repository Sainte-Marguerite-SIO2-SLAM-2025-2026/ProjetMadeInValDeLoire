<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wifi</title>
    <?= link_tag(base_url()."styles/salle6/Wifi.css") ?>
</head>
<body>
    <div class="container">
        <h1 class="titre-temp">Wifi</h1>
        <?= anchor(base_url() . '/Salle6', img([
                    'src'   => 'images/commun/retour.png',
                    'alt'   => 'FlecheRetour',
                    'class' => 'retour'
            ]));?>
    </div>
</body>
</html>
