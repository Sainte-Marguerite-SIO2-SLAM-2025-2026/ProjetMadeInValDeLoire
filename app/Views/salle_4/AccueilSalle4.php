<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lockdown - Accueil</title>
    <?= link_tag('styles/salle_4/salle4.css'); ?>
</head>
<body>

<div class="image-container">
    <!-- Zone Frise - Bloquée si déjà validée -->
    <?php if (!$frise_validee || session()->get('mode') === 'jour'): ?>
        <?= anchor(base_url().'pageFrise', ' ', [ 'class' => 'clickable-zone zone1' ] );?>
    <?php else: ?>
        <div class="clickable-zone zone1 zone-bloquee">
            <div class="overlay-bloque">Validé</div>
        </div>
    <?php endif; ?>

    <!-- Zone Quiz - Bloquée si frise pas validée -->
    <?php if ($quiz_disponible || session()->get('mode') === 'jour'): ?>
        <?= anchor(base_url().'quizFin', ' ', [ 'class' => 'clickable-zone zone2' ] );?>
    <?php else: ?>
        <div class="clickable-zone zone2 zone-bloquee">
        </div>
    <?php endif; ?>

    <!-- Bouton retour -->
    <?php if (session()->get('mode') === 'jour'): ?>
        <div class="retour-top">
            <?= anchor('/manoirJour', img([
                    'src'   => $salle['bouton'],
                    'alt'   => 'retour',
                    'class' => 'retour'
            ])); ?>
        </div>
    <?php else: ?>
        <div class="retour-top">
            <?= anchor('/', img([
                    'src'   => $salle['bouton'],
                    'alt'   => 'retour',
                    'class' => 'retour'
            ])); ?>
        </div>
    <?php endif?>

    <!-- Mascotte -->
    <div class="mascotte-zone" id="mascotte-container">
        <?= anchor(base_url(), img([
                'src'   => $mascotte['face'],
                'alt'   => 'Mascotte',
                'class' => 'mascotte-img mascotte-default'
        ])); ?>

        <?= anchor(base_url(), img([
                'src'   => $mascotte['exclamee'],
                'alt'   => 'Mascotte Hover',
                'class' => 'mascotte-img mascotte-hover'
        ])); ?>
    </div>

    <?php if ($premiere_visite): ?>
        <div id="startModal" class="modal-welcome">
            <div class="modal-welcome-content">
                <span class="close-start"></span>

                <div class="modal-welcome-header">
                    <h2><?= $salle['libelle']; ?></h2>
                </div>
                <div class="modal-welcome-body">
                    <div class="situation-box">
                        <p><?=$salle['intro_salle'];?></p>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <!-- Modal Lumi -->
    <div id="rulesModal" class="modal">
        <div class="modal-content rules-modal-content">
            <span class="close-rules">&times;</span>
            <h2>Notes d'enquête</h2>
            <div class="rules-content">
                <h3>Indices repérés :</h3>
                <?= $indice->libelle;?>
            </div>
        </div>
    </div>
</div>

<script>
    const baseUrl = '<?= base_url() ?>';
</script>
<?= script_tag('js/salle_4/salle4.js'); ?>
