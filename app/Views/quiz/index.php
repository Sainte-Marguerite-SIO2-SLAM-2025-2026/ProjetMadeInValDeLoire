<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= link_tag('css/style_quiz_index.css') ?>
    <title>Salle Mystère du Manoir Enig'Manoir</title>
</head>
<body>
<?php
if (session()->get('mode') === 'nuit') :
$texte = "étape finale, choissisez le bon côté !!";
elseif (session()->get('mode') === 'jour') :
    $texte = "Un pas à gauche ? \nUn pas à droite ? \n\n\nLe manoir jugera.";
endif;?>

<div class="quiz-container">
    <div class="svg-wrapper">
        <svg viewBox="0 0 1920 1080"
             preserveAspectRatio="xMidYMid slice"
             xmlns="http://www.w3.org/2000/svg"
             xmlns:xlink="http://www.w3.org/1999/xlink">

            <!-- Clip-path -->
            <defs>
                <clipPath id="clip-retour">
                    <ellipse cx="150" cy="150" rx="63" ry="57" />
                </clipPath>
                <clipPath id="clip-page-gauche">
                    <ellipse cx="430" cy="600"
                             rx="175" ry="370" />
                </clipPath>
                <clipPath id="clip-page-droite">
                    <ellipse cx="1520" cy="640"
                             rx="160" ry="420" />
                </clipPath>
                <clipPath id="clip-ecran">
                    <rect  width="352" height="229"
                           x="779" y="288"
                           ry="1" />
                </clipPath>
            </defs>

            <!-- IMAGE DE FOND (externe) -->
            <image
                    xlink:href="<?= base_url('images/quiz/ecran-entree-quiz.svg') ?>"
                    x="0"
                    y="0"
                    width="1920"
                    height="1080"
                    id="image-fond"
                    style="pointer-events: none;"/> <!-- Important : pas d'interaction sur l'image -->

            <!-- BOUTON RETOUR -->
            <g id="retour" class="zone-retour" data-piece="Retour">
                <image
                        xlink:href="<?= base_url('images/quiz/home_icone_2.webp') ?>"
                        x="<?= 150 - 63 ?>" y="<?= 150 - 57 ?>"
                        width="120" height="110"
                        clip-path="url(#clip-retour)"
                        preserveAspectRatio="xMidYMid slice"
                />
                    <ellipse class="retour-zone" cx="150" cy="150" rx="63" ry="57" />
            </g>

            <!-- PORTE GAUCHE -->
            <g id="porte-gauche" class="zone-porte" data-piece="PorteGauche">
                <ellipse
                        class="porte-gauche-zone"
                        cx="430" cy="600"
                        rx="175" ry="370"
                />
            </g>

            <!-- PORTE DROITE -->
            <g id="porte-droite" class="zone-porte" data-piece="PorteDroite">
                <ellipse
                        class="porte-droite-zone"
                        cx="1470" cy="600"
                        rx="140" ry="370"
                />
            </g>

            <g id="ecran" class="zone-ecran" data-piece="Ecran">
                <rect class="ecran-zone"
                      width="350" height="225" x="790" y="305" ry="1"
                      clip-path="url(#clip_ecran)"></rect>
                <!-- Zone de texte avec texte "personnalisable" -->
                <foreignObject x="790" y="305" width="350" height="225"
                               clip-path="url(#clip_ecran)">
                    <div xmlns="http://www.w3.org/1999/xhtml"
                         class="policeTexte" >
                        <?php echo nl2br(htmlspecialchars($texte)); ?>
                    </div>
                </foreignObject>
            </g>
        </svg>
    </div>
</div>
<!-- Variables PHP transmises au JS -->
<script>
    const baseUrl = <?= json_encode(base_url()) ?>;
</script>
<!-- Chargement du script JS -->
<script src="<?= base_url('js/index_quiz.js') ?>"></script>


