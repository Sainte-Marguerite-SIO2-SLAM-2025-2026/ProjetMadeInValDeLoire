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
    <div id="info">
        Cliquez sur les cartes dans l'ordre chronologique pour reconstituer la frise
    </div>

    <div class="controls">
        <button id="resetBtn">🔄 Réinitialiser</button>
        <button id="undoBtn">↶ Annuler la dernière ligne</button>
        <button id="validateBtn">✓ Valider mon ordre</button>
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
    </div>

    <div id="resultModal" class="modal">
        <div class="modal-content">
            <h2 id="resultTitle"></h2>
            <p id="resultMessage"></p>
            <button id="closeModal">Fermer</button>
            <button id="retryBtn">Réessayer</button>
        </div>
    </div>

    <?= anchor(base_url() . 'Salle4', img([
            'src'   => 'images/commun/retour.png',
            'alt'   => 'retour',
            'class' => 'retour'
    ])); ?>

    <!--    --><?php //= anchor(base_url(), img([
    //        'src'   => 'images/commun/mascotte/mascotte_face.svg',
    //        'alt'   => 'mascotte',
    //        'class' => 'mascotte'
    //    ])); ?>

    <!--    <a id="lumi" class="zone-lumi" data-piece="Lumi">-->
    <!--        <image class="lumi-image default" width="130" height="150"-->
    <!--               x="--><?php //= 138 - 70 ?><!--" y="--><?php //= 114 - 35 ?><!--"-->
    <!--               clip-path="url(#clip_lumi)" preserveAspectRatio="xMidYMid slice"-->
    <!--               xlink:href="--><?php //= base_url('images/commun/mascotte/mascotte_face.svg') ?><!--"/>-->
    <!--        <image class="lumi-image hover" width="130" height="150"-->
    <!--               x="--><?php //= 138 - 70 ?><!--" y="--><?php //= 114 - 35 ?><!--"-->
    <!--               clip-path="url(#clip_lumi)" preserveAspectRatio="xMidYMid slice"-->
    <!--               xlink:href="--><?php //= base_url('images/commun/mascotte/mascotte_exclamee.svg') ?><!--"/>-->
    <!--        <ellipse class="lumi-zone" cx="138" cy="114" rx="150" ry="150"/>-->
    <!--    </a>-->

    <!--     Remplacez la ligne de la mascotte par celle-ci -->
    <!--    <div id="mascotte-container">-->
    <!--        --><?php //= img([
    //                'src'   => 'images/commun/mascotte/mascotte_face.svg',
    //                'alt'   => 'mascotte',
    //                'class' => 'mascotte',
    //                'id'    => 'mascotte-img'
    //        ]); ?>
    <!--    </div>-->
    <!---->
    <!--     Modal des règles -->
    <!--    <div id="rulesModal" class="modal">-->
    <!--        <div class="modal-content rules-modal-content">-->
    <!--            <span class="close-rules">&times;</span>-->
    <!--            <h2>📋 Règles du jeu</h2>-->
    <!--            <div class="rules-content">-->
    <!--                <h3>🎯 Objectif</h3>-->
    <!--                <p>Reconstituer la procédure correcte en reliant les cartes dans le bon ordre chronologique.</p>-->
    <!---->
    <!--                <h3>🎮 Comment jouer ?</h3>-->
    <!--                <ol>-->
    <!--                    <li><strong>Cliquez sur une première carte</strong> pour la sélectionner</li>-->
    <!--                    <li><strong>Cliquez sur une deuxième carte</strong> pour les relier</li>-->
    <!--                    <li>La première carte se verrouille, mais la deuxième reste active</li>-->
    <!--                    <li><strong>Continuez à relier</strong> toutes les cartes dans l'ordre</li>-->
    <!--                    <li><strong>Validez</strong> votre ordre avec le bouton "Valider"</li>-->
    <!--                </ol>-->
    <!---->
    <!--                <h3>🔧 Outils disponibles</h3>-->
    <!--                <ul>-->
    <!--                    <li><strong>🔄 Réinitialiser :</strong> Tout recommencer</li>-->
    <!--                    <li><strong>↶ Annuler :</strong> Annuler la dernière liaison</li>-->
    <!--                    <li><strong>✓ Valider :</strong> Vérifier si l'ordre est correct</li>-->
    <!--                </ul>-->
    <!---->
    <!--                <h3>💡 Astuce</h3>-->
    <!--                <p>Lisez attentivement les descriptions sur chaque carte pour trouver l'ordre logique !</p>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->

    <!-- Mascotte -->
    <div class="mascotte-zone" id="mascotteHelp">
        <img src="<?= base_url('images/commun/mascotte/mascotte_face.svg') ?>"
             class="mascotte-img mascotte-default"
             alt="Mascotte">

        <img src="<?= base_url('images/commun/mascotte/mascotte_exclamee.svg') ?>"
             class="mascotte-img mascotte-hover"
             alt="Mascotte hover">
    </div>


    <div class="modal" id="rulesModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">Lumi – C'est quoi l'idée ?</h5>
                    <span class="close-rules btn-close btn-close-white"></span>
                </div>

                <div class="modal-body">
                    <img src="<?= base_url('images/salles/lumi_full.webp') ?>"
                         alt="Lumi" class="img-fluid rounded mb-3">

                    <p>Bienvenue agent ! Vous venez d'intégrer la B.L.U.T., la Brigade un peu spéciale chargée de sécuriser
                        l'univers numérique. Votre mission : traverser les 6 salles du CyberManor pour prouver que vous êtes
                        prêt à rejoindre nos rangs...</p>

                    <p>La zone <strong>Lumi</strong> c'est .....</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-rules">Fermer</button>
                </div>
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