    <?= link_tag('styles/salle_5/salle5.css') ?>
    <title>Salle 5</title>
</head>
<body data-baseurl="<?= base_url() ?>" data-mode="<?= session()->get('mode') ?>">
<?php
// On détermine l'image à afficher AVANT d'entrer dans le SVG
$imageEcranMilieuGauche = null;
// On détermine l'image à afficher AVANT d'entrer dans le SVG
$imageEcranMilieuDroite = null;

if (in_array("501", $activites_selectionnees)&& !in_array(501, $activites_reussies)) {
    $imageEcranMilieuDroite = base_url('images/salle_5/ecran_login_2_v2.webp');
} elseif (in_array("506", $activites_selectionnees)&& !in_array(506, $activites_reussies)){
    $imageEcranMilieuGauche = base_url('images/salle_5/ecran_data_2.svg');
}
?>
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

            <?php if ($imageEcranMilieuDroite): ?>
                <g id="ecran_milieu_droit" class="objet-enigme" data-activite="501">
                    <image id="image_ecran_milieu_droit"
                           clip-path="url(#clip_ecran_milieu_droit)"
                           preserveAspectRatio="none"
                           x="1018.8" y="523.13"
                           width="234.28" height="132.24"
                           xlink:href="<?= $imageEcranMilieuDroite ?>" />
                    <path class="piece-zone"
                          d="m1018.8 523.13h233.84l0.4386 132.24-233.84-3.1168z"
                          fill="transparent"
                          style="cursor:pointer;" />
                </g>
            <?php endif; ?>

            <!-- Écran milieu gauche (Activité 6) -->
            <?php if ($imageEcranMilieuGauche): ?>
                <g id="ecran_milieu_gauche" class="objet-enigme" data-activite="506">
                    <image id="image_ecran_milieu_gauche"
                           clip-path="url(#clip_ecran_milieu_gauche)"
                           preserveAspectRatio="none"
                           x="724.84" y="521.63" width="250" height="134"
                           xlink:href="<?= $imageEcranMilieuGauche ?>" />
                    <path class="piece-zone"
                          d="m724.2 521.63 243.77-0.21573 7.9819 133.97-250.89-0.43145z"
                          fill="transparent"
                          style="cursor:pointer;" />
                </g>
            <?php endif; ?>

            <!-- Porte (Activité 5) -->
            <?php if (in_array(505, $activites_selectionnees) && !in_array(505, $activites_reussies)): ?>
                <g id="porte" class="objet-enigme" data-activite="505">
                    <image id="image_porte"
                           x="1592.5" y="237.97"
                           width="257.49" height="838.37"
                           clip-path="url(#clip_porte)"
                           preserveAspectRatio="none"
                           xlink:href="<?= base_url('images/salle_5/porte_ouverte.svg') ?>" />
                    <rect class="piece-zone"
                          x="1592.5" y="237.97" width="257.49" height="838.37"
                          fill="transparent"
                          style="cursor:pointer;" />
                </g>
            <?php endif; ?>

            <!-- Fenêtre (Activité 7) -->
            <?php if (in_array(507, $activites_selectionnees) && !in_array(507, $activites_reussies)): ?>
                <g id="fenetre" class="objet-enigme" data-activite="507">
                    <image id="image_fenetre"
                           x="64" y="182" width="218" height="458"
                           clip-path="url(#clip_fenetre)"
                           preserveAspectRatio="none"
                           xlink:href="<?= base_url('images/salle_5/fenetre_ouverte.svg') ?>" />
                    <path class="piece-zone"
                          d="m68.949 182.44 213.56 48.814-2.4407 340.47-216 68.949h0.61017z"
                          fill="transparent"
                          style="cursor:pointer;" />
                </g>
            <?php endif; ?>

            <!-- Caméra (Activité 10) -->
            <?php if (in_array(510, $activites_selectionnees) && !in_array(510, $activites_reussies)): ?>
                <g id="camera" class="objet-enigme" data-activite="510">
                    <image id="image_camera"
                           clip-path="url(#clip_camera)"
                           preserveAspectRatio="none"
                           x="1577.1" y="89.952" width="232.99" height="113.9"
                           xlink:href="<?= base_url('images/salle_5/camera.svg') ?>" />
                    <rect class="piece-zone"
                          x="1577.1" y="89.952" width="232.99" height="113.9"
                          fill="transparent"
                          style="cursor:pointer;" />
                </g>
            <?php endif; ?>

            <!-- Post-it confidentiel (Activité 4) -->
            <?php if (in_array(504, $activites_selectionnees) && !in_array(504, $activites_reussies)): ?>
                <g id="post_it_conf" class="objet-enigme" data-activite="504">
                    <image id="image_post_it_conf"
                           clip-path="url(#clip_post_it_conf)"
                           preserveAspectRatio="none"
                           x="1400" y="518.82" width="73.347" height="84.566"
                           xlink:href="<?= base_url('images/salle_5/post_it_confidentiel.svg') ?>" />
                    <rect class="piece-zone"
                          x="1400.7" y="518.82" width="73.347" height="84.566"
                          fill="transparent"
                          style="cursor:pointer;" />
                </g>
            <?php endif; ?>

            <!-- Clé USB (Activité 2) -->
            <?php if (in_array(502, $activites_selectionnees) && !in_array(502, $activites_reussies)): ?>
                <g id="cle_usb" class="objet-enigme" data-activite="502">
                    <image id="image_cle_usb"
                           clip-path="url(#clip_cle_usb)"
                           preserveAspectRatio="none"
                           x="1228.4" y="701.76" width="63.855" height="21.573"
                           xlink:href="<?= base_url('images/salle_5/usb_anonyme.svg') ?>" />
                    <rect class="piece-zone"
                          x="1228.4" y="701.76" width="63.855" height="21.573"
                          fill="transparent"
                          style="cursor:pointer;" />
                </g>
            <?php endif; ?>

            <!-- Clé (Activité 3) -->
            <?php if (in_array(503, $activites_selectionnees) && !in_array(503, $activites_reussies)): ?>
                <g id="cle" class="objet-enigme" data-activite="503">
                    <image id="image_cle"
                           clip-path="url(#clip_cle)"
                           preserveAspectRatio="none"
                           x="1507.2" y="702.62" width="69.895" height="23.299"
                           xlink:href="<?= base_url('images/salle_5/cle.svg') ?>" />
                    <rect class="piece-zone"
                          x="1507.2" y="702.62" width="69.895" height="23.299"
                          fill="transparent"
                          style="cursor:pointer;" />
                </g>
            <?php endif; ?>

            <!-- Dossier (Activité 8) -->
            <?php if (in_array(508, $activites_selectionnees) && !in_array(508, $activites_reussies)): ?>
                <g id="dossier" class="objet-enigme" data-activite="508">
                    <image id="image_dossier"
                           clip-path="url(#clip_dossier)"
                           preserveAspectRatio="none"
                           x="620.95" y="610.29" width="68.17" height="95.783"
                           xlink:href="<?= base_url('images/salle_5/dossier.svg') ?>" />
                    <rect class="piece-zone"
                          x="620.95" y="610.29" width="68.17" height="95.783"
                          fill="transparent"
                          style="cursor:pointer;" />
                </g>
            <?php endif; ?>

            <!-- Carnet MDP (Activité 9) -->
            <?php if (in_array(509, $activites_selectionnees) && !in_array(509, $activites_reussies)): ?>
                <g id="carnet_mdp" class="objet-enigme" data-activite="509">
                    <image id="image_carnet_mdp"
                           clip-path="url(#clip_carnet_mdp)"
                           preserveAspectRatio="none"
                           x="328.13" y="825.2" width="115.93" height="106.17"
                           xlink:href="<?= base_url('images/salle_5/carnet_mdp.svg') ?>" />
                    <rect class="piece-zone"
                          x="328.13" y="825.2" width="115.93" height="106.17"
                          fill="transparent"
                          style="cursor:pointer;" />
                </g>
            <?php endif; ?>

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



