<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= link_tag('styles/salle2.css') ?>
    <script> const BASE_URL = "<?= base_url() ?>" </script>
        <script src="<?= base_url('/js/salle2.js') ?>"></script>
    <title>Salle 2 - Phishing</title>
</head>

<body>

<div class="content">
    <div class="bureau-wrapper" id="bureau">
        <img src="<?= base_url("/images/salle_2/bureau/bureau_sepia.webp")?>" alt="Bureau" class="bureau-svg bureau-normal">
        <img src="<?= base_url("/images/salle_2/bureau/bureau_orange.webp")?>" alt="Bureau hover" class="bureau-svg bureau-hover">
    </div>

<?= anchor(base_url(), 'Accueil', ['class' => 'btn-accueil']); ?>

</div>
</body>
</html>


