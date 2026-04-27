<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lockdown - Quiz</title>
    <?= link_tag('styles/salle_4/quizSalle4.css') ?>
</head>
<body>

<div class="fond">

    <!-- Dossier ouvert (container) -->
    <div id="dossier-container">
        <?= img([
                'src'   => 'images/salle_4/images_finales/dossier-interieur-vide.webp',
                'alt'   => 'Dossier ouvert',
                'class' => 'dossier-fond'
        ]); ?>

        <!-- 6 cartes -->
        <div id="cartes-quiz">
            <?php if (!empty($questions)): ?>
                <?php
                // Images différentes pour chaque carte
                $imagesCartes = [
                        'II-carte-03.webp',
                        'II-carte-09.webp',
                        'II-carte-05.webp',
                        'II-carte-06.webp',
                        'II-carte-07.webp',
                        'II-carte-08.webp'
                ];

                foreach ($questions as $index => $question):
                    $isAnswered = isset($reponses[$question['numero']]);
                    $imageCarte = $imagesCartes[$index];
                    ?>
                    <div class="carte-quiz <?= $isAnswered ? 'answered' : '' ?>"
                         data-question-id="<?= $question['numero'] ?>"
                         data-position="<?= $index ?>"
                         data-image="<?= $imageCarte ?>">
                        <?= img([
                                'src'   => 'images/salle_4/images_finales/' . $imageCarte,
                                'alt'   => 'Carte question ' . ($index + 1),
                                'class' => 'carte-quiz-img'
                        ]); ?>
                        <?php if ($isAnswered): ?>
                            <div class="carte-status">
                                <?= $reponses[$question['numero']]['correct'] ? '✓' : '✗' ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Score en temps réel -->
    <div id="score-display">
        Score : <span id="score">0</span> / 6
    </div>

    <!-- Modal pour afficher la question -->
    <div id="questionModal" class="modal">
        <div id="questionModal" class="modal-content question-modal-content">
            <span class="close-question">&times;</span>

            <!-- Carte en grand format -->
            <div class="carte-grande">
                <img id="carte-grande-img"
                     src=""
                     alt="Carte"
                     class="carte-grande-img">
                <div class="question-text" id="question-text"></div>

                <div class="reponses-buttons">
                    <button type="button" id="btn-vrai" class="btn-reponse btn-vrai">VRAI</button>
                    <button type="button" id="btn-faux" class="btn-reponse btn-faux">FAUX</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de résultat final -->
    <div id="resultModal" class="modal-fin">
        <div class="modal-content-fin result-modal-content">
            <h2 id="resultTitle"></h2>
            <p id="resultMessage"></p>
            <p id="scoreMessage"></p>
            <button id="btnRetourAccueil" class="btn-retour-accueil">Retourner au Manoir</button>
        </div>
    </div>

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
                    'alt'   => 'back',
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

    <!-- Modal des règles -->

    <div id="rulesModal" class="modal">
        <div class="modal-content rules-modal-content">
            <span class="close-rules">&times;</span>
            <h2>Notes d'enquête</h2>
            <div class="rules-content">
                <h3>Règles du quiz :</h3>
                <?= $indice->libelle;?>
            </div>
        </div>
    </div>

</div>

<script>
    const baseUrl = '<?= base_url() ?>';
    const questionsData = <?= json_encode($questions) ?>;
    const mode =  "<?= esc(session()->get('mode')) ?>";
</script>
<?= script_tag('js/salle_4/quizSalle4.js') ?>

</body>
</html>