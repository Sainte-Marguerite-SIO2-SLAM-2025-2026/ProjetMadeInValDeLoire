<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relier des cartes - Frise chronologique</title>
    <?= link_tag('styles/salle_4/friseSalle4.css') ?>
</head>
<body>

<div class="fond">
    <div id="info-container">
        <div id="info">
            Cliquez sur les cartes dans l'ordre chronologique pour reconstituer la procédure
        </div>
    </div>
    <div id="gameContainer">
        <canvas id="canvas" width="1300" height="790"></canvas>

        <?php if (!empty($cartes)): ?>
            <?php
            // Positions ajustées pour les cartes plus grandes
            $positions = [
                    ['x' => 4, 'y' => 8],
                    ['x' => 8, 'y' => 43],
                    ['x' => 35, 'y' => 2],
                    ['x' => 45, 'y' => 35],
                    ['x' => 78, 'y' => 24],
                    ['x' => 57, 'y' => 8],
                    ['x' => 32, 'y' => 63],
                    ['x' => 70, 'y' => 66]
            ];

            foreach ($cartes as $index => $carte):
                $pos = $positions[$index] ?? $positions[0];
                ?>
                <div class="carte-container carte-pos-<?= ($index + 1) ?>"
                     style="left: <?= $pos['x'] ?>%; top: <?= $pos['y'] ?>%;">
                    <?= img([
                            'src'      => base_url('images/salle_4/images_finales/PNG/' . esc($carte['image'])),
                            'class'    => 'carte',
                            'id'       => 'carte' . ($index + 1),
                            'data-id'  => ($index + 1),
                            'data-numero' => esc($carte['numero']),
                            'alt'      => 'Carte ' . ($index + 1)
                    ]); ?>
                    <div class="explication"><?= $carte['explication'] ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune carte trouvée pour cette activité.</p>
        <?php endif; ?>

        <!-- Zone d'information intégrée en haut du gameContainer -->

    </div>

    <!-- Contrôles en bas de la page -->
    <div class="controls-bottom">
        <button id="resetBtn" class="btn-control btn-reset">
            <span class="btn-icon">🔄</span>
            <span class="btn-text">Réinitialiser</span>
        </button>
        <button id="undoBtn" class="btn-control btn-undo">
            <span class="btn-icon">↶</span>
            <span class="btn-text">Annuler</span>
        </button>
        <button id="validateBtn" class="btn-control btn-validate" disabled>
            <span class="btn-icon">✓</span>
            <span class="btn-text">Valider</span>
        </button>
    </div>

    <!-- Modal de résultat -->
    <div id="resultModal" class="modal">
        <div class="modal-content">
            <h2 id="resultTitle"></h2>
            <p id="resultMessage"></p>
            <div id="explicationZone" style="display:none;">
                <h3>📋 Ordre correct :</h3>
                <ol id="ordreCorrectList"></ol>
            </div>
            <button id="closeModalBtn" class="btn-modal">Retour à l'accueil</button>
        </div>
    </div>

    <?= anchor(base_url(), img([
            'src'   => 'images/commun/btn_retour/home_icone_3.webp',
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
    <div class="modal" id="rulesModal">
        <div class="modal-content rules-modal-content">
            <span class="close-rules">&times;</span>
            <h2>📋 Règles du jeu - Frise</h2>
            <div class="rules-content">
                <h3>🎯 Objectif</h3>
                <p>Reconstituer la procédure correcte en reliant les cartes dans le bon ordre chronologique.</p>

                <h3>🎮 Comment jouer ?</h3>
                <ol>
                    <li><strong>Cliquez sur une première carte</strong> pour la sélectionner</li>
                    <li><strong>Cliquez sur une deuxième carte</strong> pour les relier</li>
                    <li>La première carte se verrouille, la deuxième reste active</li>
                    <li><strong>Continuez à relier</strong> toutes les cartes dans l'ordre</li>
                    <li><strong>Validez</strong> votre ordre avec le bouton "Valider"</li>
                </ol>

                <h3>🔧 Outils disponibles</h3>
                <ul>
                    <li><strong>🔄 Réinitialiser :</strong> Tout recommencer</li>
                    <li><strong>↶ Annuler :</strong> Annuler la dernière liaison</li>
                    <li><strong>✓ Valider :</strong> Vérifier si l'ordre est correct</li>
                </ul>

                <h3>💡 Astuce</h3>
                <p>Lisez attentivement les descriptions sur chaque carte pour trouver l'ordre logique !</p>
            </div>
        </div>
    </div>

</div>

<script>
    const baseUrl = '<?= base_url() ?>';
</script>
<?= script_tag('js/salle_4/friseSalle4.js') ?>

</body>
</html>