<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Code de la Porte | Salle N°3</title>

    <!-- Police -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">

    <link rel="preload" as="image" href="<?= base_url('/assets/images/Etape1a_Salle3.jpeg') ?>">

    <link rel="stylesheet" href="<?= base_url('/assets/css/style_etape_S3.css') ?>">
</head>
<body>

<div class="accueil-bg" style="background-image:url('<?= base_url('/assets/images/Etape1a_Salle3.jpeg') ?>');"></div>

<!-- Formulaire "invisible" pour parler au contrôleur -->
<form id="code-form" method="post" action="<?= current_url() ?>" autocomplete="off">

    <!-- Si CSRF activé, décommente ci-dessous -->
    <!-- <?= function_exists('csrf_field') ? csrf_field() : '' ?> -->
    <input type="hidden" name="code" id="code-hidden" value="<?= old('code') ?>">
</form>


<div class ="valide-contour">


</div>

<div class="reset-contour">

</div>

<div class="label-contour">

</div>



<div class="retour-buttons">
    <a class="btn btn--ghost btn--xl btn-retour" href="<?= base_url('/etape1') ?>">Retour</a>
</div>

<div class="retour-buttons">
    <a class="btn btn--ghost btn--xl btn-passe" href="<?= base_url('/etape2') ?>">Admin</a>
</div>

<script src="<?= base_url('/assets/js/etape1.js') ?>" defer></script>
</body>
</html>