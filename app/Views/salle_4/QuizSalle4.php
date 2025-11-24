<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Ransomware - Salle 4</title>
    <?= link_tag('styles/salle_4/quizSalle4.css') ?>
</head>
<body>

<div class="fond">

    <!-- Dossier ouvert (container) -->
    <div id="dossier-container">
        <?= img([
//                'src'   => 'images/salle_4/images_finales/PNG/dossier_ouvert_plein.png',
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
        <div class="modal-content question-modal-content">
            <span class="close-question">&times;</span>

            <!-- Carte en grand format -->
            <div class="carte-grande">
                <img id="carte-grande-img"
                     src=""
                     alt="Carte"
                     class="carte-grande-img">
                <div class="question-text" id="question-text"></div>
            </div>

            <!-- Boutons Vrai/Faux -->
            <div class="reponses-buttons">
                <button type="button" id="btn-vrai" class="btn-reponse btn-vrai">VRAI</button>
                <button type="button" id="btn-faux" class="btn-reponse btn-faux">FAUX</button>
            </div>
        </div>
    </div>

    <!-- Modal de résultat final -->
    <div id="resultModal" class="modal">
        <div class="modal-content result-modal-content">
            <h2 id="resultTitle"></h2>
            <p id="resultMessage"></p>
            <p id="scoreMessage"></p>
            <button id="btnRetourAccueil" class="btn-retour-accueil">Retour à l'accueil</button>
        </div>
    </div>

    <!-- Bouton retour -->
    <?= anchor(base_url(), img([
            'src'   => 'images/salle_4/images_finales/home_icone_3.webp',
            'alt'   => 'retour',
            'class' => 'retour'
    ])); ?>

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

    <!-- Modal des règles -->
    <div id="rulesModal" class="modal">
        <div class="modal-content rules-modal-content">
            <span class="close-rules">&times;</span>
            <h2>📋 Règles du Quiz</h2>
            <div class="rules-content">
                <h3>🎯 Objectif</h3>
                <p>Répondre correctement à 6 questions sur les ransomwares.</p>

                <h3>🎮 Comment jouer ?</h3>
                <ol>
                    <li><strong>Cliquez sur une carte</strong> pour révéler une question</li>
                    <li><strong>Lisez attentivement</strong> la question affichée</li>
                    <li><strong>Choisissez VRAI ou FAUX</strong> selon votre réponse</li>
                    <li>Votre réponse est enregistrée automatiquement</li>
                    <li><strong>Continuez</strong> jusqu'à répondre aux 6 questions</li>
                    <li>Consultez votre <strong>score final</strong> !</li>
                </ol>

                <h3>⚠️ Important</h3>
                <ul>
                    <li>Une fois répondue, une carte ne peut plus être cliquée</li>
                    <li>Les questions restent les mêmes pendant toute la session</li>
                    <li>Votre score s'affiche en temps réel</li>
                </ul>

                <h3>💡 Astuce</h3>
                <p>Réfléchissez bien avant de répondre, vous n'avez qu'une seule chance par question !</p>
            </div>
        </div>
    </div>

</div>

<script>
    const baseUrl = '<?= base_url() ?>';
    const questionsData = <?= json_encode($questions) ?>;
</script>
<?= script_tag('js/salle_4/quizSalle4.js') ?>

</body>
</html>