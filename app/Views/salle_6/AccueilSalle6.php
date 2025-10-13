<!doctype html>
    <html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Salle n°6</title>
    <link rel="stylesheet" href="<?= base_url() ?>/styles/salle6.css">
</head>
<body>
<div class="container">
    <h1>Salle n°6</h1>
    <!-- Bulle de dialogue -->
    <div class="bulle" style="top: 10%; left: 60%;">
        <?= $intitule ?>
    </div>
    <!-- Mascotte avec helper img() -->
    <?= img([
            'src'   => 'images/mascotte.png',
            'alt'   => 'Mascotte',
            'class' => 'mascotte'
    ]) ?>
    <button><?=anchor(base_url() . '/Salle6', 'Retour');?></button>

</div>


