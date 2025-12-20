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
            ?>
        <?php else: ?>
            <p>Aucune carte trouvée.</p>
        <?php endif; ?>


    </div>

    <!-- Contrôles en bas de la page -->
    <div class="controls-bottom">
        <button id="resetBtn" class="btn-control btn-reset">
            <span class="btn-icon"></span>
            <span class="btn-text">Réinitialiser</span>
        </button>
        <button id="undoBtn" class="btn-control btn-undo">
            <span class="btn-icon"></span>
            <span class="btn-text">Annuler</span>
        </button>
        <button id="validateBtn" class="btn-control btn-validate" disabled>
            <span class="btn-icon"></span>
            <span class="btn-text">Valider</span>
        </button>
    </div>

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
    <div class="modal" id="rulesModal">
        <div class="modal-content rules-modal-content">
            <span class="close-rules">&times;</span>

            <div class="rules-content">
                <div class="indices-container">
                    <?php if ($activite == 401): ?>
                        <h3>Indices pour l'ordre</h3>
                    <!-- mis dans la bdd mais faut faire le model-->
                        <ul>
                            <li>D'abord, Il faut limiter la propagation.</li>
                            <li>Avant d'aller plus loin, il faut mettre les spécialistes au courant</li>
                            <li>Puis analyser les problèmes rencontrés à cause de l'attaque</li>
                            <li>Le reste, je vous laisse voir par vous-mêmes !</li>
                        </ul>
                    <?php else: ?>
                        <h3>Indices pour l'ordre</h3>
                        <ul>
                            <li>Garde toujours tes <strong>systèmes à jour</strong> : les correctifs bloquent les failles exploitées par les attaquants.</li>
                            <li>Installe un <strong>antivirus performant</strong> : il détecte et neutralise les comportements suspects.</li>
                            <li><strong>Limite les droits administrateur</strong> : moins de privilèges = moins de dégâts en cas d’infection.</li>
                            <li><strong>Filtre les emails</strong> et les pièces jointes : c’est la meilleure façon d’éviter les pièges courants.</li>
                            <li><strong>Désactive les macros</strong> par défaut : elles sont souvent utilisées pour lancer des attaques.</li>
                            <li><strong>Ségmente ton réseau</strong> : une attaque sur une partie ne doit pas contaminer toute l’infrastructure.</li>
                            <li><strong>Forme les utilisateurs</strong> : ils représentent la première barrière contre les cybermenaces.</li>
                            <li>Effectue des <strong>sauvegardes régulières</strong> : elles permettent de récupérer rapidement après une attaque.</li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


</div>

<script>
    const baseUrl = '<?= base_url() ?>';
    const mode =  "<?= esc(session()->get('mode')) ?>";
</script>
<?= script_tag('js/salle_4/friseSalle4.js') ?>

</body>
</html>
