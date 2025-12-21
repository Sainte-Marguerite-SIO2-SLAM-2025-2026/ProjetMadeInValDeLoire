<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <?= link_tag('css/style_quiz_droite.css') ?>
    <title>Un Quiz Facile</title>
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
                    <path d="m 673,907 33,-64 443,-2 24,70 -5,19 -492,2 z"/>
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
                    xlink:href="<?= base_url('images/quiz/ecran-choix-pixel.svg') ?>"
                    x="0"
                    y="0"
                    width="1920"
                    height="1080"
                    id="image-fond"
                    style="pointer-events: none;"/> <!-- Important : pas d'interaction sur l'image -->

            <!-- Zone retour   62,5 = 125/2  -->
            <g id="retour" class="zone-retour" data-piece="Retour" transform="translate(150, 148)">
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
                        d="m 673,907 33,-64 443,-2 24,70 -5,19 -492,2 z"
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

            <rect id="ecran-choix" x="640" y="360" width="630" height="353"
                  fill="transparent"/>

            <!-- === FORMULAIRE intégré dans miroir -->
            <foreignObject id="formulaire-quiz"
                           x="640" y="360" width="630" height="353">
                <div xmlns="http://www.w3.org/1999/xhtml"
                     class="formulaire policeTexte">
                    <h2>Espace Paramétrage </h2>
                    <?php if (session()->has('error')): ?>
                        <div class="alert">
                            <?= session('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('quiz/demarrer/droite') ?>" method="post" class="quiz-form">
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
                                <div class="radio-option">
                                    <input type="radio" name="nb_questions" id="q20" value="20">
                                    <label for="q20" class="radio-label">20</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group erase">
                            <label>Quel niveau de difficulté ?</label>
                            <div class="radio-group">
                                <div class="radio-option">
                                    <input type="radio" name="niveau_difficulte" id="facile" value="F" checked>
                                    <label for="facile" class="radio-label">Facile</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" name="niveau_difficulte" id="moyen" value="M">
                                    <label for="moyen" class="radio-label">Moyen</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </foreignObject>
        </svg>
        <!-- tooltip HTML -> positionné avec CSS -->
        <div id="html-tooltip">
            C’est la zone la plus facile.
            </br>Alors, prêt à tenter le coup ?
            </br>Pour valider, clic sur le clavier.
        </div>
    </div>
</div>
<!-- Variables PHP transmises au JS -->
<script>
    const baseUrl = <?= json_encode(base_url()) ?>;
</script>
<!-- Chargement du script JS -->
<script src="<?= base_url('js/quiz_choix_droite.js') ?>"></script>


