<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle 1 - Discussion</title>
    <?= link_tag(base_url().'styles/salle1Global.css') ?>
    <?= link_tag(base_url('styles/salle1Discussion.css')) ?>
</head>
<body>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Remet le timer à zéro
        sessionStorage.removeItem("startTime");
        sessionStorage.setItem("startTime", Date.now());
    });
</script>

<div class="background-container">
    <!-- Timer -->
    <div id="timer" class="timer"></div>

    <!-- Nom du personnage -->
    <div id="nom-personnage">
        <?= esc($nom_personnage) ?>
    </div>

    <div class="content-container">
        <?= img([
                'src' => base_url($image_perso ?? 'images/salle_1/images/personnages/monstre1.webp'),
                'alt' => esc($nom_personnage),
                'class' => 'perso-discussion',
                'id'   => 'fantome'
        ]); ?>

        <!-- Zone de texte -->
        <div id="text-zone"
             class="text-zone"
             data-activite="<?= $activite_numero ?? 0 ?>"
             data-mots='<?= json_encode(explode(" ", $message ?? ''), JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT) ?>'
             data-suspects='<?= json_encode($mots_suspects ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT) ?>'
             data-erreurs='<?= json_encode($erreurs_explications ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
        </div>

        <!-- Bouton indice -->
        <?php if (!empty($indices)): ?>
            <div class="indice-container">
                <button class="btn-indice" id="btn-indice">
                    💡 Indice (<span id="indices-restants"><?= count($indices) ?></span>)
                </button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Serrure (vers la suite du jeu) -->
    <div class="serrure">
        <?= anchor(base_url('Salle1/Code'),
                img([
                        'src' => base_url('images/salle_1/images/serrure/serrure_noire.webp'),
                        'alt' => 'Serrure',
                        'class' => 'serrure-image'
                ])); ?>
    </div>

    <!-- Boutons retour -->
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
                base_url('salle/salle_1'),
                '<div class="retour-wrapper">'
                .img([
                        'src' => base_url('images/salle_1/images/boutons/retour-et-indice_blanc.webp'),
                        'alt' => 'Retour',
                        'class' => 'button-image'
                ])
                .'<span class="retour-texte">Page précédente</span>'
                .'</div>'
        ); ?>

        <?= anchor(
                base_url('/'), img([
                        'src' => base_url('images/commun/mascotte/mascotte_interrogee.svg'),
                        'alt' => 'Mascotte',
                        'class' => 'mascotte-image'
                ])
        ); ?>

    </div>
</div>



<!-- POPUP -->
<div id="popup" class="popup" style="display:none;">
    <div class="popup-content">
        <h2 id="popup-titre">Bravo !</h2>
        <p id="popup-message"></p>
        <div id="popup-explication" class="popup-explication" style="display:none;"></div>
        <button id="popup-fermer">Fermer</button>
    </div>
</div>

<div id="popup-echec" class="popup popup-echec" style="display: none;">
    <div class="popup-content popup-echec-content">
        <?= img([
                'src' => base_url('images/commun/mascotte/mascotte_saoulee.svg'),
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
        <?php elseif (session()->get('mode') === 'nuit'): ?>
            <p>Vous devez recommencer le parcours.</p>
            <?= form_open(base_url('/reset')) ?>
            <?= form_button([
                    'content' => "Retour à l'accueil",
                    'type'    => 'submit',
                    'class' => 'btn-echec'
            ]) ?>
        <?php endif ?>
    </div>
</div>
<?= script_tag(base_url('js/salle1Discussion.js')) ?>
<?= script_tag(base_url('js/salle1Timer.js')) ?>
</body>
</html>