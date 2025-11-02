<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle 1 - Accueil</title>
    <?= link_tag(base_url().'styles/salle1Accueil.css') ?>
    <?= script_tag(base_url().'js/salle1Accueil.js') ?>

</head>
<body>
<div class="background-container">

    <!-- POPUP d’explication -->
    <div class="popup">
        <div class="popup-content">
            <h2>Bienvenue dans la salle hantée de l'ingénierie sociale !</h2>
            <p>
                Le but du jeu est de repérer les <strong>mots suspects</strong> dans le dialogue du fantôme.<br>
                Clique sur les mots qui te semblent étranges pour avancer dans ton enquête...<br><br>
                Une fois que tu les auras tous trouver, tu receveras un code pour ouvrir la porte en face de toi.
            </p>
        </div>
    </div>

    <div class="content-container">
        <?= anchor(base_url().'Salle1/accesMessage',
                img([
                    'src' => base_url('salle_1/images/personnages/fantome_1.webp'),
                    'alt' => 'Fantôme',
                    'class' => 'perso-accueil',
                    'id'   => 'fantome'
        ])
        ); ?>
    </div>

    <!-- Bouton retour -->
    <div class="buttons">
        <?= anchor(
                base_url().'/',
                '<div class="retour-wrapper">'
                .img([
                        'src' => base_url('salle_1/images/boutons/retour-et-indice_blanc.webp'),
                        'alt' => 'Retour',
                        'class' => 'button-image'
                ])
                .'<span class="retour-texte">Retour au menu</span>'
                .'</div>'
        ); ?>

    </div>

</div>
</body>
</html>

