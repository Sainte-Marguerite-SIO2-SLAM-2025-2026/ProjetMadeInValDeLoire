<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle 1 - Discussion</title>
    <?= link_tag(base_url().'styles/salle1Global.css') ?>
    <?= link_tag(base_url('styles/salle1Discussion.css')) ?>
    <?= script_tag(base_url('js/salle1Discussion.js')) ?>
    <?= script_tag(base_url('js/salle1Timer.js')) ?>
</head>
<body>
<div class="background-container">
    <!-- Timer -->
    <div id="timer" class="timer"></div>

    <!-- Nom du personnage (positionné indépendamment) -->
    <div id="nom-personnage"><?= esc($nom_personnage) ?></div>

    <div class="content-container">
        <?= img([
                'src' => base_url('salle_1/images/personnages/monstre1.webp'),
                'alt' => 'Fantôme',
                'class' => 'perso-discussion',
                'id'   => 'fantome'
        ]); ?>

        <!-- Zone de texte -->
        <div id="text-zone"
             class="text-zone"
             data-mots='<?= json_encode(explode(" ", esc($message)), JSON_UNESCAPED_UNICODE) ?>'
             data-suspects='<?= json_encode($mots_suspects ?? [], JSON_UNESCAPED_UNICODE) ?>'>
        </div>
    </div>

    <!-- Serrure (vers la suite du jeu) -->
    <div class="serrure">
        <?= anchor( base_url('Salle1/Code'),
                img([
                        'src' => base_url('salle_1/images/serrure/serrure_noire.webp'),
                        'alt' => 'Serrure',
                        'class' => 'serrure-image'
                ])); ?>
    </div>

    <!-- Bouton retour -->
    <div class="buttons">
        <?= anchor(
                base_url('Salle1'),
                '<div class="retour-wrapper">'
                .img([
                        'src' => base_url('salle_1/images/boutons/retour-et-indice_blanc.webp'),
                        'alt' => 'Retour',
                        'class' => 'button-image'
                ])
                .'<span class="retour-texte">Page précédente</span>'
                .'</div>'
        ); ?>

        <?= anchor(
                base_url('/'),
                '<div class="retour-wrapper">'
                .img([
                        'src' => base_url('salle_1/images/boutons/retour-et-indice_blanc.webp'),
                        'alt' => 'Menu',
                        'class' => 'button-image'
                ])
                .'<span class="retour-texte">Retour au menu</span>'
                .'</div>'
        ); ?>
    </div>

</div>

<!-- POPUP -->
<div id="popup" class="popup" style="display:none;">
    <div class="popup-content">
        <h2 id="popup-titre">Bravo !</h2>
        <p id="popup-message"></p>
        <button id="popup-fermer">Fermer</button>
    </div>
</div>
</body>
</html>
