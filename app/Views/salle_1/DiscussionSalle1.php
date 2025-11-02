<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle 1 - Discussion</title>

    <!-- CSS -->
    <?= link_tag(base_url('styles/salle1Discussion.css')) ?>

    <!-- JS externe -->
    <?= script_tag(base_url('js/salle1Discussion.js')) ?>
</head>
<body>
<div class="background-container">

    <div class="content-container">
        <!-- Image du personnage -->
        <?= img([
                'src' => base_url('salle_1/images/personnages/monstre1.webp'),
                'alt' => 'Fantôme',
                'class' => 'perso-discussion',
                'id'   => 'fantome'
        ]); ?>

        <!-- Zone de texte -->
        <div class="text-zone" id="text-zone">
            <p>
                Bonjour aventurier... Je t’envoie un <span class="mot-cliquable">email</span>
                étrange contenant un <span class="mot-cliquable">lien</span> suspect.
                Peut-être veux-tu <span class="mot-cliquable">cliquer</span> dessus ?
            </p>
        </div>

        <!-- Indicateur de vies -->
        <div id="vies">❤️❤️❤️</div>
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
