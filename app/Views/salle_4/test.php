<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relier des cartes</title>
    <?= link_tag('styles/salle_4/style_3.css') ?>
</head>
<body>

<!--uniquement via css si pas interaction avec image de fond-->
<div class="fond">
<!--        <h1>Relier les cartes</h1>-->

    <div id="info">
        Cliquez sur deux cartes pour les relier avec une ligne rouge
    </div>

    <div class="controls">
        <?= form_button(['id' => 'resetBtn', 'content' => '🔄 Réinitialiser']) ?>
        <?= form_button(['id' => 'undoBtn', 'content' => '↶ Annuler la dernière ligne']) ?>
    </div>

<!--    --><?php //= anchor(base_url().'Salle4', '<button>Retour</button>') ?>

    <div id="gameContainer">

        <canvas id="canvas" width="1500" height="975"></canvas>

        <!--#region cartes  -->
        <!-- 🃏 Cartes -->
        <?= img(['src' => 'images/salle_4/carte02/WEBP/carte_pins_01.png',
                'class' => 'carte carte1',
                'id' => 'carte1',
                'data-id' => '1',
                'alt' => 'Carte 1',
                'style' => 'left:20%;top:14%;']); ?>

        <?= img(['src' => 'images/salle_4/carte02/WEBP/carte_pins_02.png',
                'class' => 'carte carte2',
                'id' => 'carte2',
                'data-id' => '2',
                'alt' => 'Carte 2',
                'style' => 'left:41%;top:22%;']); ?>

        <?= img(['src' => 'images/salle_4/carte02/WEBP/carte_pins_03.png',
                'class' => 'carte carte3',
                'id' => 'carte3',
                'data-id' => '3',
                'alt' => 'Carte 3',
                'style' => 'left:71%;top:19%;']); ?>

        <?= img(['src' => 'images/salle_4/carte02/WEBP/carte_pins_04.png',
                'class' => 'carte carte4',
                'id' => 'carte4',
                'data-id' => '4',
                'alt' => 'Carte 4',
                'style' => 'left:32%;top:65%;']); ?>

        <?= img(['src' => 'images/salle_4/carte02/WEBP/carte_pins_05.png',
                'class' => 'carte carte5',
                'id' => 'carte5',
                'data-id' => '5',
                'alt' => 'Carte 5',
                'style' => 'left:15%;top:40%;']); ?>

        <?= img(['src' => 'images/salle_4/carte02/WEBP/carte_pins_06.png',
                'class' => 'carte carte6',
                'id' => 'carte6',
                'data-id' => '6',
                'alt' => 'Carte 6',
                'style' => 'left:52%;top:51%;']); ?>

        <?= img(['src' => 'images/salle_4/carte02/WEBP/carte_pins_07.png',
                'class' => 'carte carte7',
                'id' => 'carte7',
                'data-id' => '7',
                'alt' => 'Carte 7',
                'style' => 'left:55%;top:73%;']); ?>

        <?= img(['src' => 'images/salle_4/carte02/WEBP/carte_pins_08.png',
                'class' => 'carte carte8',
                'id' => 'carte8',
                'data-id' => '8',
                'alt' => 'Carte 8',
                'style' => 'left:74%;top:47%;']); ?>
        <!--#endregion -->

    </div>

    <?=anchor(base_url().'Salle4', img([
            'src'   => 'images/salle_4/boutton/WEB/boutons-08 (2).webp',
            'alt'   => 'retour',
            'class' => 'retour'
    ]));?>


</div>



<?= script_tag('js/salle4.js') ?>
</body>
</html>
