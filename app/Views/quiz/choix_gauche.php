<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <?= link_tag('css/style_quiz_gauche.css') ?>
     <title>Salle de Quiz</title>

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
                <!-- Filtre pour l'effet de halo lumineux -->
                <filter id="glow-clavier">
                    <feGaussianBlur stdDeviation="10" result="coloredBlur"/>
                    <feMerge>
                        <feMergeNode in="coloredBlur"/>
                        <feMergeNode in="coloredBlur"/>
                        <feMergeNode in="coloredBlur"/>
                        <feMergeNode in="SourceGraphic"/>
                    </feMerge>
                </filter>
                <!-- clip pour clavier  -->
                <clipPath id="clip_clavier">
                    <path   d="m 828,702 -1,-17 60,-110 -23,1 -7,-10 -7,23 h 11 v 10
                        l -20,2 14,-57 50,-1 1,-5 h 105 l 2,8 h 9 v 6 l 28,1 1,26
                        h -16 -8 l 64,106 v 22 z"
                    />
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
                    xlink:href="<?= base_url('images/quiz/ecran-choix-70.svg') ?>"
                    x="0"
                    y="0"
                    width="1920"
                    height="1080"
                    id="image-fond"
                    style="pointer-events: none;"/> <!-- Important : pas d'interaction sur l'image -->

            <!-- Zone retour   62,5 = 125/2  -->
            <g id="retour" class="zone-retour" data-piece="Retour" transform="translate(150, 100)">
                <!-- Image centrée -->
                <image href="<?= base_url('images/quiz/home_icone_9.webp') ?>"
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

            <!-- groupe clavier : copie floue derrière + tracé net devant -->
            <g id="clavier" class="zone-clavier" data-piece="Clavier">
                <path
                        class="clavier-zone"
                        d="m 828,702 -1,-17 60,-110 -23,1 -7,-10 -7,23 h 11 v 10
                        l -20,2 14,-57 50,-1 1,-5 h 105 l 2,8 h 9 v 6 l 28,1 1,26
                        h -16 -8 l 64,106 v 22 z"
                        filter="url(#glow-clavier)"
                        clip-path="url(#clip_clavier)">
                    <!-- Animation de pulsation -->
                    <animate
                            attributeName="stroke-width"
                            values="3;6;3"
                            dur="2s"
                            repeatCount="indefinite"
                    />
                    <animate
                            attributeName="stroke-opacity"
                            values="0.6;1;0.6"
                            dur="2s"
                            repeatCount="indefinite"
                    />
                </path>
            </g>
            <!-- Zone lumi -->
            <g id="lumi" class="zone-lumi" data-piece="Lumi">
                <!-- Halo de lumière (en dessous) -->
                <ellipse class="lumi-halo" cx="1790" cy="820" rx="120" ry="170"
                         fill="url(#halo-gradient)" filter="url(#halo-lumi)" opacity="0.7">
                    <animate attributeName="opacity" values="0.4;0.7;0.4"
                             dur="3s" repeatCount="indefinite"/>
                </ellipse>
                <image class="lumi-image" width="130" height="150"
                       x="1722" y="741"
                       clip-path="url(#clip_lumi)" preserveAspectRatio="xMidYMid slice"
                       xlink:href="<?= base_url('images/lumi/masc_base.webp') ?>"/>

                <rect class="lumi-zone" width="140" height="160" x="1722" y="741"
                      ry="1"/>
            </g>

            <path id="ecran-choix"
                  d="m 617,260 17,204 25,84 234,-5 v -9
                  h 108 v 11 l 232,4 c 0,0 17,-3 22,-8 3,-4 4,-15 4,-15
                  l 6,-276 c 0,0 -4,-10 -7,-14 -6,-6 -21,-12 -21,-12 l -582,1
                  c 0,0 -20,2 -27,8 -7,7 -10,27 -10,27 z"
                  fill="transparent"/>

            <!-- === FORMULAIRE intégré dans miroir -->
            <foreignObject id="formulaire-quiz"
                           x="640" y="230" width="630" height="325">
                <div xmlns="http://www.w3.org/1999/xhtml"
                     class="formulaire policeTexte">
                    <h2>Espace Paramétrage </h2>
                    <?php if (session()->has('error')): ?>
                        <div class="alert">
                            <?= session('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('quiz/demarrer/gauche') ?>" method="post" class="quiz-form">
                        <?= csrf_field() ?>
                        <input type="hidden" name="piece" value="Quizz"/>

                        <div class="form-group erase">
                            <label>Combien de questions ?</label>
                            <div class="radio-group">
                                <div class="radio-option">
                                    <input type="radio" name="nb_questions" id="q5" value="5" checked>
                                    <label for="q5" class="radio-label">5</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" name="nb_questions" id="q10" value="10">
                                    <label for="q10" class="radio-label">10</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" name="nb_questions" id="q15" value="15">
                                    <label for="q15" class="radio-label">15</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group erase">
                            <label>Quel niveau de difficulté ?</label>
                            <div class="radio-group">
                                <div class="radio-option">
                                    <input type="radio" name="niveau_difficulte" id="difficile" value="D" checked>
                                    <label for="difficile" class="radio-label">Difficile</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" name="niveau_difficulte" id="expert" value="E">
                                    <label for="expert" class="radio-label">Expert</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </foreignObject>
        </svg>
        <!-- tooltip HTML -> positionné avec CSS -->
        <div id="html-tooltip" >
            Ici, les choses se corsent… <br>sauras-tu l’emporter ? ..
            <br> Pour valider, clic sur la machine ..
        </div>
    </div>
</div>
<!-- Variables PHP transmises au JS -->
<script>
    const baseUrl = <?= json_encode(base_url()) ?>;
</script>
<!-- Chargement du script JS -->
<script src="<?= base_url('js/quiz_choix_gauche.js') ?>"></script>


