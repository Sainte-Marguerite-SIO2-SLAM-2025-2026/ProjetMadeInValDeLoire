<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= link_tag('public/styles/salle2_enigme.css') ?>
    <script> const BASE_URL = "<?= base_url() ?>"</script>
    <script src="<?= base_url('/public/js/salle2.js') ?>"></script>
    <title>Salle 2 - Énigme</title>
</head>
<body>

<div class="background-container">
    <main class="enigme-page">

        <map name="image-map">
            <area alt="Zone 1" coords="743,367,345,123" shape="rect" data-zone="1">
            <area alt="Zone 2" coords="1266,348,915,115" shape="rect" data-zone="2">
            <area alt="Zone 3" coords="1548,472,1214,262" shape="rect" data-zone="3">
            <area alt="Zone 4" coords="682,247,1035,481" shape="rect" data-zone="4">
            <area alt="Zone 5" coords="1667,701,1307,486" shape="rect" data-zone="5">
            <area alt="Zone 6" coords="275,947,665,719" shape="rect" data-zone="6">
            <area alt="Zone 7" coords="1171,871,1586,644" shape="rect" data-zone="7">
            <area alt="Zone 8" coords="338,431,735,660" shape="rect" data-zone="8">
            <area alt="Zone 9" coords="688,714,1048,507" shape="rect" data-zone="9">
            <area alt="Zone 10" coords="770,885,1184,672" shape="rect" data-zone="10">
        </map>
        <section class="table-container">

            <?php for ($i = 1; $i <= 10; $i++) : ?>

            <div class="enveloppe" data-id="<?= $i ?>" data-content="Contenu de l'enveloppe <?= $i ?>">
                <?php $image = ['src' => 'public/images/enveloppes/enveloppe_sepia.webp', 'alt' => 'Enveloppe <?= $i ?>', 'class' => 'enveloppe-img'];
                echo img($image); ?>
            </div>

            <?php endfor; ?>

        </section>

        <?= anchor(base_url(). '/public', 'Accueil', ['class' => 'accueil-btn']) ?>

    </main>

<!-- Modal pour afficher le contenu des mails (avec les boutons en +)-->
    <div id="enveloppe-modal" class="modal hidden" aria-hidden="true" role="dialog" aria-modal="true">

        <div class="modal-content" role="document">

            <button id="modal-close" class="modal-close" aria-label="Fermer">&times;</button>

            <div class="modal-body">
            <!-- A compléter une fois les données en base de données -->
                <h2 id="modal-title">Enveloppe</h2>
                <p id="modal-text">...</p>
            </div>

            <div class="modal-actions">
                <button id="btn-legit" class="btn-action btn-legit">Légitime</button>
                <button id="btn-fraude" class="btn-action btn-fraude">Frauduleux</button>
            </div>

        </div>
    </div>
</div>
</body>
</html>
