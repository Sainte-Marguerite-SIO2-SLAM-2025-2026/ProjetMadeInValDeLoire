<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= link_tag('styles/salle_3/salle3_enigme.css') ?>
    <?= script_tag('js/salle_3/enigmeSalle3.js') ?>
    <title>Salle 3 - Énigme</title>
</head>
<header>

</header>
<body>
<?php $mode = session()->get("mode"); ?>

<!-- Récupération des données du contrôleur pour l'envoyer au JS ensuite -->
<div id="data" data-indices='<?= esc(json_encode($indices), "attr") ?>' data-mails='<?= esc(json_encode($mails, JSON_UNESCAPED_UNICODE), "attr") ?>'></div>

<div class="background-container">

    <img id="bg-img" src="<?= base_url('images/salle_3/dessus_bureau/dessus_bureau.webp') ?>" alt="Fond" style="width:1600px; height:900px; display:block;">


    <div class="map-container" style="position:absolute; top:0; left:0; width:100%; height:100%;">
        <!-- Enveloppes générées dynamiquement via JS -->

    </div>

</div>

<?php if ($mode == 'nuit') : ?>
    <?= anchor(base_url(), ' ', ['class' => 'accueil-btn']); ?>
<?php else : ?>
    <?= anchor(base_url('/manoirJour'), ' ', ['class' => 'accueil-btn']); ?>
<?php endif; ?>


<div class="mascotte-container">
    <?php $img = ['id' => 'mascotte', 'src' => 'images/commun/mascotte/mascotte_face.svg',  'alt' => 'Mascotte'];
    echo img($img);
    ?>

    <div id="mascotte-tooltip" class="tooltip">
        Voici un indice ! <br>
        Pense toujours à vérifier l'adresse d'expéditeur.
    </div>
</div>

<div id="modalOverlay">
    <div id="envelopeModal" class="modal">

        <div class="modal-content">

            <div class="modal-body">
                <img id="modal-image" src="" alt="Image modale">
                <div class="modal-text">
                    <h2>Expéditeur : </h2>
                    <h3>Objet : </h3>
                    <p>Contenu : </p>
                </div>
            </div>

            <div class="modal-buttons">
                <button id="btn-legitime">Légitime</button>
                <button id="btn-frauduleux">Frauduleux</button>
            </div>

            <span class="close-btn">&times;</span>
        </div>
    </div>

    <div id="scoreModal" class="modal">
        <div class="modal-content score-content">
            <h2>Résultat :</h2>
            <p id="score-text"></p>

            <div id="resultButtons" class="buttons-zone" style="margin-top:20px;">
                <?php if ($mode === "jour") : ?>
                    <?= form_open(base_url('/echouerJour/3')) ?>
                    <?= form_button([
                        'content' => 'Retour au manoir',
                        'type' => 'submit',
                        'class' => 'btn-echoue',
                    ]) ?>
                    <?= form_close() ?>
                    <?= form_open(base_url('/validerJour/3')) ?>
                    <?= form_button([
                        'content' => 'Valider la salle',
                        'type' => 'submit',
                        'class' => 'btn-reussie',
                    ]) ?>
                    <?= form_close() ?>
                <?php else : ?>
                    <?= form_open(base_url('/reset')) ?>
                    <?= form_button([
                        'content' => 'Recommencer le parcours',
                        'type' => 'submit',
                        'class' => 'btn-echoue',
                    ]) ?>
                    <?= form_close() ?>
                    <?= form_open(base_url('/valider/3')) ?>
                    <?= form_button([
                        'content' => 'Valider la salle',
                        'type' => 'submit',
                        'class' => 'btn-reussie',
                    ]) ?>
                    <?= form_close() ?>
                <?php endif; ?>
            </div>
        </div>
        <img id="score-mascotte" src="" alt="Mascotte score" style="width:300px; position:absolute; right:-450px; bottom:250px;">
    </div>
</div>
<button id="btn-valider" style="display:none; position:fixed; bottom:20px; left:50%; transform:translateX(-50%); padding:10px 20px; font-size:16px; z-index:1000;">Valider</button>

</body>
</html>
