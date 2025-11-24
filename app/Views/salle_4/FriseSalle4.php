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
            <button id="closeModalBtn" class="btn-modal">Retour à l'accueil</button>
        </div>
    </div>

    <!-- Bouton retour -->
    <?php if (session()->get('mode') === 'jour'): ?>
        <div class="retour-top">
            <?= anchor('/manoirJour', img([
                    'src'   => 'images/commun/btn_retour/home_icone_3.webp',
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

    <!-- Modal des règles -->
    <div class="modal" id="rulesModal">
        <div class="modal-content rules-modal-content">
            <span class="close-rules">&times;</span>

            <div class="rules-content">
                <div class="indices-container">
                    <?php if ($activite == 401): ?>
                        <h3>Indices pour l'ordre</h3>
                        <ul>
                            <li>Commence toujours par <strong>isoler</strong> avant d'agir : ça évite la propagation.</li>
                            <li>Une fois isolé, <strong>couper les accès réseau</strong> empêche l'attaque de continuer.</li>
                            <li>Avant d'aller plus loin, il faut <strong>prévenir l'équipe spécialisée</strong>, qui pourra superviser.</li>
                            <li>On <strong>conserve les preuves</strong> avant toute action invasive : sinon elles peuvent être perdues.</li>
                            <li>On ne peut <strong>bloquer la cause</strong> que lorsqu'on a sécurisé le périmètre.</li>
                            <li>Le <strong>nettoyage</strong> vient après l'identification du problème.</li>
                            <li>On <strong>restaure les sauvegardes</strong> seulement une fois sûr que tout est propre.</li>
                            <li>Le <strong>changement de mots de passe</strong> sert à sécuriser après récupération.</li>
                        </ul>
<!--                        <h3>Résumé très court</h3>-->
<!--                        <p><strong>Isole → Coupe → Alerte → Conserve → Identifie → Nettoie → Restaure → Sécurise</strong></p>-->
                    <?php else: ?>
                        <h3>Indices pour l'ordre</h3>
                        <ul>
                            <li>On commence toujours par des <strong>actions techniques de base</strong> : mise à jour, antivirus.</li>
                            <li>Ensuite viennent les <strong>mesures organisationnelles</strong> (droits, filtrage).</li>
                            <li>Les actions qui réduisent les <strong>risques humains</strong> arrivent ensuite (formation).</li>
                            <li>Enfin, ce qui garantit la <strong>résilience en cas de problème</strong> (sauvegardes).</li>
                        </ul>
<!--                        <h3>Résumé très court</h3>-->
<!--                        <p><strong>Solidifie → Protège → Limite → Filtre → Désactive → Segmente → Sensibilise → Sauvegarde</strong></p>-->
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