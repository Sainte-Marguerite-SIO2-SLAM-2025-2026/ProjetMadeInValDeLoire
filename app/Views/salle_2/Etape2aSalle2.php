<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= esc($title ?? 'Coffre Fort | Salle Mot de Passe') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/Etape2a_Salle3.webp') ?>">

    <link rel="stylesheet" href="<?= base_url('/styles/salle_2/style_etape_S3.css') ?>?v=4">
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

    <div class="accueil-bg" style="background-image:url('<?= base_url('/images/salle_2/Etape2a_Salle3.webp') ?>');"></div>

    <div class="center-container">
        <label for="poignier-toggle" class="carton-contour" aria-controls="poignier-overlay" aria-haspopup="dialog"></label>
        <a class="malette-contour" href="<?= base_url('/Salle2/Etape3') ?>"></a>
    </div>

    <aside id="intro-tip" class="tip-panel tip-panel--top tip-panel--autohide" role="status" aria-live="polite">
        <p class="tip-desc">
            <?= $libelles->libelle ?>
        </p>
    </aside>

    <input type="checkbox" id="poignier-toggle" class="sr-only" aria-hidden="true" />
    <div id="poignier-overlay" class="poignier-overlay" role="dialog" aria-modal="true" aria-labelledby="poignier-texte">
        <aside class="poignier-panel">
            <p id="poignier-texte" class="tip-desc">
                Je pense que je devrais prendre la mallette en premier, comme il est dit dans le livre de Monsieur Fox.
            </p>
            <label for="poignier-toggle" class="tip-btn" aria-label="Fermer ce message et continuer">Continuer</label>
        </aside>
    </div>

</div> <div class="scroll-flow">
    <div class="scroll-spacer"></div>

</div>

</body>
</html>