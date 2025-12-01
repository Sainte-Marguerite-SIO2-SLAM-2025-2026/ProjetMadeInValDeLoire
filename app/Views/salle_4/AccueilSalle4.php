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
//                    'src'   => 'images/commun/btn_retour/home_icone_3.webp',
                    'src'   => $salle['bouton'],
                    'alt'   => 'retour',
                    'class' => 'retour'
            ])); ?>
        </div>
    <?php else: ?>
        <div class="retour-top">
            <?= anchor('/', img([
                    'src'   => 'images/commun/btn_retour/home_icone_3.webp',
                    'alt'   => 'retour',
                    'class' => 'retour'
            ])); ?>
        </div>
    <?php endif?>

    <!-- Mascotte interactive -->
    <div class="mascotte-zone" id="mascotte-container">
        <?= anchor(base_url(), img([
                'src'   => 'images/commun/mascotte/mascotte_face.svg',
                'alt'   => 'Mascotte',
                'class' => 'mascotte-img mascotte-default'
        ])); ?>

        <?= anchor(base_url(), img([
                'src'   => 'images/commun/mascotte/mascotte_exclamee.svg',
                'alt'   => 'Mascotte Hover',
                'class' => 'mascotte-img mascotte-hover'
        ])); ?>
    </div>


    <?php if ($premiere_visite): ?>
        <div id="startModal" class="modal-welcome">
            <div class="modal-welcome-content">
                <span class="close-start"></span>
                <div class="modal-welcome-header">
                    <h2>Salle 4 - Ransomware</h2>
                </div>
                <div class="modal-welcome-body">
                    <div class="situation-box">
                        <h3>Mission</h3>
                        <p> Vous venez de rentrer dans la chambre. Prenez le temps de bien observer les éléments qui vous entourent pour parvenir au bout de la salle.</p>
                    </div>

                    <div class="objectif-box">

                        <h3>Éléments à explorer</h3>
                        <ol>
                            <li>
                                <strong>Tableau</strong><br>
                                Les traces de l'incident sont éparpillées. Replacez chaque étape au bon endroit.
                            </li>
                            <li>
                                <strong>Dossier</strong><br>
                                Vérifiez vos connaissances sur la cyber-attaque de la salle en répondant à des questions rapides.
                            </li>
                        </ol>
                    </div>

                    <div class="conseil-box">
                        <h3>Progression</h3>
                        <ul>
                            <li>Le <strong>tableau</strong> contient les indices à analyser.</li>
                            <li>Le <strong>dossier</strong> permet d'évaluer votre compréhension après avoir réussi la première énigme.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Modal Lumi -->
    <div id="rulesModal" class="modal">
        <div class="modal-content rules-modal-content">
            <span class="close-rules">&times;</span>
            <h2>Salle 4</h2>
            <div class="rules-content">
                <p>Essayer de cliquer sur le tableau au dessus du lit ou bien sur le dossier par terre</p>
            </div>
        </div>
    </div>
</div>

<script>
    const baseUrl = '<?= base_url() ?>';
</script>
<?= script_tag('js/salle_4/salle4.js'); ?>
