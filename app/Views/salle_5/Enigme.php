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

            <?php foreach ($objets_activite as $obj): ?>

                <g id="<?= $obj['nom'] ?>" class="objet-cliquable" data-reponse="<?= $obj['reponse'] ?>" >

                    <image
                            clip-path="url(#<?= $obj['nom'] ?>)"
                            <?php if(str_contains($enigme->image, 'compil')): ?>
                            preserveAspectRatio="none"  a stocker en base, si ya un rotate aussi
                            <?php endif; ?>
                            x="<?= $obj['x'] ?>"
                            y="<?= $obj['y'] ?>"
                            width="<?= $obj['width'] ?>"
                            height="<?= $obj['height'] ?>"
                            xlink:href="<?= base_url($obj['image']) ?>"
                    />

                    <?php if (!empty($obj['zone_path'])): ?>
                        <path class="zone-click"
                              d="<?= $obj['zone_path'] ?>"
                              fill="none"
                              pointer-events="all"    a stocker en base
                              style="cursor:pointer;" />
                    <?php else: ?>
                        <rect class="zone-click"
                              x="<?= $obj['x'] ?>"
                              y="<?= $obj['y'] ?>"
                              width="<?= $obj['width'] ?>"
                              height="<?= $obj['height'] ?>"
                              fill="transparent"
                              pointer-events="all"    a stocker en base
                              style="cursor:pointer;" />
                    <?php endif; ?>

                    <?php if (isset($obj['texte'])): ?>
                        <text x="<?= $obj['texte_x'] ?>" y="<?= $obj['texte_y'] ?>"   regarder si ya pas un calcul pour le mettre auto)
                              text-anchor="middle"
                              font-size="28"
                              font-weight="600"
                              fill="black"
                        >
                            <?= $obj['texte'] ?>
                        </text>
                    <?php endif; ?>
                </g>

            <?php endforeach; ?>
            // recreer model, modif controller et view pour afficher les objets, drag n drop non fonctionnel, les réponses marchent pas,
            faire classe bonne rep, gérer les rep avec,































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

<?= (str_contains($enigme->image, 'compil')) ? script_tag('js/salle_5/enigmeSalle.js')  : script_tag('js/salle_5/enigme.js') ?>

<?= script_tag('js/salle_5/mascotte.js') ?>

<?php if ($enigme->type_numero == 402): ?>
    <?= script_tag('js/salle_5/enigme6.js') ?>S
<?php endif; ?>
