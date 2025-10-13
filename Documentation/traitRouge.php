<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relier des cartes</title>
    <?= link_tag('css/style_3.css') ?>
</head>
<body>
<h1>Relier les cartes</h1>

<div id="info">
    Cliquez sur deux cartes pour les relier avec une ligne rouge
</div>

<div class="controls">
    <?= form_button(['id' => 'resetBtn', 'content' => '🔄 Réinitialiser']) ?>
    <?= form_button(['id' => 'undoBtn', 'content' => '↶ Annuler la dernière ligne']) ?>
</div>
<!--en image mais ici peut être interactive-->
<div id="gameContainer">
    <?= img([
        'src' => 'image/fond.png',
        'alt' => 'Fond du jeu',
        'id' => 'fondImage'
    ]) ?>
    <canvas id="canvas" width="800" height="600"></canvas>

    <!-- 🃏 Cartes -->
    <?= img(['src' => 'image/carte1.png',
        'class' => 'carte',
        'id' => 'carte1',
        'data-id' => '1',
        'alt' => 'Carte 1',
        'style' => 'left:100px;top:100px;']) ?>
    <?= img(['src' => 'image/carte2.png',
        'class' => 'carte',
        'id' => 'carte2',
        'data-id' => '2',
        'alt' => 'Carte 2',
        'style' => 'left:600px;top:100px;']) ?>
    <?= img(['src' => 'image/carte3.png',
        'class' => 'carte',
        'id' => 'carte3',
        'data-id' => '3',
        'alt' => 'Carte 3',
        'style' => 'left:100px;top:400px;']) ?>
    <?= img(['src' => 'image/carte4.png',
        'class' => 'carte',
        'id' => 'carte4',
        'data-id' => '4',
        'alt' => 'Carte 4',
        'style' => 'left:600px;top:400px;']) ?>
</div>

<?= script_tag('js/relier_cartes.js') ?>
</body>
</html>
