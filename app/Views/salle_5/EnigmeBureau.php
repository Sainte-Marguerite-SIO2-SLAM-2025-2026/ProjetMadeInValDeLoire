<?= link_tag('styles/salle_5/enigme.css') ?>
<title><?= esc($enigme->libelle) ?></title>
</head>
<body>
<div class="scene-enigme">
    <!-- Bouton retour -->
    <div class="retour-top">
        <?= anchor('Salle5',
                form_button([
                        'content' => 'RETOUR',
                        'type' => 'button',
                        'class' => 'btn-retour'
                ])
        ) ?>
    </div>

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
        <svg width="1920" height="1080" version="1.1" viewBox="0 0 1920 1080" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <!-- Image de fond du bureau -->
            <image width="1920" height="1080" preserveAspectRatio="none"
                   xlink:href="<?= base_url('images/salle_5/bureau.svg') ?>"/>

            <defs>
                <!-- Clips paths pour les objets cliquables -->
                <clipPath id="clip_usb_left">
                    <rect x="220" y="260" width="100" height="40"/>
                </clipPath>
                <clipPath id="clip_usb_bottom">
                    <rect x="220" y="570" width="100" height="40"/>
                </clipPath>
                <clipPath id="clip_usb_right">
                    <rect x="960" y="250" width="100" height="40"/>
                </clipPath>
                <clipPath id="clip_cle">
                    <rect x="1507" y="702" width="70" height="23"/>
                </clipPath>
                <clipPath id="clip_post_it">
                    <rect x="800" y="210" width="73" height="85"/>
                </clipPath>
                <clipPath id="clip_dossier">
                    <rect x="621" y="610" width="68" height="96"/>
                </clipPath>
                <clipPath id="clip_carnet">
                    <rect x="828" y="530" width="116" height="106"/>
                </clipPath>
            </defs>

            <!-- Énigme 2 : Clés USB -->
            <?php if ($enigme->numero == 2): ?>
                <g id="usb_left" class="objet-cliquable" data-reponse="A">
                    <image clip-path="url(#clip_usb_left)"
                           x="220" y="260" width="100" height="40"
                           xlink:href="<?= base_url('images/salle_5/usb_finance.svg') ?>" />
                    <rect class="zone-click" x="220" y="260" width="100" height="40" fill="transparent" style="cursor:pointer;"/>
                </g>

                <g id="usb_bottom" class="objet-cliquable" data-reponse="B">
                    <image clip-path="url(#clip_usb_bottom)"
                           x="220" y="570" width="100" height="40"
                           xlink:href="<?= base_url('images/salle_5/usb_anonyme.svg') ?>" />
                    <rect class="zone-click" x="220" y="570" width="100" height="40" fill="transparent" style="cursor:pointer;"/>
                </g>

                <g id="usb_right" class="objet-cliquable" data-reponse="C">
                    <image clip-path="url(#clip_usb_right)"
                           x="960" y="250" width="100" height="40"
                           xlink:href="<?= base_url('images/salle_5/usb_rh.svg') ?>" />
                    <rect class="zone-click" x="960" y="250" width="100" height="40" fill="transparent" style="cursor:pointer;"/>
                </g>
            <?php endif; ?>

            <!-- Énigme 3 : Clé / Badge -->
            <?php if ($enigme->numero == 3): ?>
                <g id="cle" class="objet-cliquable" data-reponse="A">
                    <image clip-path="url(#clip_cle)"
                           x="1507" y="702" width="70" height="23"
                           xlink:href="<?= base_url('images/salle_5/cle.svg') ?>" />
                    <rect class="zone-click" x="1507" y="702" width="70" height="23" fill="transparent" style="cursor:pointer;"/>
                </g>
            <?php endif; ?>

            <!-- Énigme 4 : Post-it confidentiel -->
            <?php if ($enigme->numero == 4): ?>
                <g id="post_it" class="objet-cliquable" data-reponse="A">
                    <image clip-path="url(#clip_post_it)"
                           x="800" y="210" width="73" height="85"
                           xlink:href="<?= base_url('images/salle_5/post_it_confidentiel.svg') ?>" />
                    <rect class="zone-click" x="800" y="210" width="73" height="85" fill="transparent" style="cursor:pointer;"/>
                </g>
            <?php endif; ?>

            <!-- Énigme 8 : Dossier -->
            <?php if ($enigme->numero == 8): ?>
                <g id="dossier" class="objet-cliquable" data-reponse="A">
                    <image clip-path="url(#clip_dossier)"
                           x="621" y="610" width="68" height="96"
                           xlink:href="<?= base_url('images/salle_5/dossier.svg') ?>" />
                    <rect class="zone-click" x="621" y="610" width="68" height="96" fill="transparent" style="cursor:pointer;"/>
                </g>
            <?php endif; ?>

            <!-- Énigme 9 : Carnet MDP -->
            <?php if ($enigme->numero == 9): ?>
                <g id="carnet" class="objet-cliquable" data-reponse="A">
                    <image clip-path="url(#clip_carnet)"
                           x="828" y="530" width="116" height="106"
                           xlink:href="<?= base_url('images/salle_5/carnet_mdp.svg') ?>" />
                    <rect class="zone-click" x="828" y="530" width="116" height="106" fill="transparent" style="cursor:pointer;"/>
                </g>
            <?php endif; ?>
        </svg>
    </div>

    <!-- Feedback -->
    <div class="feedback" id="feedback"></div>

    <!-- Mascotte -->
    <div class="mascotte">
        <?= img([
                "src" => $mascotte->image,
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
<?= script_tag('js/salle_5/enigme.js') ?>
