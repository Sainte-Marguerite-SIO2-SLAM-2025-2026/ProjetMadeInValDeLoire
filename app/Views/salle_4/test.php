<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relier des cartes</title>
    <?= link_tag('public/styles/salle_4/style_3.css'); ?>
</head>
<body>
<h1> Relier les cartes</h1>

<div id="info">
    Cliquez sur deux cartes pour les relier avec une ligne rouge
</div>

<div class="controls">
    <button id="resetBtn">🔄 Réinitialiser</button>
    <button id="undoBtn">↶ Annuler la dernière ligne</button>
</div>

<div id="gameContainer">
    <!-- L'image de fond sera remplacée par votre fond.png -->
    <img id="fondImage" src="<?= base_url()?>public/images/salle4/img_chambre.png
    width='800' height='600'%3E%3Cdefs%3E%3Cpattern id='grid'
    width='40' height='40' patternUnits='userSpaceOnUse'%3E%3Cpath d='M 40 0 L 0 0 0 40'
    fill='none' stroke='%23ffffff' stroke-width='0.5'
    opacity='0.1'/%3E%3C/pattern%3E%3C/defs%3E%3Crect width='800' height='600'
     fill='%2334495e'/%3E%3Crect width='800' height='600' fill='url(%23grid)'/%3E%3C/svg%3E" alt="Fond">
    <canvas id="canvas" width="800" height="600"></canvas>

    <!-- Les 4 cartes avec vos images -->
<!--<img class="carte" id="carte1" data-id="1" src="--><?php //= base_url()?><!--public/images/salle4/carte.png" alt="Carte 1" style="left: 100px; top: 100px;">-->
    <?= img(['src' => 'public/images/salle4/carte2.png',
        'alt' => 'Carte 1',
        'class' => 'carte',
        'id' => 'carte1',
//        'data-id'=>'1',
        'style'=>'left: 100px; top: 100px;'
    ]) ?>
<!--    --><?php //= img(['src' => 'public/images/salle4/carte.png',
//        'alt' => 'Carte 2',
//        'class' => 'carte',
//        'id' => 'carte2',
//        'data-id'=>'2',
//        'style'=>'left: 100px; top: 100px;'
//    ]) ?>
<!--    --><?php //= img(['src' => 'public/images/salle4/carte.png',
//        'alt' => 'Carte 3',
//        'class' => 'carte',
//        'id' => 'carte3',
//        'data-id'=>'3',
//        'style'=>'left: 100px; top: 400px;'
//    ]) ?>
<!--    --><?php //= img(['src' => 'public/images/salle4/carte.png',
//        'alt' => 'Carte 4',
//        'class' => 'carte',
//        'id' => 'carte4',
//        'data-id'=>'4',
//        'style'=>'left: 600px; top: 400px;'
//    ]) ?>
    <img class="carte" id="carte2" data-id="2" src="/public/images/salle4/carte.png" alt="Carte 2" style="left: 600px; top: 100px;">
    <img class="carte" id="carte3" data-id="3" src="/public/images/salle4/carte.png" alt="Carte 3" style="left: 100px; top: 400px;">
    <img class="carte" id="carte4" data-id="4" src="/public/images/salle4/carte.png" alt="Carte 4" style="left: 600px; top: 400px;">
</div>

<script>

</script>
</body>
</html>