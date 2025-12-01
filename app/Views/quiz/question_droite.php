<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= link_tag('css/style_quiz_droite.css') ?>
    <title><?= esc($title) ?></title>
</head>
<body>
<div class="quiz-container">
    <div class="quiz-wrapper">
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
                <!-- Le clipPath pour le retour-->
                <clipPath id="clip-retour">
                    <ellipse cx="0" cy="0" rx="60" ry="52"/>
                </clipPath>
            </defs>

            <!-- IMAGE DE FOND (externe) -->
            <image
                    xlink:href="<?= base_url('images/quiz/ecran-question-pixel.svg') ?>"
                    x="0"
                    y="0"
                    width="1920"
                    height="1080"
                    id="image-fond"
                    style="pointer-events: none;"/> <!-- Important : pas d'interaction sur l'image -->

            <!-- Modal pour Score du Quiz -->
            <?php if (isset($show_results) && $show_results): ?>
                <div id="scoreOverlay" class="score-overlay" onclick="hideScoreModal()">
                    <div class="score-modal" onclick="event.stopPropagation()">
                        <!-- Image à gauche -->
                        <div class="score-image">
                            <?php if ($pourcentage >= 70): ?>
                                <img src="<?= base_url('images/lumi/mascotte-05.svg'); ?>" width="170" height="190"
                                     alt="">
                            <?php else: ?>
                                <img src="<?= base_url('images/lumi/mascotte-06.svg'); ?>" width="170" height="190"
                                     alt="">
                            <?php endif; ?>
                        </div>

                        <!-- Contenu à droite -->
                        <div class="score-content">
                            <h2 class="score-title">Quiz Terminé !</h2>

                            <div class="score-display"><?= $score ?> / <?= $total ?></div>
                            <div class="score-percentage"><?= $pourcentage ?>%</div>

                            <p class="score-message">
                                <?php if ($pourcentage >= 90) echo " Excellent ! Vous êtes un expert !";
                                elseif ($pourcentage >= 70) echo "Très bien ! Bon travail !";
                                elseif ($pourcentage >= 50) echo " Pas mal ! Continuez à vous entraîner !";
                                else echo " Ne vous découragez pas ! Réessayez !"; ?>
                            </p>

                            <!-- Bouton avec image d'étiquette -->
                            <button class="score-button" onclick="handleScoreButton()">
                                <img class="score-button-bg"
                                     src="<?= base_url('images/lumi/bouton_retour_manoir.svg'); ?>"
                                     alt="">
                            </button>
                        </div>
                    </div>
                </div>
                <script>
                    // Afficher la modale score
                    function showScoreModal() {
                        document.getElementById('scoreOverlay').classList.remove('hidden');
                    }

                    // Masquer la modale score
                    function hideScoreModal() {
                        document.getElementById('scoreOverlay').classList.add('hidden');
                    }

                    // Action du bouton
                    function handleScoreButton() {
                        // Votre action : redirection, recommencer, etc.
                        window.location.href = '<?= base_url("/manoirJour") ?>';
                    }
                </script>
            <?php else: ?>
            <rect id="ecran_question" x="490" y="100" width="850" height="510"
                  fill="transparent" stroke="none"></rect>
            <!-- foreignObject placé aux coordonnées de ecran_question -->
            <foreignObject id="formulaire-quiz"
                           x="490" y="100" width="850" height="510">
                <div xmlns="http://www.w3.org/1999/xhtml" class="formulaire policeTexte">
                    <form id="quiz-form" class="quiz-form" action="<?= base_url('quiz/repondre/droite') ?>"
                          method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="proposition" id="propositionInput">

                        <div class="question">
                            <?= esc($question['libelle']) ?>
                        </div>

                        <ul class="choices">
                            <?php foreach ($question['propositions'] as $i => $prop):
                                $letter = chr(65 + $i); ?>
                                <li class="choice" data-id="<?= $prop['numero'] ?>">
                                    <span class="letter"><?= $letter ?></span>
                                    <span class="text"><?= esc($prop['libelle']) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </form>
                </div>
            </foreignObject>
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

                <!-- Le clipPath  Retour -->
                <clipPath id="clip-retour">
                    <ellipse cx="0" cy="0" rx="60" ry="52"/>
                </clipPath>

            </defs>
            <!-- Zone retour   62,5 = 125/2  -->
            <g id="retour" class="zone-retour" data-piece="Retour" transform="translate(150, 148)">
                <!-- Image de base -->
                <image id="retour-image"
                       href="<?= base_url('images/quiz/home_icone_9.webp') ?>"
                       x="-62.5" y="-55"
                       width="125" height="110"
                       clip-path="url(#clip-retour)"
                       preserveAspectRatio="xMidYMid slice"/>

                <!-- Image au survol -->
                <image id="retour-image-hover"
                       href="<?= base_url('images/quiz/home_icone_9_hover.webp') ?>"
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
                        fill="transparent"
                        stroke="#e1c7f2"
                        stroke-width="8"
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

            <!-- Barre progression (contour) -->
            <rect id="barre_progression"
                  x="560" y="655"
                  width="700" height="63"
                  fill="none" stroke="#855e03" stroke-width="4"
                  opacity="0.7"
            />

            <!-- Remplissage de la barre -->
            <rect id="progressFill"
                  x="562" y="655"
                  width="0" height="63"
                  fill="url(#progressGradient)" rx="8" ry="8"/>

            <!-- Dégradé -->
            <defs>
                <linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#ffff33"/>
                    <stop offset="100%" stop-color="#33ffff"/>
                </linearGradient>
            </defs>
            <?php endif; ?>
        </svg>
        <!-- tooltip HTML -> positionné avec CSS -->
        <div id="html-tooltip" style="position:fixed;
        display:none; padding:6px 10px; background:rgb(204,255,255);
        color:#0b0a0a; border-radius:6px; font-size:18px;
        pointer-events:none; z-index:9999;">
            Non, pas d’aide : c’est la zone facile.<br>
            à toi d’en trouver l’issue ..
        </div>
        <div id="warningChoix" class="warning_choix">
            🌟️ Tu dois choisir quelque chose…   🌟
        </div>
    </div>
</div>
<!-- Variables PHP transmises au JS -->
<script>
    const baseUrl = <?= json_encode(base_url()) ?>;
    const progressionNiveau = <?= $progression ?>;
</script>
<!-- Chargement du script JS -->
<script src="<?= base_url('js/quiz_question_droite.js') ?>"></script>

