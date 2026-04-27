<?= (str_contains($enigme->image, 'compil'))
        ? link_tag('styles/salle_5/enigmeSalle.css')
        : link_tag('styles/salle_5/enigme.css') ?>

<title><?= esc($enigme->libelle) ?></title>
</head>

<body data-baseurl="<?= base_url() ?>">

<div class="scene-enigme">

    <!-- ================= QUESTION ================= -->
    <?php if ($mode_emploi): ?>
        <div class="question-box">
            <h2 class="question-titre">
                <?= esc($mode_emploi->explication_2) ?>
            </h2>
        </div>
    <?php endif; ?>

    <!-- ================= SVG ================= -->
    <div class="bureau-wrapper">
        <svg
                width="<?= $enigme->width_img ?>"
                height="<?= $enigme->height_img ?>"
                viewBox="0 0 <?= $enigme->width_img ?> <?= $enigme->height_img ?>"
                xmlns="http://www.w3.org/2000/svg">

            <!-- ===== FOND ===== -->
            <image
                    href="<?= base_url($enigme->image) ?>"
                    x="0" y="0"
                    width="<?= $enigme->width_img ?>"
                    height="<?= $enigme->height_img ?>"
                    style="pointer-events:none;" />

            <!-- ===== OBJETS SVG (drag = NULL) ===== -->
            <?php foreach ($objets_activite as $obj): ?>
                <?php if (empty($obj['drag'])): ?>

                    <g id="<?= esc($obj['nom']) ?>"
                            <?= (empty($obj['cliquable']))? 'class="objet-cliquable"' : 'class="objet-decor"' ?>

                       data-reponse="<?= esc($obj['reponse']) ?>">

                        <?= (isset($obj['hover'])) ? '<title>' . esc($obj['hover']) . '</title>' : '' ?>

                        <image
                                href="<?= base_url($obj['image']) ?>"
                                x="<?= $obj['x'] ?>"
                                y="<?= $obj['y'] ?>"
                                width="<?= $obj['width'] ?>"
                                height="<?= $obj['height'] ?>"
                                <?= (isset($obj['ratio']))? 'preserveAspectRatio="'.$obj['ratio'].'"' : 'preserveAspectRatio="xMidYMid"' ?>
                                <?= !empty($obj['rotate']) ? 'transform="'.$obj['rotate'].'"' : '' ?>
                        />

                        <?php if (!empty($obj['zone_path'])): ?>
                        <?= (empty($obj['cliquable']))? '<path class="zone-click"' : '<path class="aucune"' ?>
                                  d="<?= $obj['zone_path'] ?>"
                                  fill="none"
                                  pointer-events="all"
                                  style="cursor:pointer;"
                            <?= !empty($obj['rotate']) ? 'transform="'.$obj['rotate'].'"' : '' ?>/>
                        <?php else: ?>
                            <?= (empty($obj['cliquable']))? '<rect class="zone-click"' : '<rect class="aucune"' ?>
                                  x="<?= $obj['x'] ?>"
                                  y="<?= $obj['y'] ?>"
                                  width="<?= $obj['width'] ?>"
                                  height="<?= $obj['height'] ?>"
                                  fill="transparent"
                                  pointer-events="all"
                                  style="cursor:pointer;"
                            <?= !empty($obj['rotate']) ? 'transform="'.$obj['rotate'].'"' : '' ?>/>
                        <?php endif; ?>

                        <?php if (!empty($obj['texte'])): ?>
                            <text x="<?= $obj['x'] + $obj['width'] / 2 ?>"
                                  y="<?= $obj['y'] + $obj['height'] / 2 ?>"
                                  text-anchor="middle"
                                  dominant-baseline="central"
                                  font-size="28"
                                  font-weight="600"
                                  fill="black"
                                  pointer-events="none">
                                <?= esc($obj['texte']) ?>
                            </text>
                        <?php endif; ?>

                        <?php if ($enigme->type_numero == 402): ?>
                            <!-- Zone de dépôt pour le drag & drop -->
                            <foreignObject
                                    x="<?= $obj['x'] ?>"
                                    y="<?= $obj['y'] ?>"
                                    width="<?= $obj['width'] ?>"
                                    height="<?= $obj['height'] ?>">
                                <div xmlns="http://www.w3.org/1999/xhtml"
                                     id="zone_depot"
                                     style="width: 100%; height: 100%; border: 3px dashed #4caf50; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 5px;">
                                </div>
                            </foreignObject>
                        <?php endif; ?>

                    </g>

                <?php endif; ?>
            <?php endforeach; ?>

            <!-- ===== INFOBULLE ===== -->
            <?php if ($indice): ?>
                <?php
                $isCompil = str_contains($enigme->image, 'compil');

                $xImage = $isCompil ? '1358' : '1100';
                $yImage = $isCompil ? '723'    : '680';

                $xText  = $isCompil ? '1380'   : '1120';
                $yText  = $isCompil ? '780'    : '750';
                ?>

                <g id="infobulle" class="infobulle" style="display:none">
                    <image
                            href="<?= base_url('images/salle_6/bulle-salle-6.svg') ?>"
                            x="<?= $xImage ?>"
                            y="<?= $yImage ?>"
                            width="340"
                            height="250"
                    />

                    <foreignObject
                            x="<?= $xText ?>"
                            y="<?= $yText ?>"
                            width="300"
                            height="180"
                    >
                        <div xmlns="http://www.w3.org/1999/xhtml" class="texte-indice">
                            <?= esc($indice->libelle) ?>
                        </div>
                    </foreignObject>
                </g>
            <?php endif; ?>


            <!-- ===== LUMI ===== -->
            <g id="lumi" class="zone-lumi" data-piece="Lumi">
                <image class="lumi-image default"
                       preserveAspectRatio="xMidYMid slice"
                       <?php if (str_contains($enigme->image, 'compil')): ?>
                       x="1687.9" y="786.97" width="205" height="252"
                       <?php else: ?>
                       x="1400.9" y="725.97"
                       width="205" height="252"
                       <?php endif; ?>
                       xlink:href="<?= base_url('images/commun/mascotte/mascotte_face.svg') ?>" />
                <image class="lumi-image hover"
                       preserveAspectRatio="xMidYMid slice"
                        <?php if (str_contains($enigme->image, 'compil')): ?>
                            x="1687.9" y="786.97" width="205" height="252"
                        <?php else: ?>
                            x="1400.9" y="725.97"
                            width="205" height="252"
                        <?php endif; ?>
                       xlink:href="<?= base_url('images/commun/mascotte/mascotte_interrogee.svg') ?>" />
                <rect class="lumi-zone"
                        <?php if (str_contains($enigme->image, 'compil')): ?>
                            x="1687.9" y="786.97" width="205" height="252"
                        <?php else: ?>
                            x="1400.9" y="725.97"
                            width="205" height="252"
                        <?php endif; ?>
                      pointer-events="all"/>
            </g>

        </svg>
    </div>

    <!-- ================= OBJETS DRAGGABLES ================= -->
    <?php if ($enigme->type_numero == 402): ?>
    <div class="objets-draggables">
        <?php foreach ($objets_activite as $obj): ?>
            <?php if ($obj['drag'] === 'oui'): ?>

                <div class="objet-drag"
                     draggable="true"
                     data-objet="<?= esc($obj['nom']) ?>">

                    <?= img([
                            'src'   => $obj['image'],
                            'alt'   => $obj['nom'],
                            'class' => 'objet-img'
                    ]) ?>

                    <p style="font-size: 0.9em; margin-top: 5px;"><?= esc($obj['nom']) ?></p>
                </div>

            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="feedback" id="feedback"></div>

</div>

<div id="transition-overlay"></div>

<script>
    const activite_numero = <?= $enigme->numero ?>;
    const base_url = '<?= base_url() ?>';
</script>

<?= script_tag('js/salle_5/enigme.js') ?>

<?= script_tag('js/salle_5/Salle2Mascotte.js') ?>

<?php if ($enigme->type_numero == 402): ?>
    <?= script_tag('js/salle_5/enigme6.js') ?>
<?php endif; ?>
