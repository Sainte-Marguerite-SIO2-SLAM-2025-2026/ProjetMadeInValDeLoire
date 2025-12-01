<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan du Manoir</title>
    <?= link_tag('css/bootstrap.min.css') ?>
    <?= link_tag('styles/style_jour.css'); ?>
    <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>"></script>


</head>
<body>
<div class="plan-container">
    <div class="svg-wrapper">
        <svg width="1920" height="1080" viewBox="0 0 1920 1080" xmlns="http://www.w3.org/2000/svg">
            <!-- Définition des clipPaths -->
            <defs>
                <clipPath id="clip_salle_1">
                    <rect x="403" width="853" height="205" y="759"/>
                </clipPath>
                <clipPath id="clip_salle_2">
                    <rect x="1073" y="538" height="206" width="423"/>
                </clipPath>
                <clipPath id="clip_salle_3">
                    <rect x="403" y="540" width="424" height="204"/>
                </clipPath>
                <clipPath id="clip_salle_4">
                    <rect x="1073" y="316" height="208" width="423"/>
                </clipPath>
                <clipPath id="clip_salle_5">
                    <rect x="404" y= "311"
                          width= "424" height= "215"/>
                </clipPath>
                <clipPath id="clip_salle_6">
                    <path d="M 375,296 570,104 1328,74 1520,296 Z"/>
                </clipPath>
                <clipPath id="clip_lune_soleil">
                    <path d="m 1899,1 h -291 c 0,0 3,75 15,108 13,33 32,64 58,87 27,23 61,37 95,45 34,8 84,3 104,0 20,-3 18,-6 18,-6 z"/>
                </clipPath>
                <clipPath id="clip_lumi">
                    <ellipse cx="138" cy="114" rx="150" ry="150"/>
                </clipPath>
                <clipPath id="clip_quizz">
                    <path d="m 1854,1004 h -110 c 0,0 0,-18 3,-26 2,-8 6,-17 11,-23 5,-6 12,-10 17,-15
                    5,-4 13,-8 18,-13 4,-4 7,-4 11,-9 3,-4 5,-14 7,-18 2,-4 3,-7 3,-7 h 2 c 0,0 1,5 2,9
                    1,3 1,8 2,12 1,4 2,8 4,13 2,4 4,8 6,13 2,4 5,6 8,10 3,4 6,8 8,12 2,4 2,6 4,12 1,5 4,12
                    4,18 0,5 -2,15 -2,15 z"
                    />
                </clipPath>
            </defs>

            <!-- IMAGE DE FOND (externe) -->
            <image
                    xlink:href="<?= base_url('images/manoir/home_allume_leger_3.webp') ?>"
                    x="0"
                    y="0"
                    width="1920" height="1080"
                    id="image-fond"
                    style="pointer-events: none;"/> <!-- Important : pas d'interaction sur l'image -->

            <!-- Salle 1 -->
            <g id="salle_1"
               class="piece
                   <?= in_array(1, session()->get('completed_rooms') ?? []) ? 'completed' : '' ?>
                    <?= in_array(1, session()->get('failed_rooms') ?? []) ? 'failed' : '' ?>"
               data-piece="Salle 1" data-numero="1">
                <image class="piece-label" width="300" height="100" x="0" y="0"
                       xlink:href="<?= base_url('images/etiquettes/etiq_salle_1.svg') ?>"/>
                <rect class="piece-zone" x="403" width="853" height="205" y="759" rx="5" ry="5"/>
            </g>

            <!-- Salle 2 -->
            <g id="salle_2"
               class="piece
                   <?= in_array(2, session()->get('completed_rooms') ?? []) ? 'completed' : '' ?>
                    <?= in_array(2, session()->get('failed_rooms') ?? []) ? 'failed' : '' ?>"
               data-piece="Salle 2" data-numero="2">
                <image class="piece-label" width="300" height="100" x="0" y="0"
                       xlink:href="<?= base_url('images/etiquettes/etiq_salle_2.svg') ?>"/>
                <rect class="piece-zone" x="1073" y="538" height="206" width="423" rx="5" ry="5"/>
            </g>

            <!-- Salle 3 -->
            <g id="salle_3"
               class="piece
                   <?= in_array(3, session()->get('completed_rooms') ?? []) ? 'completed' : '' ?>
                    <?= in_array(3, session()->get('failed_rooms') ?? []) ? 'failed' : '' ?>"
               data-piece="Salle 3" data-numero="3">
                <image class="piece-label" width="300" height="100" x="0" y="0"
                       xlink:href="<?= base_url('images/etiquettes/etiq_salle_3.svg') ?>"/>
                <rect class="piece-zone" x="403" y="540" width="424" height="204" rx="5" ry="5"/>
            </g>

            <!-- Salle 4 -->
            <g id="salle_4"
               class="piece
                   <?= in_array(4, session()->get('completed_rooms') ?? []) ? 'completed' : '' ?>
                    <?= in_array(4, session()->get('failed_rooms') ?? []) ? 'failed' : '' ?>"
               data-piece="Salle 4" data-numero="4">
                <image class="piece-label" width="300" height="100" x="0" y="0"
                       xlink:href="<?= base_url('images/etiquettes/etiq_salle_4.svg') ?>"/>
                <rect class="piece-zone" x="1073" y="316" height="208" width="423" rx="5" ry="5"/>
            </g>

            <!-- Salle 5 -->
            <g id="salle_5"
               class="piece
                   <?= in_array(5, session()->get('completed_rooms') ?? []) ? 'completed' : '' ?>
                    <?= in_array(5, session()->get('failed_rooms') ?? []) ? 'failed' : '' ?>"
               data-piece="Salle 5" data-numero="5">
                <image class="piece-label" width="300" height="100" x="0" y="0"
                       xlink:href="<?= base_url('images/etiquettes/etiq_salle_5.svg') ?>"/>
                <rect class="piece-zone" x="404" y= "311"
                      width= "424" height= "215" rx="5" ry="5"/>
            </g>

            <!-- Salle 6 -->
            <g id="salle_6"
               class="piece
                   <?= in_array(6, session()->get('completed_rooms') ?? []) ? 'completed' : '' ?>
                    <?= in_array(6, session()->get('failed_rooms') ?? []) ? 'failed' : '' ?>"
               data-piece="Salle 6" data-numero="6">
                <image class="piece-label" width="300" height="100" x="0" y="0"
                       xlink:href="<?= base_url('images/etiquettes/etiq_salle_6.svg') ?>"/>
                <path class="piece-zone" d="M 375,296 570,104 1328,74 1520,296 Z"/>
            </g>

            <!-- Espace Lumi -->
            <g id="lumi" class="zone-lumi" data-piece="Lumi">
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
                <path class="lune-zone" d="m 1610,1 c 0,0 2,76 14,109
                      12,33 31,62 57,86 26,23 62,41 96,49 35,8
                       85,8 105,3 19,-4 46,-11 46,-11 V 2 Z"/>
            </g>

            <!-- Zone Quiz -->
            <g id="quizz" class="zone-quizz" data-piece="Quizz">
                <path class="quizz-zone" fill="#351900"
                      d="m 1856,1003 h -110 c 0,0 0,-18 3,-26 2,-8 6,-17 11,-23 5,-6 12,-10 17,-15
                    5,-4 13,-8 18,-13 4,-4 7,-4 11,-9 3,-4 5,-14 7,-18 2,-4 3,-7 3,-7 h 2 c 0,0 1,5 2,9
                    1,3 1,8 2,12 1,4 2,8 4,13 2,4 4,8 6,13 2,4 5,6 8,10 3,4 6,8 8,12 2,4 2,6 4,12 1,5 4,12
                    4,18 0,5 -2,15 -2,15 z"
                />
            </g>

        </svg>

        <!-- tooltip HTML -> positionné par CSS -->
        <div id="html-tooltip" style="position:fixed;
        display:none; padding:6px 10px;
        background:rgb(31,48,56);
        color:#fff; border-radius:6px; font-size:18px;
        pointer-events:none; z-index:9999;">
            Passer en mode Nuit
        </div>
    </div>
</div>
<!-- Modal Lumi -->
<div class="modal fade" id="modalLumi" tabindex="-1" aria-labelledby="modalLumiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalLumiLabel">Lumi – C'est quoi l'idée ?</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="<?= base_url('images/commun/mascotte/mascotte_interrogee.webp') ?>"
                     alt="Lumi" class="img-fluid rounded mb-3">
                <p>Bienvenue à <strong>Enig’Manoir</strong></p>

                <p>
                    Ici, chaque salle est un défi… et chaque défi est lié à un piège de cybersécurité.<br>
                    Esprit du lieu : jouer, réfléchir… et survivre aux dangers du web.
                </p>
                <p>
                    ☀️ <strong>Mode Jour — Exploration Libre</strong><br>
                    • Choisissez vos salles, dans l’ordre que vous voulez<br>
                    • Rejouez vos favorites ou entraînez-vous<br>
                </p>
                <p>
                    👁️  Et surtout… gardez l’œil ouvert :<br>
                    <strong>un espace mystère</strong> se cache quelque part dans le manoir… mais seulement ici.
                </p>
                <p>
                    🌙 <strong>Mode Nuit — Parcours Escape Game</strong><br>
                    Un vrai parcours, version cyber :<br>
                    • Les salles s’enchaînent dans un ordre aléatoire<br>
                    • Chaque pièce a son ambiance, son esprit et son propre piège numérique<br>
                    • Pour valider le parcours : réussissez toutes les salles<br>
                    • Échec dans une salle ? Tant pis… on recommence tout ! 😉
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>


<!-- Variables PHP transmises au JS -->
<script>
    const baseUrl = <?= json_encode(base_url()) ?>;
    const currentRoom = <?= json_encode(session()->get('current_room') ?? -1) ?>;
    const completedRooms = <?= json_encode(session()->get('completed_rooms') ?? []) ?>;
    const failedRooms = <?= json_encode(session()->get('failed_rooms') ?? []) ?>;
</script>

<!-- Chargement du script JS -->
<script src="<?= base_url('js/manoir_jour.js') ?>"></script>

