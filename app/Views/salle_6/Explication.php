<title>Explication</title>
</head>
<body>

<?= link_tag(base_url() . "styles/salle_6/explication.css") ?>
<div class="container-explication">

<!-- Created with Inkscape (http://www.inkscape.org/) -->
<svg width="1920" height="1080" version="1.1" viewBox="0 0 1920 1080" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <!-- IMAGE DE FOND -->
    <image
            xlink:href="<?= base_url('images/salle_6/explication-salle-6.svg') ?>"
            x="0"
            y="0"
            width="1920" height="1080"
            id="image-fond"
            style="pointer-events: none;"/> <!-- Important : pas d'interaction sur l'image -->

    <!-- Zone de texte -->
    <rect id="zone-texte" x="180.05" y="204.18" width="1195.4" height="416.29" fill-opacity="0" />

    <foreignObject x="180.05" y="204.18" width="1195.4" height="416.29">
        <div xmlns="http://www.w3.org/1999/xhtml" style="
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
            font-family: Arial, sans-serif;
        ">
            <h2 style="color: #2ecc71; font-size: 3rem; margin-bottom: 1rem;"> <?= $intituleMessage ?> </h2>
            <p style="color: #333; font-size: 1.5rem; margin-bottom: 1rem;">
                <?= isset($messageResultat) ? esc($messageResultat) : 'Test' ?>
            </p>
            <p style="color: #333; font-size: 1.5rem;">
                <?= isset($explication) ? esc($explication) : 'Test' ?>
            </p>
        </div>
    </foreignObject>

    <!-- Bouton -->
    <path id="btn-valider"
          d="m555.91 722.49 -11.436 -73.591 h540 l11.436 74.586 z"
          fill-opacity="0"
          style="cursor:pointer;"
          onclick="window.location.href='<?= base_url('/Salle6/Quitter') ?>'" />

    <!-- Texte dans le bouton -->
    <text x="825" y="690"
          font-size="40"
          text-anchor="middle"
          dominant-baseline="middle"
          style="pointer-events:none;">
        <?= $texteBtnValider ?>
    </text>

    <!-- Mascotte -->
    <image id="mascotte"
           x="1520.1" y="622.86"
           width="319.68" height="430.2"
           preserveAspectRatio="none"
           xlink:href="<?= $urlImgMascotte ?>" />

</svg>
</div>
<?= script_tag('js/salle_6/explication.js') ?>

