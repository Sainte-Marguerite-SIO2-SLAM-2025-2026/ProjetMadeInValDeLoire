<title>Salle n°6</title>
<?= link_tag(base_url() . "styles/salle_6/accueilSalle6.css") ?>
<div class="container">
    <h1 class="titre-temp">Salle n°6</h1>
    <!-- Bulle de dialogue -->
    <div class="bulle">
        <p class="texte-bulle"><?= $intitule ?></p>
    </div>
    <!-- Mascotte -->
    <?= img([
            'src' => 'images/commun/mascotte/mascotte_face.svg',
            'alt' => 'Mascotte',
            'class' => 'mascotte'
    ]) ?>

    <!-- zone train -->
    <?= anchor(base_url() . 'Salle6/Enigme', ' ', ['class' => 'zone-cliquable']); ?>

    <!-- Bouton retour -->
    <?= anchor(base_url() . '/', "Projet Made in Val de Loire", [
            'class' => 'retour'
    ]); ?>

</div>

<?= script_tag('js/salle_6/accueilSalle6.js') ?>
