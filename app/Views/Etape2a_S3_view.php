<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title> Coffre Fort | Salle N°3</title>

    <!-- Police  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <!-- image de fond -->
    <link rel="preload" as="image" href="<?= base_url('/assets/images/Etape2a_Salle3.jpeg') ?>">

    <link rel="stylesheet" href="<?= base_url('/assets/css/style_etape_S3.css') ?>?v=4">
</head>
<body>
<div class="accueil-bg" style="background-image:url('<?= base_url('/assets/images/Etape2a_Salle3.jpeg') ?>');"></div>






<div class="center-container">
    <label for="poignier-toggle" class="carton-contour" aria-controls="poignier-overlay" aria-haspopup="dialog"></label>
    <a class="malette-contour" href="<?= base_url('etape3') ?>"></a>

    <a class="code-contour" href="<?= base_url('etape1a') ?>"></a>
    <a class="livre-contour" href="<?= base_url('aide') ?>"></a>
</div>

<aside id="intro-tip" class="tip-panel tip-panel--top tip-panel--autohide" role="status" aria-live="polite">
    <p class="tip-desc">
        Récupère cette mallette qui était dans le coffre de Monsieur Renard. Attention, elle pourrait être ouverte.    </p>
    </p>
</aside>

<input type="checkbox" id="poignier-toggle" class="sr-only" aria-hidden="true" />
<div id="poignier-overlay" class="poignier-overlay" role="dialog" aria-modal="true" aria-labelledby="poignier-texte">
    <aside class="poignier-panel">
        <p id="poignier-texte" class="tip-desc">
            Je pense que je devrais prendre la mallette en premier, comme il est dit dans le livre de Monsieur Renard.
        </p>
        <label for="poignier-toggle" class="tip-btn" aria-label="Fermer ce message et continuer">Continuer</label>
    </aside>
</div>













<div class="retour-buttons">
    <a class="btn btn--ghost btn--xl btn-passe" href="<?= base_url('/etape3') ?>">Admin</a>
</div>

</body>
</html>