<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle 4</title>
    <?= link_tag('styles/salle_4/salle4.css'); ?>
</head>

<body>
<div class="image-container">

<!--    <a href='--><?php //= base_url('pageFrise')?><!--' class="clickable-zone zone1" title="Zone 1"></a>-->
        <?= anchor(base_url().'pageFrise', ' ', [ 'class' => 'clickable-zone zone1' ] );?>

<!--    <a href='--><?php //= base_url('quizFin')?><!--' class="clickable-zone zone2" title="Zone 2"></a>-->
    <?= anchor(base_url().'quizFin', ' ', [ 'class' => 'clickable-zone zone2' ] );?>

    <?=anchor(base_url(), img([
        'src'   => 'images/commun/retour.webp',
        'alt'   => 'retour',
        'class' => 'retour'
    ]));?>

    <?=anchor(base_url(), img([
            'src'   => 'images/commun/retour.webp',
            'alt'   => 'mascotte',
            'class' => 'mascotte'
    ]));?>

</div>


<!--    <img src="images/salle_4/chambre/WEB/chambre.webp" usemap="#chambre" class="fond_accueil">-->
<!---->
<?php ////= image_map('chambre');
////?>
<!--    <map name="chambre" >-->
<!--        <area shape="rect" coords="1292,400,672,54" href="--><?php //= base_url('pageFrise') ?><!--" alt="frise_salle4">-->
<!--        <area shape="poly" coords="1438,961,1589,965,1601,1056,1416,1063" href="--><?php //= base_url('quizFin') ?><!--" alt="dossier">-->
<!--    </map>-->

<!--    --><?php //= anchor(base_url().'pageFrise', ' ', [ 'class' => 'clic_frise' ] );?>

<!--    --><?php //= anchor(base_url().'quizFin', ' ', [ 'class' => 'quizFin' ] );?>

<!--    --><?php //= anchor(base_url(), ' ', [ 'alt' => 'retour', 'class' => 'retour' ] );?>



