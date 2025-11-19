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
<div class="background-container">
    <!-- Timer -->
    <div id="timer" class="timer"></div>

    <!-- Nom du personnage -->
    <div id="nom-personnage">
        <?= esc($nom_personnage) ?>
    </div>

    <div class="content-container">
        <?= img([
                'src' => base_url($image_perso ?? 'salle_1/images/personnages/monstre1.webp'),
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
                        'src' => base_url('salle_1/images/serrure/serrure_noire.webp'),
                        'alt' => 'Serrure',
                        'class' => 'serrure-image'
                ])); ?>
    </div>

    <!-- Boutons retour -->
    <div class="buttons">
        <?= anchor(
                base_url('Salle1'),
                '<div class="retour-wrapper">'
                .img([
                        'src' => base_url('salle_1/images/boutons/retour-et-indice_blanc.webp'),
                        'alt' => 'Retour',
                        'class' => 'button-image'
                ])
                .'<span class="retour-texte">Page précédente</span>'
                .'</div>'
        ); ?>

        <?= anchor(
                base_url('/'),
                '<div class="retour-wrapper">'
                .img([
                        'src' => base_url('salle_1/images/boutons/retour-et-indice_blanc.webp'),
                        'alt' => 'Menu',
                        'class' => 'button-image'
                ])
                .'<span class="retour-texte">Retour au menu</span>'
                .'</div>'
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

<!-- POPUP INDICE -->
<div id="popup-indice" class="popup" style="display:none;">
    <div class="popup-content">
        <h2>💡 Indice</h2>
        <p id="indice-message"></p>
        <button id="indice-fermer">Fermer</button>
    </div>
</div>

<script>
    const BASE_URL = '<?= base_url(); ?>';
    const INDICES = <?= json_encode($indices ?? [], JSON_UNESCAPED_UNICODE) ?>;
</script>
<?= script_tag(base_url('js/salle1Discussion.js')) ?>
<?= script_tag(base_url('js/salle1Timer.js')) ?>
</body>
</html>