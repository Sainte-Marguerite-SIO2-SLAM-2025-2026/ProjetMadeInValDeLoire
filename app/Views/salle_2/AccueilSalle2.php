<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= link_tag('/public/styles/salle2.css'); ?>
    <script>
        window.BASE_URL = "<?= base_url() ?>";
    </script>
        <script defer src="<?= base_url('/public/js/salle2.js') ?>"></script>
    <title>Salle 2 - Phishing</title>
</head>

<body>

<div class="game-container">
    <h1>Tri des mails - Phishing</h1>
    <p>Clique sur les enveloppes pour examiner les messages et décide s’ils sont légitimes ou non.</p>

        <div class="envelopes">
            <!-- Généré dynamiquement par JS -->
        </div>

    <button id="validate-btn" disabled>Valider mes choix</button>

</div>

<!-- Modal pour afficher le mail -->
<div id="mail-modal" class="modal hidden">
    <div class="modal-content">
        <span id="close-modal">&times;</span>
        <img id="mail-image" src="" alt="Mail affiché">
        <div class="choices">
            <button id="btn-legit" class="legit">Légitime</button>
            <button id="btn-phish" class="phish">Phishing</button>
        </div>
    </div>
</div>

</div>

<?= anchor(base_url().'public/', '<button>Retour</button>'); ?>

</body>
</html>


