<?= link_tag('styles/salle_5/enigmeSalle.css') ?>
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
        <svg width="1920" height="1080" version="1.1" viewBox="0 0 1920 1080" xmlns="http://www.w3.org/2000/svg">

            <image
                    xlink:href="<?= base_url('images/salle_5/salle_bureau_compil.svg') ?>"
                    x="0"
                    y="0"
                    width="1920" height="1080"
                    id="image-fond"
                    style="pointer-events: none;"/>

            <!-- ========================================
                 ÉNIGME 1 : Poste risqué
            ======================================== -->
            <?php if ($enigme->numero == 501): ?>
                <!-- Écran gauche - mail ouvert -->
                <g id="ecran_mail" class="objet-cliquable" data-reponse="ecran_milieu_gauche">
                    <image clip-path="url(#clip_ecran_milieu_gauche)"
                           preserveAspectRatio="none"
                           x="724.84" y="521.63"
                           width="250" height="134"
                           xlink:href="<?= base_url('images/salle_5/ecran_mail_2.svg') ?>"/>
                    <path class="zone-click"
                          d="m724.2 521.63 243.77-0.21573 7.9819 133.97-250.89-0.43145z"
                          fill="none"
                          pointer-events="all"
                          style="cursor:pointer;"
                          />
                </g>

                <!-- Écran droit - données sensibles -->
                <g id="ecran_data" class="objet-cliquable" data-reponse="ecran_data">
                    <image clip-path="url(#clip_ecran_milieu_droit)"
                           preserveAspectRatio="none"
                           x="1018.8" y="523.13"
                           width="234.28" height="132.24"
                           xlink:href="<?= base_url('images/salle_5/ecran_login_2_v2.webp') ?>"/>
                    <path class="zone-click"
                          d="m1018.8 523.13h233.84l0.4386 132.24-233.84-3.1168z"
                          fill="none"
                          pointer-events="all"
                          style="cursor:pointer;"
                          />
                </g>
            <?php endif; ?>

            <!-- ========================================
                 ÉNIGME 5 : Porte entrouverte
            ======================================== -->
            <?php if ($enigme->numero == 505): ?>
                <g id="porte" class="objet-cliquable" data-reponse="porte">
                    <image clip-path="url(#clip_porte)"
                           x="1592.5" y="237.97"
                           width="257.49" height="838.37"
                           preserveAspectRatio="none"
                           xlink:href="<?= base_url('images/salle_5/porte_ouverte.svg') ?>"/>
                    <rect class="zone-click"
                          x="1592.5" y="237.97"
                          width="257.49" height="838.37"
                          fill="transparent"
                          style="cursor:pointer;"
                         />
                </g>
            <?php endif; ?>

            <!-- ========================================
                 ÉNIGME 6 : Écrans non sécurisés + DRAG & DROP
            ======================================== -->
            <?php if ($enigme->numero == 506): ?>
                <g id="ecran_milieu_gauche" class="objet-enigme" data-reponse="ecran">
                    <image id="image_ecran_milieu_gauche"
                           clip-path="url(#clip_ecran_milieu_gauche)"
                           preserveAspectRatio="none"
                           x="724.84" y="521.63"
                           width="250" height="134"
                           xlink:href="<?= base_url('images/salle_5/ecran_data_2.svg') ?>"/>
                    <path class="piece-zone"
                          d="m724.2 521.63 243.77-0.21573 7.9819 133.97-250.89-0.43145z"
                          fill="transparent"
                           />
                </g>

                <!-- Zone de dépôt pour le drag & drop -->
                <foreignObject x="724.84" y="521.63" width="250" height="134">
                    <div xmlns="http://www.w3.org/1999/xhtml" id="zone_depot"
                         style="width: 100%; height: 100%; border: 3px dashed #4caf50; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 5px;">
                    </div>
                </foreignObject>
            <?php endif; ?>

            <!-- ========================================
                 ÉNIGME 7 : Fenêtre ouverte (QCM en SVG)
            ======================================== -->
            <?php if ($enigme->numero == 507): ?>
                <!-- Fenêtre ouverte (visuel) -->
                <g id="fenetre_visuel">
                    <image clip-path="url(#clip_fenetre)"
                           x="64" y="182" width="218" height="458"
                           xlink:href="<?= base_url('images/salle_5/fenetre_ouverte.svg') ?>"/>
                </g>

                <!-- CHOIX 1 -->
                <g id="choix_1" class="objet-cliquable" data-reponse="choix1">
                    <image width="594" height="105" x="1270" y="388"
                           xlink:href="<?= base_url('images/salle_5/reponse.svg') ?>"/>
                    <text x="1567" y="450"
                          text-anchor="middle"
                          font-size="28"
                          font-weight="600"
                          fill="black"
                          >
                        Fermer/Sécuriser la fenêtre
                    </text>
                    <rect class="zone-click" width="594" height="105"
                          x="1270" y="388" fill="transparent" style="cursor:pointer;"/>
                </g>

                <!-- CHOIX 2 -->
                <g id="choix_2" class="objet-cliquable" data-reponse="autocollant">
                    <image width="594" height="105" x="1270" y="508"
                           xlink:href="<?= base_url('images/salle_5/reponse.svg') ?>"/>
                    <text x="1567" y="570"
                          text-anchor="middle"
                          font-size="28"
                          font-weight="600"
                          fill="black"
                          >
                        Poser un autocollant "Ne pas toucher"
                    </text>
                    <rect class="zone-click" width="594" height="105"
                          x="1270" y="508" fill="transparent" style="cursor:pointer;"/>
                </g>

                <!-- CHOIX 3 -->
                <g id="choix_3" class="objet-cliquable" data-reponse="cacher_tapis">
                    <image width="594" height="105" x="1270" y="628"
                           xlink:href="<?= base_url('images/salle_5/reponse.svg') ?>"/>
                    <text x="1567" y="690"
                          text-anchor="middle"
                          font-size="28"
                          font-weight="600"
                          fill="black"
                          >
                        Cacher le matériel sous un tapis
                    </text>
                    <rect class="zone-click" width="594" height="105"
                          x="1270" y="628" fill="transparent" style="cursor:pointer;"/>
                </g>

                <!-- CHOIX 4 -->
                <g id="choix_4" class="objet-cliquable" data-reponse="choix4">
                    <image width="594" height="105" x="1270" y="748"
                           xlink:href="<?= base_url('images/salle_5/reponse.svg') ?>"/>
                    <text x="1567" y="810"
                          text-anchor="middle"
                          font-size="28"
                          font-weight="600"
                          fill="black"
                          >
                        Éloigner/Verrouiller le matériel proche
                    </text>
                    <rect class="zone-click" width="594" height="105"
                          x="1270" y="748" fill="transparent" style="cursor:pointer;"/>
                </g>
            <?php endif; ?>

            <!-- ========================================
                 ÉNIGME 10 : Caméra interne
            ======================================== -->
            <?php if ($enigme->numero == 510): ?>
                <g id="camera" class="objet-cliquable" data-reponse="camera">
                    <image clip-path="url(#clip_camera)"
                           x="1577.1" y="89.952" width="232.99" height="113.9"
                           xlink:href="<?= base_url('images/salle_5/camera.svg') ?>"/>
                    <rect class="zone-click"
                          x="1577.1" y="89.952" width="232.99" height="113.9"
                          fill="transparent"
                          pointer-events="all"
                          style="cursor:pointer;"
                          />
                </g>
            <?php endif; ?>

            <?php if ($enigme->numero == 505 || $enigme->numero == 510): ?>
            <g id="ecran_bas_gauche" class="objet-cliquable" data-reponse=".">
                <image clip-path="url(#clip_camera)"
                       x="450" y="511.71" width="230" height="198"
                       xlink:href="<?= base_url('images/salle_5/ecran_veille_1.svg') ?>"/>
                <rect class="zone-click"
                      x="450" y="511.71" width="230" height="198"
                      fill="transparent"
                      pointer-events="all"
                      style="cursor:pointer;"
                />
            </g>

                <g id="ecran_bas_mid_gauche" class="objet-cliquable" data-reponse=".">
                    <image clip-path="url(#clip_camera)"
                           x="723" y="517.31" width="255" height="189"
                           xlink:href="<?= base_url('images/salle_5/ecran_veille_2.svg') ?>"/>
                    <rect class="zone-click"
                          x="723" y="517.31" width="255" height="189"
                          fill="transparent"
                          pointer-events="all"
                          style="cursor:pointer;"
                    />
                </g>

                <g id="ecran_bas_mid_droit" class="objet-cliquable" data-reponse=".">
                    <image clip-path="url(#clip_camera)"
                           x="1013" y="514.29" width="245" height="193"
                           xlink:href="<?= base_url('images/salle_5/ecran_veille_2_1.svg') ?>"/>
                    <rect class="zone-click"
                          x="1013" y="514.29" width="245" height="193"
                          fill="transparent"
                          pointer-events="all"
                          style="cursor:pointer;"
                    />
                </g>

                <g id="ecran_geant" class="objet-cliquable" data-reponse=".">
                    <image clip-path="url(#clip_camera)"
                           x="426.28" y="195" width="1115" height="293"
                           xlink:href="<?= base_url('images/salle_5/ecran_surveillance.svg') ?>"/>
                    <rect class="zone-click"
                          x="426.28" y="195" width="1115" height="293"
                          fill="transparent"
                          pointer-events="all"
                          style="cursor:pointer;"
                    />
                </g>

            <?php endif; ?>

            <g id="lumi" class="zone-lumi" data-piece="Lumi">
                <image class="lumi-image default"
                       preserveAspectRatio="xMidYMid slice"
                       x="1687.9" y="786.97" width="205" height="252"
                       xlink:href="<?= base_url('images/commun/mascotte/mascotte_face.svg') ?>" />
                <image class="lumi-image hover"
                       preserveAspectRatio="xMidYMid slice"
                       x="1687.9" y="786.97" width="205" height="252"
                       xlink:href="<?= base_url('images/commun/mascotte/mascotte_interrogee.svg') ?>" />
                <rect class="lumi-zone" x="1687.9" y="786.97" width="205" height="252" pointer-events="all"/>
            </g>

        </svg>
    </div>

    <!-- ✅ OBJETS DRAGGABLES POUR ÉNIGME 6 (avec helpers CI4) -->
    <?php if ($enigme->numero == 506): ?>
        <div class="objets-draggables">
            <div class="objet-drag" draggable="true" data-objet="filtre">
                <?= img([
                        'src' => 'images/salle_5/filtre_ecran.svg',
                        'alt' => 'Filtre écran',
                        'class' => 'objet-img'
                ]) ?>
                <p style="font-size: 0.9em; margin-top: 5px;">Filtre</p>
            </div>
            <div class="objet-drag" draggable="true" data-objet="cb">
                <?= img([
                        'src' => 'images/salle_5/cb.svg',
                        'alt' => 'CB',
                        'class' => 'objet-img'
                ]) ?>
                <p style="font-size: 0.9em; margin-top: 5px;">CB</p>
            </div>
            <div class="objet-drag" draggable="true" data-objet="cle">
                <?= img([
                        'src' => 'images/salle_5/cle.svg',
                        'alt' => 'Clé',
                        'class' => 'objet-img'
                ]) ?>
                <p style="font-size: 0.9em; margin-top: 5px;">Clé</p>
            </div>
            <div class="objet-drag" draggable="true" data-objet="post-it">
                <?= img([
                        'src' => 'images/salle_5/post_it_confidentiel.svg',
                        'alt' => 'Post-it',
                        'class' => 'objet-img'
                ]) ?>
                <p style="font-size: 0.9em; margin-top: 5px;">Post-it</p>
            </div>
            <div class="objet-drag" draggable="true" data-objet="usb">
                <?= img([
                        'src' => 'images/salle_5/usb_rh.svg',
                        'alt' => 'USB',
                        'class' => 'objet-img'
                ]) ?>
                <p style="font-size: 0.9em; margin-top: 5px;">USB</p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Feedback -->
    <div class="feedback" id="feedback"></div>
</div>

<div id="transition-overlay"></div>

<script>
    const activite_numero = <?= $enigme->numero ?>;
    const base_url = '<?= base_url() ?>';
</script>
<?= script_tag('js/salle_5/mascotte.js') ?>
<?= script_tag('js/salle_5/enigmeSalle.js') ?>
<?php if ($enigme->numero == 506): ?>
    <?= script_tag('js/salle_5/enigme6.js') ?>
<?php endif; ?>
