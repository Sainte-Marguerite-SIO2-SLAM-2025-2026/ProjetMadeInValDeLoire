<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lockdown - Cartes</title>
    <?= link_tag('styles/salle_4/friseSalle4.css') ?>
</head>
<body>

<div class="fond">
    <div id="info-container">
        <div id="info">
            <?= ($explication['libelle']); ?>
        </div>
    </div>


    <div id="gameContainer">
        <canvas id="canvas" width="1300" height="790"></canvas>

        <?php if (!empty($cartes) && $activite == 401): ?>
            <?php
            // Positions ajustées pour les cartes plus grandes
            $positions = [
                    ['x' => 4, 'y' => 8],
                    ['x' => 35, 'y' => 2],
                    ['x' => 12, 'y' => 41],
                    ['x' => 72, 'y' => 11],
                    ['x' => 38, 'y' => 63],
                    ['x' => 70, 'y' => 55]
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
        <?php elseif (!empty($cartes) && $activite == 402): ?>
            <?php
            // Activité 402 : Trouver les bonnes pratiques parmi les pièges (8 cartes)
            // Positions pour 8 cartes
            $positions402 = [
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
                $pos = $positions402[$index] ?? $positions402[0];
                ?>
                <div class="carte-container carte-pos-<?= ($index + 1) ?>"
                     style="left: <?= $pos['x'] ?>%; top: <?= $pos['y'] ?>%;">
                    <?= img([
                            'src'      => base_url('images/salle_4/images_finales/PNG/' . esc($carte['image'])),
                            'class'    => 'carte carte-402',
                            'id'       => 'carte' . ($index + 1),
                            'data-id'  => ($index + 1),
                            'data-numero' => esc($carte['numero']),
                            'data-type' => esc($carte['type_carte']),
                            'alt'      => 'Carte ' . ($index + 1)
                    ]); ?>
                    <div class="explication"><?= $carte['explication'] ?></div>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <p>Aucune carte trouvée.</p>
        <?php endif; ?>


    </div>

    <?php if ($activite == 401): ?>
        <!-- Contrôles en bas de la page pour activité 401 uniquement -->
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
    <?php endif; ?>

    <!-- Modal de résultat -->
    <div id="resultModal" class="modal">
        <div class="modal-content">
            <h2 id="resultTitle"></h2>
            <p id="resultMessage"></p>
            <div id="explicationZone" style="display:none;">
                <h3>Ordre correct :</h3>
                <ol id="ordreCorrectList"></ol>
            </div>
            <button id="closeModalBtn" class="btn-modal">Retour au Manoir</button>
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

    <!-- Modal des règles -->

    <div id="rulesModal" class="modal">
        <div class="modal-content rules-modal-content">
            <span class="close-rules">&times;</span>
            <h2>Notes d'enquête</h2>
            <div class="rules-content">
                <h3>Indices :</h3>
                <?= $indice->libelle;?>
            </div>
        </div>
    </div>

</div>

<script>
    const baseUrl = '<?= base_url() ?>';
    const mode =  "<?= esc(session()->get('mode')) ?>";
    const activite = <?= $activite ?>;
</script>

<?php if ($activite == 401): ?>
<?= script_tag('js/salle_4/friseSalle4.js') ?>
<?php else: ?>
<?= script_tag('js/salle_4/carte.js') ?>
<?php endif; ?>

</body>
</html>
