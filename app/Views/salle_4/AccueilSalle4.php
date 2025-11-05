
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle 4</title>
    <?= link_tag('styles/salle_4/salle4.css'); ?>
</head>


<body>
<div class="fond_accueil">

<!--    <h1>SALLE 4</h1>-->

    <?= anchor(base_url().'pageFrise', ' ', [ 'class' => 'clic_frise' ] );?>

    <?= anchor(base_url().'quizFin', ' ', [ 'class' => 'quizFin' ] );?>

<!--    --><?php //= anchor(base_url(), ' ', [ 'alt' => 'retour', 'class' => 'retour' ] );?>

    <?=anchor(base_url(), img([
            'src'   => 'images/salle_4/boutton/WEB/boutons-08 (2).webp',
            'alt'   => 'retour',
            'class' => 'retour'
    ]));?>

</div>



