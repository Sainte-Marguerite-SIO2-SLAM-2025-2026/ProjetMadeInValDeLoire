<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle 1 - Code</title>
    <?= link_tag(base_url().'styles/salle_1/salle1Global.css') ?>
    <?= link_tag(base_url('styles/salle_1/salle1Code.css')) ?>
</head>
<body>
<div class="background-container">
    <div id="timer" class="timer"></div>
    <div class="content-container">

        <h1 class="titre">Entrez le code pour ouvrir la porte</h1>

        <!-- FORMULAIRE -->
        <form id="code-form" class="code-container">
            <input type="text" id="code-input" maxlength="4" placeholder="----" />
            <button type="submit">Valider</button>
        </form>

    </div>

    <!-- Boutons de navigation -->
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

        <?= anchor(
                base_url('/'), img([
                        'src' => $mascotte['face'],
                        'alt' => 'Mascotte',
                        'class' => 'mascotte-image'
                ])
        ); ?>
    </div>

</div>

<!-- POPUP -->
<div id="popup" class="popup" style="display:none;">
    <div class="popup-content">
        <img src="<?= $mascotte['exclamee'] ?>"
             alt="Mascotte"
             class="mascotte-popup">
        <h2 id="popup-titre"></h2>
        <p id="popup-message"></p>
        <button id="popup-fermer">Fermer</button>
    </div>
</div>

<!-- POPUP ÉCHEC -->
<div id="popup-echec" class="popup popup-echec" style="display: none;">
    <div class="popup-content popup-echec-content">
        <?= img([
                'src' => $mascotte['face'],
                'alt' => 'Mascotte',
                'class' => 'mascotte-popup'
        ]) ?>
        <h2>Échec !</h2>
        <p>Malheureusement vous n'avez pas réussi l'énigme de la salle</p>
        <?php if (session()->get('mode') === 'jour'): ?>
            <div class="popup-actions">
                <?= form_open(base_url('/echouerJour/1')) ?>
                <?= form_button([
                        'content' => "Retour à l'accueil",
                        'type'    => 'submit',
                        'class' => 'btn-echec'

                ]) ?>
                <?= form_close() ?>
            </div>
        <?php else: ?>
            <p>Vous devez recommencer le parcours.</p>
            <?= form_open(base_url('/reset')) ?>
            <?= form_button([
                    'content' => "Retour à l'accueil",
                    'type'    => 'submit',
                    'class' => 'btn-echec'
            ]) ?>
            <?= form_close() ?>
        <?php endif ?>
    </div>
</div>

<!-- VARIABLES JAVASCRIPT -->
<script>
    const BASE_URL = '<?= base_url(); ?>';
    const MODE = '<?= session()->get('mode') ?? 'nuit'; ?>';
</script>
<?= script_tag(base_url('js/salle_1/salle1Code.js')) ?>
<?= script_tag(base_url('js/salle_1/salle1Timer.js')) ?>
</body>
</html>