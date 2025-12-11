<?= (str_contains($enigme->image, 'compil')) ? link_tag('styles/salle_5/enigmeSalle.css') : link_tag('styles/salle_5/enigme.css') ?>
<title><?= esc($enigme->libelle) ?></title>
</head>
<body data-baseurl="<?= base_url() ?>">
<div class="scene-enigme">

    <!-- Question -->
    <div class="question-box">
        <h2 class="question-titre">
            <?php if ($mode_emploi): ?>
                <?= esc($mode_emploi->explication_2) ?>
            <?php endif; ?>
        </h2>
    </div>

    <!-- Fond de bureau avec SVG -->
    <div class="bureau-wrapper">
        <!-- Created with Inkscape (http://www.inkscape.org/) -->
        <svg width="<?= $enigme->width_img ?>" height="<?= $enigme->height_img ?>" version="1.1" viewBox="0 0 <?= $enigme->width_img . ' ' .$enigme->height_img ?> " xmlns="http://www.w3.org/2000/svg">
            <image
                xlink:href="<?= //récupérer le fond en fonction de l'énigme$
                $enigme->image ?>"
                x="0"
                y="0"
                width="<?= $enigme->width_img ?>" height="<?= $enigme->height_img ?>"
                id="image-fond"
                style="pointer-events: none;"/>

            //faire une table objet et une inter objet enigme avec tout objet liés aux enigmes
            // recreer model, modif controller et view pour afficher les objets apres avoir fait la table objet_activité



























            <g id="infobulle" class="infobulle" style="display:none">
                <image id="indice"
                       preserveAspectRatio="none"
                       x="1100.2" y="680.12" width="341.71" height="248.52"
                       xlink:href="<?= base_url('images/salle_6/bulle-salle-6.svg') ?>" />
                <!-- Bloc texte dans la bulle -->
                <foreignObject x="1100.2" y="775.12" width="300" height="200">
                    <div class="texte-indice" xmlns="http://www.w3.org/1999/xhtml"
                         style="font-size:22px; font-weight:600; text-align:center;">
                        <?= $indice->libelle ?>
                    </div>
                </foreignObject>
            </g>

            <g id="lumi" class="zone-lumi" data-piece="Lumi">
                <image class="lumi-image default"
                       preserveAspectRatio="xMidYMid slice"
                       x="1400.9" y="725.97" width="205" height="252"
                       xlink:href="<?= base_url('images/commun/mascotte/mascotte_face.svg') ?>" />
                <image class="lumi-image hover"
                       preserveAspectRatio="xMidYMid slice"
                       x="1400.9" y="725.97" width="205" height="252"
                       xlink:href="<?= base_url('images/commun/mascotte/mascotte_interrogee.svg') ?>" />
                <rect class="lumi-zone" x="1400.9" y="725.97" width="205" height="252" pointer-events="all"/>
            </g>
        </svg>
    </div>

    <!-- Feedback -->
    <div class="feedback" id="feedback"></div>
</div>

<div id="transition-overlay"></div>

<script>
    const activite_numero = <?= $enigme->numero ?>;
    const base_url = '<?= base_url() ?>';
</script>
<?= script_tag('js/salle_5/mascotte.js') ?>
<?= script_tag('js/salle_5/enigme.js') ?>