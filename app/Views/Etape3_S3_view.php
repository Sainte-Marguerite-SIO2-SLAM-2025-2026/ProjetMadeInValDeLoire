<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title> Coffre Fort | Salle N°3</title>

    <!-- Police  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <!-- image de fond -->
    <link rel="preload" as="image" href="<?= base_url('/assets/images/Etape3_Salle3.jpeg') ?>">

    <link rel="stylesheet" href="<?= base_url('/assets/css/style_etape_S3.css') ?>?v=4">
</head>
<body>
<div class="accueil-bg" style="background-image:url('<?= base_url('/assets/images/Etape3_Salle3.jpeg') ?>');"></div>

<div class="valide-malette">




</div>
<div class="reset-malette">



</div>


<div class="retour-buttons">
    <a class="btn btn--ghost btn--xl btn-passe" href="<?= base_url('/etape4') ?>">Admin</a>
</div>























<!-- Message d’intro en haut, centré, auto-disparition après 30s -->
<aside class="tip-panel tip-panel--top tip-panel--autohide" role="status" aria-live="polite">
    <p class="tip-desc">
        Étape 3 : Trouve le mot de passe de cette mallette à l'aide du bouton généré , sans cela, tu ne trouveras pas le mot de passe. Elle te donnera des informations précieuses !    </p>
</aside>


</body>
</html>