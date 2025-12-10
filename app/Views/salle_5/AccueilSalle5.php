    <?= link_tag('styles/salle_5/salle5.css') ?>
    <title>Salle 5</title>
</head>
<body data-baseurl="<?= base_url() ?>" data-mode="<?= session()->get('mode') ?>">
<div class="plan-container">
    <div class="svg-wrapper">
        <svg width="1920" height="1080" version="1.1" viewBox="0 0 1920 1080" xmlns="http://www.w3.org/2000/svg">

            <image
                    xlink:href="<?= base_url('images/salle_5/salle_bureau_compil.svg') ?>"
                    x="0"
                    y="0"
                    width="1920" height="1080"
                    id="image-fond"
                    style="pointer-events: none;"/>

            <?php foreach ($objets as $obj): ?>

                <g id="<?= $obj['nom'] ?>" class="objet-enigme" data-activite="<?= $obj['activite_numero'] ?>">

                    <image
                            id="image_<?= $obj['nom'] ?>"
                            x="<?= $obj['x'] ?>"
                            y="<?= $obj['y'] ?>"
                            width="<?= $obj['width'] ?>"
                            height="<?= $obj['height'] ?>"
                            preserveAspectRatio="none"
                            clip-path="url(#<?= $obj['clip_path_name'] ?>)"
                            xlink:href="<?= base_url($obj['image_path']) ?>"
                    />

                    <?php if (!empty($obj['zone_path'])): ?>
                        <path class="piece-zone"
                              d="<?= $obj['zone_path'] ?>"
                              fill="transparent"
                              style="cursor:pointer;" />
                    <?php else: ?>
                        <rect class="piece-zone"
                              x="<?= $obj['x'] ?>"
                              y="<?= $obj['y'] ?>"
                              width="<?= $obj['width'] ?>"
                              height="<?= $obj['height'] ?>"
                              fill="transparent"
                              style="cursor:pointer;" />
                    <?php endif; ?>

                </g>

            <?php endforeach; ?>

            <g id="accueil" class="zone-accueil" data-piece="retour-accueil">
                <ellipse class="accueil-zone" cx="150" cy="100" rx="85" ry="85" fill="transparent"/>
                <image
                       preserveAspectRatio="none"
                       x="65"
                       y="15"
                       width="170"
                       height="170"
                       xlink:href="<?= base_url('images/commun/btn_retour/home_icone_5.webp') ?>" />
            </g>

            <g id="infobulle" class="infobulle" style="display:none">
                <image id="indice"
                       preserveAspectRatio="none"
                       x="1358.2" y="723.12" width="341.71" height="248.52"
                       xlink:href="<?= base_url('images/salle_6/bulle-salle-6.svg') ?>" />
                <!-- Bloc texte dans la bulle -->
                <foreignObject x="1380" y="780" width="300" height="200">
                    <div class="texte-indice" xmlns="http://www.w3.org/1999/xhtml"
                         style="font-size:22px; font-weight:600; text-align:center;">
                        <?= $indice->libelle ?>
                    </div>
                </foreignObject>
            </g>

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

    <h1 class="titre-salle"><?=$salle['libelle']?></h1>

    <?php if ($afficher_popup): ?>
        <div id="popup-explication" class="popup">
            <div class="popup-content">
                <span class="close-btn" onclick="closePopup()">&times;</span>
                <h2>Explication</h2>
                <p><?= $salle['intro_salle'] ?></p>
                <div class="popup-actions">
                    <button class="btn-accueil" onclick="closePopup()">
                        J'ai compris !
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($afficher_popup_succes): ?>
        <div id="popup-succes" class="popup popup-succes" style="display: flex;">
            <div class="popup-content popup-succes-content">
                <h2>Félicitations !</h2>
                <p>Vous avez terminé les 2 énigmes de la salle !</p>
                <p>Vous avez démontré votre vigilance et votre compréhension des enjeux de la sécurité physique et matérielle.</p>
                <?php if (session()->get('mode') === 'jour'): ?>
                <div class="popup-actions">
                    <?= form_open(base_url('/validerJour/5')) ?>
                    <?= form_button([
                            'content' => 'Continuer la visite du manoir',
                            'type'    => 'submit',
                            'class'   => 'btn-accueil'
                    ]) ?>
                    <?= form_close() ?>
                </div>
                <?php else: ?>
                    <p>Vous pouvez accéder à la salle suivante !</p>
                    <div class="popup-actions">
                    <?= form_open(base_url('/valider/5')) ?>
                    <?= form_button([
                            'content' => 'Continuer le périple',
                            'type'    => 'submit',
                            'class'   => 'btn-accueil'
                    ]) ?>
                    <?= form_close() ?>
                </div>
                <?php endif?>
            </div>
        </div>
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                if (window.changerMascotte) {
                    window.changerMascotte('contente');
                }
            });
        </script>
    <?php endif; ?>

    <?php if ($afficher_popup_echec): ?>
        <div id="popup-echec" class="popup popup-echec" style="display: flex;">
            <div class="popup-content popup-echec-content">
                <h2>Échec !</h2>
                <p>Malheureusement vous n'avez pas réussi les énigmes de la salle</p>
                <?php if (session()->get('mode') === 'jour'): ?>
                    <div class="popup-actions">
                        <?= form_open(base_url('/echouerJour/5')) ?>
                        <?= form_button([
                                'content' => "Continuer la visite du manoir",
                                'type'    => 'submit',
                                'class' => 'btn-echec',
                                'onclick' => 'closePopupEchec()'
                        ]) ?>
                        <?= form_close() ?>
                    </div>
                <?php else: ?>
                    <p>Vous devez recommencer le parcours.</p>
                <div class="popup-actions">
                    <?= form_open(base_url('/reset')) ?>
                    <?= form_button([
                            'content' => "Recommencer le manoir",
                            'type'    => 'submit',
                            'class' => 'btn-echec',
                            'onclick' => 'closePopupEchec()'
                    ]) ?>
                    <?= form_close() ?>
                </div>
                <?php endif?>
            </div>
        </div>
    <?php endif; ?>

</div>

<div id="transition-overlay"></div>
<?= script_tag('js/salle_5/mascotte.js') ?>
<?= script_tag('js/salle_5/salle5.js') ?>



