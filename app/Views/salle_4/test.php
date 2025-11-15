<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relier des cartes</title>
<!--    --><?php //= link_tag('styles/salle_4/friseSalle4.css') ?>
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

<!--        #region 🃏 Cartes  -->
<!---->
<!--        --><?php //= img([
//                'src'      => 'images/salle_4/carte02/WEBP/carte_pins_01.png',
//                'class'    => 'carte carte1',
//                'id'       => 'carte1',
//                'data-id'  => '1',
//                'alt'      => 'Carte 1',
//                'style'    => 'left:6%; top:10%;'
//        ]); ?>
<!---->
<!--        --><?php //= img([
//                'src'      => 'images/salle_4/carte02/WEBP/carte_pins_02.png',
//                'class'    => 'carte carte2',
//                'id'       => 'carte2',
//                'data-id'  => '2',
//                'alt'      => 'Carte 2',
//                'style'    => 'left:10%; top:45%;'
//        ]); ?>
<!---->
<!--        --><?php //= img([
//                'src'      => 'images/salle_4/carte02/WEBP/carte_pins_03.png',
//                'class'    => 'carte carte3',
//                'id'       => 'carte3',
//                'data-id'  => '3',
//                'alt'      => 'Carte 3',
//                'style'    => 'left:38%; top:6%;'
//        ]); ?>
<!---->
<!--        --><?php //= img([
//                'src'      => 'images/salle_4/carte02/WEBP/carte_pins_04.png',
//                'class'    => 'carte carte4',
//                'id'       => 'carte4',
//                'data-id'  => '4',
//                'alt'      => 'Carte 4',
//                'style'    => 'left:47%; top:42%;'
//        ]); ?>
<!---->
<!--        --><?php //= img([
//                'src'      => 'images/salle_4/carte02/WEBP/carte_pins_05.png',
//                'class'    => 'carte carte5',
//                'id'       => 'carte5',
//                'data-id'  => '5',
//                'alt'      => 'Carte 5',
//                'style'    => 'left:83%; top:28%;'
//        ]); ?>
<!---->
<!--        --><?php //= img([
//                'src'      => 'images/salle_4/carte02/WEBP/carte_pins_06.png',
//                'class'    => 'carte carte6',
//                'id'       => 'carte6',
//                'data-id'  => '6',
//                'alt'      => 'Carte 6',
//                'style'    => 'left:60%; top:12%;'
//        ]); ?>
<!---->
<!--        --><?php //= img([
//                'src'      => 'images/salle_4/carte02/WEBP/carte_pins_07.png',
//                'class'    => 'carte carte7',
//                'id'       => 'carte7',
//                'data-id'  => '7',
//                'alt'      => 'Carte 7',
//                'style'    => 'left:40%; top:65%;'
//        ]); ?>
<!---->
<!--        --><?php //= img([
//                'src'      => 'images/salle_4/carte02/WEBP/carte_pins_08.png',
//                'class'    => 'carte carte8',
//                'id'       => 'carte8',
//                'data-id'  => '8',
//                'alt'      => 'Carte 8',
//                'style'    => 'left:73%; top:68%;'
//        ]); ?>
<!---->
<!--        <#endregion -->

        <?php if (!empty($cartes)): ?>
            <?php foreach ($cartes as $index => $carte): ?>
                <div class="carte-container carte<?= ($index + 1) ?>">
                    <?= img([
                            'src'      => base_url('images/salle_4/images_finales/' . esc($carte['image'])),
                            'class'    => 'carte',
                            'id'       => 'carte' . ($index + 1),
                            'data-id'  => ($index + 1),
                            'alt'      => 'Carte ' . ($index + 1)
                    ]); ?>
                    <div class="explication"><?= esc($carte['explication']) ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune carte trouvée pour cette activité.</p>
        <?php endif; ?>


    </div>

    <?=anchor(base_url().'Salle4', img([
            'src'   => 'images/commun/retour.webp',
            'alt'   => 'retour',
            'class' => 'retour'
    ]));?>


</div>



<?= script_tag('js/salle4.js') ?>
</body>
</html>
