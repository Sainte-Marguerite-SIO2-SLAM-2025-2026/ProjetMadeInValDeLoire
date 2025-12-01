<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle 1 - Accueil</title>
    <?= link_tag(base_url().'styles/salle_1/salle1Global.css') ?>
    <?= link_tag(base_url().'styles/salle_1/salle1Accueil.css') ?>
    <?= script_tag(base_url().'js/salle_1/salle1Accueil.js') ?>
</head>
<body>
<div class="background-container">
    <!-- POPUP d'explication -->
    <div class="popup">
        <div class="popup-content">
            <?= img([
                    'src' => base_url('images/commun/mascotte/mascotte_face.svg'),
                    'alt' => 'Mascotte',
                    'class' => 'mascotte-popup'
            ]) ?>
            <h2>Bienvenue dans la salle de l'ingénierie sociale !</h2>
            <?php if (isset($explication) && !empty($explication)): ?>
                <p><?= esc($explication) ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="content-container">
        <?= anchor(base_url().'Salle1/accesMessage',
                img([
                        'src' => base_url('images/salle_1/images/personnages/fantome_1.webp'),
                        'alt' => 'Fantôme',
                        'class' => 'perso-accueil',
                        'id'   => 'fantome'
                ])
        ); ?>
    </div>

    <!-- Bouton retour -->
    <?php if (session()->get('mode') === 'jour'): ?>
        <div class="home">
            <?= anchor('/manoirJour',
                    img([
                            'src' => base_url('images/commun/btn_retour/home_icone_2.webp'),
                            'alt' => 'Retour',
                            'class' => 'button-home'
                    ])
            ) ?>
        </div>
    <?php else: ?>
        <div class="home">
            <?= anchor('/',
                    img([
                            'src' => base_url('images/commun/btn_retour/home_icone_2.webp'),
                            'alt' => 'Retour',
                            'class' => 'button-home'
                    ])
            ) ?>
        </div>
    <?php endif?>

    <div class="buttons">

        <?= img([
                'src' => base_url('images/commun/mascotte/mascotte_face.svg'),
                'alt' => 'Mascotte',
                'class' => 'mascotte-image'
        ])?>

    </div>
</div>
</body>
</html>