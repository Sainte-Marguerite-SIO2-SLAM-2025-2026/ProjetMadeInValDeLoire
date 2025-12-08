<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle 4</title>
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
<!--                        <h2>-->
<!--                            Bienvenue dans la salle des ransomwares !-->
<!--                            Découvrez comment ces logiciels malveillants parviennent à bloquer l’accès aux données et ce qu’il faut mettre en place pour s’en protéger.-->
<!--                        </h2>-->
<!--                        <h3>Mission</h3>-->
<!--                        <p>-->
<!--                            Explorez les éléments autour de vous, analysez les bonnes pratiques et apprenez à sécuriser un système avant qu’il ne soit trop tard.-->
<!--                            Ici, l’anticipation et la prévention font toute la différence.-->
<!--                        </p>-->
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
                <p>
                    <strong>Zone 1 - Tableau chronologique :</strong> Une frise temporelle est accrochée au-dessus du lit.
                    Elle retrace l'ensemble des événements de l'attaque dans l'ordre chronologique.
                    Analysez-la pour comprendre comment l'attaque s'est déroulée.
                </p>
                <p>
                    <strong>Zone 2 - Dossier d'expertise :</strong> Un dossier de test gît par terre, près du bureau.
                    Il contient des questions pour évaluer vos connaissances en cybersécurité.
                    Répondez correctement pour progresser dans l'enquête.
                </p>
                <p>
                    <strong>Recommandation :</strong> Examinez d'abord la chronologie pour comprendre l'attaque,
                    puis testez vos connaissances avec le dossier d'expertise.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    const baseUrl = '<?= base_url() ?>';
</script>
<?= script_tag('js/salle_4/salle4.js'); ?>
