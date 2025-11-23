<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan du Manoir</title>
    <?= link_tag('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css') ?>
    <?= link_tag('styles/style_nuit.css'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
<?php
// Définir quelles salles appartiennent à quel étage
$salles_etage0 = [1]; // Numéros des salles de l'étage 0
$salles_etage1 = [2, 3]; // Numéros des salles de l'étage 1
$salles_etage2 = [4, 5, 6]; // Numéros des salles de l'étage 2

$completed_rooms = session()->get('completed_rooms') ?? [];
$current_room = session()->get('current_room') ?? -1;

// L'escalier s'éclaire si la salle active OU une salle complétée est de cet étage
$etage0_actif = in_array($current_room, $salles_etage0) ||
        in_array($current_room, $salles_etage1) ||
        in_array($current_room, $salles_etage2) ||
        count(array_intersect($completed_rooms, $salles_etage0)) > 0;

$etage1_actif = in_array($current_room, $salles_etage1) ||
        in_array($current_room, $salles_etage2) ||
        count(array_intersect($completed_rooms, $salles_etage1)) > 0;

$etage2_actif = in_array($current_room, $salles_etage2) ||
        count(array_intersect($completed_rooms, $salles_etage2)) > 0;
?>

<div class="plan-container">
    <div class="svg-wrapper">
        <svg width="1920" height="1080" viewBox="0 0 1920 1080"
             xmlns="http://www.w3.org/2000/svg">
            <!-- Définition des clipPaths -->
            <defs>
                <clipPath id="clip_salle_1">
                    <rect width="848" height="212" x="410" y="760" rx="8" ry="8"/>
                </clipPath>
                <clipPath id="clip_salle_2">
                    <rect width="423" height="206" x="1073" y="542" rx="8" ry="8"/>
                </clipPath>
                <clipPath id="clip_salle_3">
                    <rect width="426" height="209" x="410" y="540" rx="8" ry="8"/>
                </clipPath>
                <clipPath id="clip_salle_4">
                    <rect width="423" height="209" x="1073" y="320" rx="8" ry="8"/>
                </clipPath>
                <clipPath id="clip_salle_5">
                    <rect width="426" height="209" x="410" y="320" rx="8" ry="8"/>
                </clipPath>
                <clipPath id="clip_salle_6">
                    <path d="M 387,300 577,105 1324,76 1516,299 Z"/>
                </clipPath>
                <clipPath id="clip_escalier_0">
                    <rect width="239" height="223" x="1264" y="749"/>
                </clipPath>
                <clipPath id="clip_escalier_1">
                    <rect width="219" height="205" x="844" y="544"/>
                </clipPath>
                <clipPath id="clip_escalier_2">
                    <rect width="219" height="228" x="844" y="319"/>
                </clipPath>

                <clipPath id="clip_lune_soleil">
                    <ellipse cx="1696" cy="130" rx="130" ry="118"/>
                </clipPath>
                <clipPath id="clip_lumi">
                    <ellipse cx="138" cy="114" rx="150" ry="150"/>
                </clipPath>
                <!-- Filtre halo lumineux pour Lumi -->
                <filter id="halo-lumi" x="-50%" y="-50%" width="200%" height="200%">
                    <feGaussianBlur in="SourceGraphic" stdDeviation="8" result="blur"/>
                    <feColorMatrix in="blur" type="matrix"
                                   values="1 0 0 0 0
                               1 0.8 0 0 0
                               0 0 1 0 0
                               0 0 0 1 0" result="glow"/>
                    <feComposite in="SourceGraphic" in2="glow" operator="over"/>
                </filter>

                <!-- Gradient radial pour le halo autour de lumi -->
                <radialGradient id="halo-gradient">
                    <stop offset="0%" style="stop-color:#fbe734;stop-opacity:0.8"/>
                    <stop offset="50%" style="stop-color:#f6ca3e;stop-opacity:0.4"/>
                    <stop offset="100%" style="stop-color:#faf3b7;stop-opacity:0"/>
                </radialGradient>
            </defs>

            <!-- IMAGE DE FOND (externe) -->
            <image
                    xlink:href="<?= base_url('images/manoir/home_manoir_eteint_leger.svg') ?>"
                    x="0"
                    y="0"
                    width="1920" height="1080"
                    id="image-fond"
                    style="pointer-events: none;"/> <!-- Important : pas d'interaction sur l'image -->

            <!-- Salle 1 -->
            <g id="salle_1" class="piece <?= in_array(1, session()->get('completed_rooms') ?? []) ? 'completed' : '' ?>"
               data-piece="Salle 1" data-numero="1">
                <image class="piece-image" width="848" height="212" x="410" y="760" rx="8" ry="8"
                       clip-path="url(#clip_salle_1)" preserveAspectRatio="xMidYMid slice"
                       xlink:href="<?= base_url('images/salles/salle_1.webp') ?>"/>
                <image class="piece-label" width="300" height="100" x="0" y="0"
                       xlink:href="<?= base_url('images/etiquettes/etiq_salle_1.svg') ?>"/>
                <rect class="piece-zone" width="848" height="212" x="410" y="760" rx="8" ry="8"/>
            </g>

            <!-- Salle 2 -->
            <g id="salle_2" class="piece <?= in_array(2, session()->get('completed_rooms') ?? []) ? 'completed' : '' ?>"
               data-piece="Salle 2" data-numero="2">
                <image class="piece-image" width="423" height="206" x="1073" y="542" rx="8" ry="8"
                       clip-path="url(#clip_salle_2)" preserveAspectRatio="xMidYMid slice"
                       xlink:href="<?= base_url('images/salles/salle_2.webp') ?>"/>
                <image class="piece-label" width="300" height="100" x="0" y="0"
                       xlink:href="<?= base_url('images/etiquettes/etiq_salle_2.svg') ?>"/>
                <rect class="piece-zone" width="423" height="206" x="1073" y="542" rx="8" ry="8"/>
            </g>

            <!-- Salle 3 -->
            <g id="salle_3" class="piece <?= in_array(3, session()->get('completed_rooms') ?? []) ? 'completed' : '' ?>"
               data-piece="Salle 3" data-numero="3">
                <image class="piece-image" width="426" height="209" x="410" y="540" rx="8" ry="8"
                       clip-path="url(#clip_salle_3)" preserveAspectRatio="xMidYMid slice"
                       xlink:href="<?= base_url('images/salles/salle_3.webp') ?>"/>
                <image class="piece-label" width="300" height="100" x="0" y="0"
                       xlink:href="<?= base_url('images/etiquettes/etiq_salle_3.svg') ?>"/>
                <rect class="piece-zone" width="426" height="209" x="410" y="540" rx="8" ry="8"/>
            </g>

            <!-- Salle 4 -->
            <g id="salle_4" class="piece <?= in_array(4, session()->get('completed_rooms') ?? []) ? 'completed' : '' ?>"
               data-piece="Salle 4" data-numero="4">
                <image class="piece-image" width="423" height="209" x="1073" y="320" rx="8" ry="8"
                       clip-path="url(#clip_salle_4)" preserveAspectRatio="xMidYMid slice"
                       xlink:href="<?= base_url('images/salles/salle_4.webp') ?>"/>
                <image class="piece-label" width="300" height="100" x="0" y="0"
                       xlink:href="<?= base_url('images/etiquettes/etiq_salle_4.svg') ?>"/>
                <rect class="piece-zone"
                <rect width="423" height="209" x="1073" y="320" rx="8" ry="8"/>
                />
            </g>

            <!-- Salle 5 -->
            <g id="salle_5" class="piece <?= in_array(5, session()->get('completed_rooms') ?? []) ? 'completed' : '' ?>"
               data-piece="Salle 5" data-numero="5">
                <image class="piece-image" width="426" height="209" x="410" y="320" rx="8" ry="8"
                       clip-path="url(#clip_salle_5)" preserveAspectRatio="xMidYMid slice"
                       xlink:href="<?= base_url('images/salles/salle_5.webp') ?>"/>
                <image class="piece-label" width="300" height="100" x="0" y="0"
                       xlink:href="<?= base_url('images/etiquettes/etiq_salle_5.svg') ?>"/>
                <rect class="piece-zone" width="426" height="209" x="410" y="320" rx="8" ry="8"/>
            </g>

            <!-- Salle 6 -->
            <g id="salle_6" class="piece <?= in_array(6, session()->get('completed_rooms') ?? []) ? 'completed' : '' ?>"
               data-piece="Salle 6" data-numero="6">
                <image class="piece-image" x="388" y="77" width="1132" height="220"
                       clip-path="url(#clip_salle_6)" preserveAspectRatio="xMidYMid slice"
                       xlink:href="<?= base_url('images/salles/salle_6.webp') ?>"/>
                <image class="piece-label" width="300" height="100" x="0" y="0"
                       xlink:href="<?= base_url('images/etiquettes/etiq_salle_6.svg') ?>"/>
                <path class="piece-zone"
                      d="M 387,300 577,105 1324,76 1516,299 Z"/>
            </g>

            <!-- Escalier étage 2 -->
            <g id="escalier_etage2" class="escalier <?= $etage2_actif ? 'clair' : '' ?>">
                <image class="escalier-sombre"
                       width="219" height="228" x="844" y="319"
                       xlink:href="<?= base_url('images/escaliers/escalier_3_sombre.webp') ?>"/>
                <image class="escalier-clair"
                       width="219" height="228" x="844" y="319"
                       xlink:href="<?= base_url('images/escaliers/escalier_3_clair.webp') ?>"/>
            </g>
            <!-- Escalier étage 1 -->
            <g id="escalier_etage1" class="escalier <?= $etage1_actif ? 'clair' : '' ?>">
                <image class="escalier-sombre"
                       width="219" height="205" x="843" y="544"
                       xlink:href="<?= base_url('images/escaliers/escalier_2_sombre.webp') ?>"/>
                <image class="escalier-clair"
                       width="219" height="205" x="843" y="544"
                       xlink:href="<?= base_url('images/escaliers/escalier_2_clair.webp') ?>"/>
            </g>
            <!-- Escalier étage 0 -->
            <g id="escalier_etage0" class="escalier <?= $etage0_actif ? 'clair' : '' ?>">
                <image class="escalier-sombre"
                       width="239" height="223" x="1264" y="749"
                       xlink:href="<?= base_url('images/escaliers/escalier_1_sombre.webp') ?>"/>
                <image class="escalier-clair"
                       width="239" height="223" x="1264" y="749"
                       xlink:href="<?= base_url('images/escaliers/escalier_1_clair.webp') ?>"/>
            </g>

            <!-- Espace Lumi -->
            <g id="lumi" class="zone-lumi" data-piece="Lumi">
                <!-- Halo de lumière (en dessous) -->
                <ellipse class="lumi-halo" cx="130" cy="114" rx="70" ry="60"
                         fill="url(#halo-gradient)" filter="url(#halo-lumi)" opacity="0.7">
                    <animate attributeName="opacity" values="0.4;0.7;0.4"
                             dur="3s" repeatCount="indefinite"/>
                </ellipse>
                <image class="lumi-image default" width="130" height="150"
                       x="<?= 138 - 70 ?>" y="<?= 114 - 35 ?>"
                       clip-path="url(#clip_lumi)" preserveAspectRatio="xMidYMid slice"
                       xlink:href="<?= base_url('images/lumi/masc_base.webp') ?>"/>
                <image class="lumi-image hover" width="130" height="150"
                       x="<?= 138 - 70 ?>" y="<?= 114 - 35 ?>"
                       clip-path="url(#clip_lumi)" preserveAspectRatio="xMidYMid slice"
                       xlink:href="<?= base_url('images/lumi/masc_base_2.webp') ?>"/>
                <ellipse class="lumi-zone" cx="138" cy="114" rx="150" ry="150"/>
            </g>

            <!-- Zone Lune/Soleil -->
            <g id="lune_soleil" class="zone-lune" data-piece="LuneSoleil">
                <ellipse class="lune-zone" cx="1696" cy="130" rx="130" ry="118"/>
            </g>
        </svg>
        <!-- tooltip HTML -> positionné avec CSS -->
        <div id="html-tooltip" style="position:fixed;
        display:none; padding:6px 10px; background:rgb(249,236,46);
        color:#0b0a0a; border-radius:6px; font-size:18px;
        pointer-events:none; z-index:9999;">
            Passer en mode Jour
        </div>
    </div>

</div>
<!-- Modal Lumi -->
<div class="modal fade" id="modalLumi" tabindex="-1" aria-labelledby="modalLumiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalLumiLabel">Lumi – C'est quoi l'idée ?</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="<?= base_url('images/commun/mascotte/mascotte_interrogee.svg') ?>" alt="Lumi" class="img-fluid rounded mb-3">
                <div class="modal-texte">
                    <p>Bienvenue agent ! Vous venez d'intégrer la B.L.U.T., la Brigade un peu spéciale chargée de sécuriser
                        l'univers numérique. Votre mission : traverser les 6 salles du CyberManor pour prouver que vous êtes
                        prêt à rejoindre nos rangs...</p>
                    <p>La zone <strong>Lumi</strong> c'est .....</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Victoire -->
<div id="victoryOverlay" class="victory-overlay hidden" onclick="hideVictoryModal()">
    <div class="victory-modal" onclick="event.stopPropagation()">
        <!-- Image à gauche -->
        <div class="victory-image">
            <img class="victory-image"
                 src="<?= base_url('images/lumi/mascotte-05.svg'); ?>"
                 alt="">
        </div>

        <!-- Contenu à droite -->
        <div class="victory-content">
            <h2 class="victory-title">Victoire !</h2>
            <p class="victory-text">Félicitations ! Vous avez réussi toutes les salles !</p>

            <!-- Bouton avec image d'étiquette -->
            <button class="victory-button" onclick="handleVictoryButton()">
                <img class="victory-button-bg"
                     src="<?= base_url('images/lumi/bouton_termine.svg'); ?>"
                     alt="">
            </button>
        </div>
    </div>
</div>

<!-- Variables PHP transmises au JS -->
<script>
    const baseUrl = <?= json_encode(base_url()) ?>;
    const currentRoom = <?= json_encode(session()->get('current_room') ?? -1) ?>;
    const completedRooms = <?= json_encode(session()->get('completed_rooms') ?? []) ?>;
</script>

<!-- Chargement du script JS -->
<script src="<?= base_url('js/manoir_nuit.js') ?>"></script>

<!-- Appel de la modal de victoire -> obligatoirement APRÈS le chargement du JS -->
<?php if (count($completed_rooms) >= 6): ?>
    <script>
        // On attend que le DOM soit prêt ET que le script soit chargé
        if (typeof showVictoryModal === 'function') {
            showVictoryModal();
        } else {
            window.addEventListener('load', function () {
                showVictoryModal();
            });
        }
    </script>
<?php endif; ?>

</body>
</html>