<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <?= link_tag('css/style_quiz_nuit.css') ?>
    <title>Salle Mystère</title>
</head>
<body>

<div class="quiz-container">
    <div class="svg-wrapper">
        <!-- === Le SVG === -->
        <svg
                viewBox="0 0 1920 1080"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:svg="http://www.w3.org/2000/svg"
                preserveAspectRatio="xMidYMid slice">

            <defs>
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
                    <stop offset="0%" style="stop-color:#cdcdc9;stop-opacity:0.8"/>
                    <stop offset="50%" style="stop-color:#c5c3c1;stop-opacity:0.4"/>
                    <stop offset="100%" style="stop-color:#edece5;stop-opacity:0"/>
                </radialGradient>
                <!-- Le clipPath pour le retour-->
                <clipPath id="clip-retour">
                    <ellipse cx="0" cy="0" rx="60" ry="52"/>
                </clipPath>
            </defs>

            <!-- IMAGE DE FOND (externe) -->
            <image
                    xlink:href="<?= base_url('images/quiz/ecran-choix-nuit.svg') ?>"
                    x="0"
                    y="0"
                    width="1920"
                    height="1080"
                    id="image-fond"
                    style="pointer-events: none;"/> <!-- Important : pas d'interaction sur l'image -->

            <!-- Zone retour   62,5 = 125/2  -->
            <g id="retour" class="zone-retour" data-piece="Retour" transform="translate(150, 148)">
                <!-- Image centrée -->
                <image href="<?= base_url('images/quiz/home_icone_11.webp') ?>"
                       x="-62.5" y="-55"
                       width="125" height="110"
                       clip-path="url(#clip-retour)"
                       preserveAspectRatio="xMidYMid slice"/>
                <!-- Zone de clic -->
                <ellipse class="retour-zone"
                         cx="0" cy="0"
                         rx="60" ry="52"
                         fill="transparent"/>
            </g>

            <!-- Zone lumi -->
            <g id="lumi" class="zone-lumi" data-piece="Lumi">
                <!-- Halo de lumière (en dessous) -->
                <!-- cx = 1390 + 130/2 = 1455 cy = 610 + 150/2 = 685  -->
                <ellipse class="lumi-halo"
                         cx="1455" cy="685"
                         rx="120" ry="170"
                         fill="url(#halo-gradient)" filter="url(#halo-lumi)" opacity="0.7">
                    <animate attributeName="opacity" values="0.4;0.7;0.4"
                             dur="3s" repeatCount="indefinite"/>
                </ellipse>
                <image class="lumi-image" width="130" height="150"
                       x="1390" y="610"
                       clip-path="url(#clip_lumi)" preserveAspectRatio="xMidYMid slice"
                       xlink:href="<?= base_url('images/lumi/masc_base.webp') ?>"/>
                <rect class="lumi-zone" width="140" height="160" x="1390" y="610"
                      ry="1"/>
            </g>

            <!-- Zone interactive du miroir -->
            <rect id="zone-miroir"
                  width="395" height="355"
                  x="760" y="197" ry="0.5"
                  fill="transparent"
                  style="cursor: pointer;"/>
        </svg>
        <!-- Point d'interrogation sur le miroir -->
        <div id="miroir-tooltip" class="miroir-zone">
            <div class="miroir-animation">
            ?
        </div>
        <div class="miroir-texte">
            Prêt pour la dernière étape...<br>
            Clic...clic....allez encore un clic...
        </div>
    </div>
    <!-- tooltip HTML -> positionné avec CSS -->
    <div id="html-tooltip">
        Dernière étape ....<br>
        Es-tu prêt pour la salle ultime ?<br><br>
        La réponse est derrière le miroir...
    </div>
</div>
</div>

<!-- Variables PHP transmises au JS -->
<script>
    const baseUrl = <?= json_encode(base_url()) ?>;

</script>
<!-- Chargement du script JS -->
<script src="<?= base_url('js/quiz_choix_nuit.js') ?>"></script>



