<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Couloir du Bureau | Salle Mot de Passe</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/Etape1_Salle3.jpg') ?>">
    <link rel="stylesheet" href="<?= base_url('/styles/salle_2/style_etape_S3.css') ?>?v=8">
</head>
<body>

    <?php if (session()->get('mode') === 'jour'): ?>
        <div class="bouton-accueil-cluedo">
            <?= anchor('/manoirJour',
                    img([
                            'src' => base_url('images/commun/btn_retour/home_icone_7.webp'),
                            'alt' => 'Mascotte',
                            'class' => 'bouton-accueil-cluedo'
                    ])
            ) ?>
        </div>
    <?php else: ?>
        <div class="bouton-accueil-cluedo">
            <?= anchor('/',
                    img([
                            'src' => base_url('images/commun/btn_retour/home_icone_7.webp'),
                            'alt' => 'Mascotte',
                            'class' => 'bouton-accueil-cluedo'

                    ])
            ) ?>
        </div>
    <?php endif?>

<div class="game-fixed-wrapper">

    <div class="accueil-bg" style="background-image:url('<?= base_url('/images/salle_2/Etape1_Salle3.jpg') ?>');"></div>

    <div class="center-container">
        <label for="poignier-toggle" class="poignier-contour" aria-controls="poignier-overlay" aria-haspopup="dialog"></label>
        <a class="code-contour" href="<?= base_url('/Salle2/Etape1a') ?>"></a>
        <a class="livre-contour" href="<?= base_url('/Salle2/Aide') ?>"></a>
    </div>

    <div class="mascotte-container">
        <img id="mascotte" src="<?= base_url('/images/salle_2/mascotte/mascotte_face.svg') ?>" alt="Mascotte">
    </div>

    <!-- Mascotte -->
    <div id="mascotte-bulle">
        <div id="bulle-texte"></div>
        <div id="bulle-actions"></div>
        <div class="bulle-fleche"></div>
    </div>
</div>

    <!-- Message Introduction-->
    <aside id="message-intro" class="tip-panel tip-panel--top tip-panel--autohide" role="status" aria-live="polite">
        <p class="tip-desc">
            <?= $libelles->libelle ?>
        </p>
    </aside>


    <!-- Div poignet permet d'indique a l'utilisateur d'aller clique sur le digicode -->
    <input type="checkbox" id="poignier-toggle" class="sr-only" aria-hidden="true" />
    <div id="poignier-overlay" class="poignier-overlay" role="dialog" aria-modal="true" aria-labelledby="poignier-texte">
        <aside class="poignier-panel">
            <p id="poignier-texte" class="tip-desc">
                 Bizarre la porte est fermé, je pense je devrais tape le code.
            </p>
            <label for="poignier-toggle" class="tip-btn" aria-label="Fermer ce message et continuer">Continuer</label>
        </aside>
    </div>

<!-- Scroll footer -->
</div>
<div class="scroll-flow">
    <div class="scroll-spacer"></div>
</div>
    <script src="<?= base_url('/js/salle_2/mascotte.js') ?>" defer></script>

</body>
</html>