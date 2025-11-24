<?= link_tag('styles/salle_5/enigme.css') ?>
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
        <svg width="1920" height="1080" version="1.1" viewBox="0 0 1375 917" xmlns="http://www.w3.org/2000/svg">
            <image
                    xlink:href="<?= base_url('images/salle_5/bureau.svg') ?>"
                    x="0"
                    y="0"
                    width="1375" height="917"
                    id="image-fond"
                    style="pointer-events: none;"/>


            <?php if ($enigme->numero == 502 || $enigme->numero == 509):
                $class = "";
            $cursor = '';
            else:
                $class = 'class="objet-cliquable"';
                $cursor = 'style="cursor:pointer;"';
            endif; ?>

            <g id="ciseaux"  <?=$class?> data-reponse=".">
                <image x="350.22" y="-18.651" width="129" height="224.38" transform="rotate(90, 414.72, 93.539)"
                       xlink:href="<?= base_url('images/salle_5/ciseau.svg') ?>"/>

                <rect class="zone-click" x="350.22" y="-18.651" width="129" height="224.38"
                      fill="transparent" <?=$cursor?> transform="rotate(90, 414.72, 93.539)"/>
            </g>

            <g id="pic" <?=$class?> data-reponse=".">
                <image x="322.25" y="445.55" width="115.01" height="54.916"
                       xlink:href="<?= base_url('images/salle_5/pic_2.svg') ?>"/>

                <rect class="zone-click" x="322.25" y="445.55" width="115.01" height="54.916"
                      fill="transparent" <?=$cursor?>/>
            </g>

            <g id="puce" <?=$class?> data-reponse=".">
                <image x="823.75" y="51.808" width="133.66" height="49.736"
                       xlink:href="<?= base_url('images/salle_5/puce_1.svg') ?>"/>

                <rect class="zone-click" x="823.75" y="51.808" width="133.66" height="49.736"
                      fill="transparent" <?=$cursor?>/>
            </g>

            <g id="stylo" <?=$class?> data-reponse=".">
                <image x="321.21" y="758.47" width="295.31" height="119.16"
                       xlink:href="<?= base_url('images/salle_5/stylo.svg') ?>"/>

                <rect class="zone-click" x="321.21" y="758.47" width="295.31" height="119.16"
                      fill="transparent" <?=$cursor?>/>
            </g>

            <g id="tel" <?=$class?> data-reponse=".">
                <image x="808.2" y="662.11" width="157" height="175"
                       xlink:href="<?= base_url('images/salle_5/telephone.svg') ?>"/>

                <rect class="zone-click" x="808.2" y="662.11" width="157" height="175"
                      fill="transparent" <?=$cursor?>/>
            </g>

            <g id="trombone" <?=$class?> data-reponse=".">
                <image x="761.58" y="437.26" width="84.965" height="66.314"
                       xlink:href="<?= base_url('images/salle_5/trombone.svg') ?>"/>

                <rect class="zone-click" x="761.58" y="437.26" width="84.965" height="66.314"
                      fill="transparent" <?=$cursor?>/>
            </g>

            <?php if ($enigme->numero != 508 && $enigme->numero != 504): ?>
                <g id="carnet" <?=$class?> data-reponse="A">
                    <image clip-path="url(#clip_carnet)"
                           x="-169.72" y="281.21" width="447.7" height="251.17"
                           xlink:href="<?= base_url('images/salle_5/carnet.svg') ?>"/>
                    <rect class="zone-click" x="-169.72" y="281.21" width="447.7" height="251.17" fill="transparent"
                            <?php if ($enigme->numero == 509): ?>
                          style="cursor:default;"
                    <?php endif; ?>/>
                </g>
            <?php endif; ?>

            <!-- Énigme 2 : Clés USB -->
            <?php if ($enigme->numero == 502): ?>
                <!-- Clé USB gauche -->
                <g id="usb_left" class="objet-cliquable" data-reponse="cle_usb_gauche">
                    <title>Une clé USB qui circule dans l'entreprise</title>
                    <image
                            x="133" y="282" width="128" height="83"
                            transform="rotate(-15, 197, 323)"
                            xlink:href="<?= base_url('images/salle_5/usb_finance.svg') ?>" />
                    <rect class="zone-click"
                          x="133" y="282" width="128" height="83"
                          transform="rotate(-15, 197, 323)"
                          fill="transparent" style="cursor:pointer;" />
                </g>

                <!-- Clé USB bas -->
                <g id="usb_bottom" class="objet-cliquable" data-reponse="cle1">
                    <title>Une clé USB remise en main propre par le service comptabilité</title>
                    <image
                            x="104" y="756" width="123" height="84"
                            transform="rotate(12, 165, 798)"
                            xlink:href="<?= base_url('images/salle_5/usb_anonyme.svg') ?>" />
                    <rect class="zone-click"
                          x="104" y="756" width="123" height="84"
                          transform="rotate(12, 168, 798)"
                          fill="transparent" />
                </g>

                <!-- Clé USB droite -->
                <g id="usb_right" class="objet-cliquable" data-reponse="cle_usb_droite">
                    <title class="blutblut">Une clé USB qui a été trouvé par terre</title>
                    <image
                            x="1097" y="292" width="155" height="78"
                            transform="rotate(20, 1174, 331)"
                            xlink:href="<?= base_url('images/salle_5/usb_rh.svg') ?>" />
                    <rect class="zone-click"
                          x="1097" y="292" width="155" height="78"
                          transform="rotate(20, 1174, 331)"
                          fill="transparent" />
                </g>
            <?php endif; ?>


            <!-- Énigme 3 : Clé / Badge -->
            <?php if ($enigme->numero == 503): ?>
                <g id="cle" class="objet-cliquable" data-reponse="cle">
                    <image clip-path="url(#clip_cle)"
                           x="850" y="703.12" width="170.83" height="73.958"
                           xlink:href="<?= base_url('images/salle_5/cle.svg') ?>"/>
                    <rect class="zone-click" x="850" y="703.12" width="170.83" height="73.958" fill="transparent"
                         />
                </g>

                <g id="carte_pass" class="objet-cliquable" data-reponse="carte_pass">
                    <image clip-path="url(#clip_carte_pass)"
                           x="106.25" y="332.29" width="152.08" height="110.42"
                           xlink:href="<?= base_url('images/salle_5/badge.svg') ?>"/>
                    <rect class="zone-click" x="106.25" y="332.29" width="152.08" height="110.42" fill="transparent"
                          />
                </g>

                <g id="carte_bancaire" class="objet-cliquable" data-reponse="carte_bancaire">
                    <image clip-path="url(#clip_carte_bancaire)"
                           x="1167.7" y="230.21" width="182.29" height="114.58"
                           xlink:href="<?= base_url('images/salle_5/cb.svg') ?>"/>
                    <rect class="zone-click" x="1167.7" y="230.21" width="182.29" height="114.58" fill="transparent"
                         />
                </g>
            <?php endif; ?>

            <!-- Énigme 4 : Post-it confidentiel -->
            <?php if ($enigme->numero == 504): ?>
                <g id="post_it" class="objet-cliquable" data-reponse="post_it_conf_2">
                    <image clip-path="url(#clip_post_it)"
                           x="1145.8" y="143.75" width="146.87" height="142.71"
                           xlink:href="<?= base_url('images/salle_5/post_it_confidentiel.svg') ?>"/>
                    <rect class="zone-click" x="1145.8" y="143.75" width="146.87" height="142.71" fill="transparent"
                         />
                </g>

                <g id="dossier" class="objet-cliquable" data-reponse="dossier_conf">
                    <image clip-path="url(#clip_dossier)"
                           x="940.62" y="410.42" width="288.54" height="387.5"
                           xlink:href="<?= base_url('images/salle_5/dossier.svg') ?>"/>
                    <rect class="zone-click" x="940.62" y="410.42" width="288.54" height="387.5" fill="transparent"
                          />
                </g>

                <g id="carnet" class="objet-cliquable" data-reponse="carnet">
                    <image clip-path="url(#clip_carnet)"
                           x="-169.72" y="281.21" width="447.7" height="251.17"
                           xlink:href="<?= base_url('images/salle_5/carnet.svg') ?>"/>
                    <rect class="zone-click" x="-169.72" y="281.21" width="447.7" height="251.17" fill="transparent"
                          />
                </g>
            <?php endif; ?>

            <!-- Énigme 8 : Dossier -->
            <?php if ($enigme->numero == 508): ?>
                <g id="dossier" class="objet-cliquable" data-reponse="dossier_conf">
                    <image clip-path="url(#clip_dossier)"
                           x="940.62" y="410.42" width="288.54" height="387.5"
                           xlink:href="<?= base_url('images/salle_5/dossier.svg') ?>"/>
                    <rect class="zone-click" x="940.62" y="410.42" width="288.54" height="387.5" fill="transparent"
                         />
                </g>

                <g id="carnet_mdp" class="objet-cliquable" data-reponse="carnet_mdp_2">
                    <image clip-path="url(#clip_carnet_mdp)"
                           x="-169.72" y="281.21" width="447.7" height="251.17"
                           xlink:href="<?= base_url('images/salle_5/carnet_mdp.svg') ?>"/>
                    <rect class="zone-click" x="-169.72" y="281.21" width="447.7" height="251.17" fill="transparent"
                          />
                </g>

                <g id="usb_right" class="objet-cliquable" data-reponse="cle3">
                    <image
                            x="1097" y="292" width="155" height="78"
                            transform="rotate(20, 1174, 331)"
                            xlink:href="<?= base_url('images/salle_5/usb_rh.svg') ?>" />
                    <rect class="zone-click"
                          x="1097" y="292" width="155" height="78"
                          transform="rotate(20, 1174, 331)"
                          fill="transparent"  />
                </g>
            <?php endif; ?>

            <!-- Énigme 9 : Carnet MDP -->
            <?php if ($enigme->numero == 509): ?>
                <g id="carte_pass" <?=$class?> data-reponse="B">
                    <image clip-path="url(#clip_carte_pass)"
                           x="106.25" y="332.29" width="152.08" height="110.42"
                           xlink:href="<?= base_url('images/salle_5/badge.svg') ?>"/>
                </g>

                <g id="post_it_code" <?=$class?> data-reponse="A">
                    <image clip-path="url(#clip_post_it_code)"
                           x="103.12" y="418.75" width="120.83" height="117.71"
                    xlink:href="<?= base_url('images/salle_5/post_it_code.svg') ?>"/>
                </g>

                <g id="choix_1" class="objet-cliquable" data-reponse="choix_1">
                    <image clip-path="url(#clip_carte_pass)"
                           x="987" y="143" width="533" height="72"
                           xlink:href="<?= base_url('images/salle_5/reponse.svg') ?>"/>
                    <text x="1253" y="188"
                          text-anchor="middle"
                          font-size="32"
                          font-weight="600"
                          fill="black"
                          pointer-events="none">
                        Le bureau est mal rangé
                    </text>
                    <rect class="zone-click" x="987" y="143" width="533" height="72" fill="transparent"
                          style="cursor:pointer;"/>
                </g>

                <g id="choix_2" class="objet-cliquable" data-reponse="choix_2">
                    <image clip-path="url(#clip_carte_pass)"
                           x="987" y="263" width="533" height="72"
                           xlink:href="<?= base_url('images/salle_5/reponse.svg') ?>"/>

                    <text x="1253" y="308"
                          text-anchor="middle"
                          font-size="32"
                          font-weight="600"
                          fill="black"
                          pointer-events="none">
                        Le code est trop simple
                    </text>

                    <rect class="zone-click" x="987" y="263" width="533" height="72" fill="transparent"
                         />
                </g>

                <g id="choix_3" class="objet-cliquable" data-reponse="choix_3">
                    <image clip-path="url(#clip_carte_pass)"
                           x="987" y="383" width="533" height="72"
                           xlink:href="<?= base_url('images/salle_5/reponse.svg') ?>"/>

                    <text x="1253" y="428"
                          text-anchor="middle"
                          font-size="32"
                          font-weight="600"
                          fill="black"
                          pointer-events="none">
                        Badge non porté/abandonné
                    </text>

                    <rect class="zone-click" x="987" y="383" width="533" height="72" fill="transparent"
                          />
                </g>

                <g id="choix_4" class="objet-cliquable" data-reponse="choix_4">
                    <image clip-path="url(#clip_carte_pass)"
                           x="987" y="503" width="533" height="72"
                           xlink:href="<?= base_url('images/salle_5/reponse.svg') ?>"/>

                    <text x="1253" y="548"
                          text-anchor="middle"
                          font-size="32"
                          font-weight="600"
                          fill="black"
                          pointer-events="none">
                        Code d'accès écrit et visible
                    </text>

                    <rect class="zone-click" x="987" y="503" width="533" height="72" fill="transparent"
                          />
                </g>

            <?php endif; ?>


        </svg>
    </div>

    <!-- Feedback -->
    <div class="feedback" id="feedback"></div>

    <!-- Mascotte -->
    <div class="mascotte">
        <?= img([
                "src" => base_url('images/commun/mascotte/mascotte_face.svg'),
                "class" => "mascotte-img",
                "alt" => "Mascotte"
        ]) ?>
    </div>
</div>

<div id="transition-overlay"></div>

<script>
    const activite_numero = <?= $enigme->numero ?>;
    const base_url = '<?= base_url() ?>';
</script>
<?= script_tag('js/salle_5/mascotte.js') ?>
<?= script_tag('js/salle_5/enigme.js') ?>
