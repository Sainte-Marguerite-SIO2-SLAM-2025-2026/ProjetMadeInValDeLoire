<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= link_tag('styles/salle_3/salle3.css') ?>
    <script> const BASE_URL = "<?= base_url() ?>" </script>
    <script src="<?= base_url('/js/salle_3/salle3.js') ?>"></script>
    <title>Salle 2 - Phishing</title>
</head>

<body>
<?php $session = session()->get('mode'); ?>
<div class="content">
    <div class="bureau-wrapper" id="bureau">
        <img src="<?= base_url("/images/salle_3/bureau/bureau_sepia.webp")?>" alt="Bureau" class="bureau-svg bureau-normal">
        <img src="<?= base_url("/images/salle_3/bureau/bureau_orange.webp")?>" alt="Bureau hover" class="bureau-svg bureau-hover">
    </div>

    <?php if ($session == 'nuit') : ?>
    <?= anchor(base_url(), ' ', ['class' => 'btn-accueil']); ?>
    <?php else : ?>
    <?= anchor(base_url('/manoirJour'), ' ', ['class' => 'btn-accueil']); ?>
    <?php endif; ?>

</div>

<div class="mascotte-container">
    <?php $img = ['id' => 'mascotte', 'src' => 'images/commun/mascotte/mascotte_face.svg',  'alt' => 'Mascotte'];
    echo img($img);
    ?>

    <div id="mascotte-tooltip" class="toolTip">
        <p>Clique sur le bureau pour commencer !</p>
    </div>
</div>

<div id="modal-accueil" class="modal">
    <div class="modal-content">
        <span id="modal-close" class="close">&times;</span>
        <h2>Bienvenue !</h2>
        <p>
            <br> <br>
            Les lourdes portes de la bibliothèque s’ouvrent… bienvenue dans une pièce où chaque détail pourrait être un indice.<br><br> Saurez-vous les trouver ?
            <br>
        </p>
        <p></p>
        <button id="commencer" class="commencer">Commencer !</button>
    </div>
</div>
</body>
</html>
