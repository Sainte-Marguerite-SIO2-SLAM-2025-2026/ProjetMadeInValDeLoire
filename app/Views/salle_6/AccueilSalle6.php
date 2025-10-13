<!doctype html>
    <html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Salle n°6</title>
    <?=link_tag(base_url()."styles/salle6/accueilSalle6.css")?>
</head>
<body>
<div class="container">
    <h1 class="titre-temp">Salle n°6</h1>
    <!-- Bulle de dialogue -->
    <div class="bulle">
        <p class="texte-bulle"><?= $intitule ?></p>
    </div>
    <!-- Mascotte avec helper img() -->
    <?= img([
            'src'   => 'images/salle_6/mascotte_test.png',
            'alt'   => 'Mascotte',
            'class' => 'mascotte'
    ]) ?>
    <?= anchor(base_url() . '/Salle6/Wifi', ' ', [ 'class' => 'zone-cliquable' ] );?>

    <?=anchor(base_url() . '/', img([
                'src'   => 'images/commun/retour.png',
                'alt'   => 'FlecheRetour',
                'class' => 'retour'
        ]));?>

</div>


