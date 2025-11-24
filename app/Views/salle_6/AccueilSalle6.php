<title>Salle n°6</title>
<?= link_tag(base_url() . "styles/salle_6/accueilSalle6.css") ?>
<div class="container">
    <h1 class="titre-temp">Salle n°6</h1>
    <!-- Bulle de dialogue -->
    <div class="bulle">
        <p class="texte-bulle"><?= $intitule ?></p>
    </div>
    <!-- Mascotte -->
    <?=anchor("#",img([
            'src' => 'images/commun/mascotte/mascotte_face.svg',
            'alt' => 'Mascotte',
            'class' => 'mascotte',
            'data-hover' => base_url() . 'images/commun/mascotte/mascotte_exclamee.svg',
            'data-default' => 'images/commun/mascotte/mascotte_face.svg'
    ]), ['id'=>"open-modal"]) ?>

    <!-- zone train -->
    <?= anchor(base_url() . 'Salle6/Enigme', ' ', ['class' => 'zone-cliquable']); ?>

    <!-- Bouton retour -->
    <?= anchor(base_url() . '/', img(['src' => 'images/commun/btn_retour/home_icone_6.webp',
            'alt' => 'Retour',
            'class' => 'retour']), [
            'class' => 'retour'
    ]); ?>

    <!-- Modal -->
    <div id="modal-mascotte" class="modal">
        <div class="modal-content">
            <svg width="100%" height="100%" viewBox="0 0 1920 1080" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet">
                <path id="bulle" class="cls-134" d="m1438.1 64.948v616.45l80.248 62.251h-1445.7c-11.089 0-20.071-9.4722-20.071-21.154v-657.54c0-11.682 8.9818-21.154 20.071-21.154h1345.4c11.089 0 20.07 9.4722 20.07 21.154z" fill="#fff" stroke-width="1.1537"/>

                <rect id="zone-texte" x="83.06" y="72.965" width="1328.2" height="502.03" fill-opacity="0" stroke-width="1.0028"/>

                <!-- Texte d'explication -->
                <foreignObject x="83.06" y="72.965" width="1328.2" height="502.03">
                    <div xmlns="http://www.w3.org/1999/xhtml" class="modal-texte">
                        Te voilà dans le grenier, clique sur le train pour commencer les énigmes. Explore bien chaque recoin et résous les mystères qui t'attendent !
                    </div>
                </foreignObject>

                <g id="bouton-commencer" transform="matrix(-1.1326 0 0 1.1752 2050.6 -106.86)" fill="#e86f04" fill-opacity=".93" style="cursor: pointer;">
                    <polygon id="btn-valider" class="cls-160" points="1351.6 670.99 851.56 670.99 861.56 600.99 1361.6 600.99" fill="#e86f04" fill-opacity=".93"/>
                </g>

                <!-- Texte du bouton -->
                <text x="800" y="660" font-family="Arial, sans-serif" font-size="45" font-weight="bold" fill="white" text-anchor="middle" pointer-events="none">
                    J'ai compris !
                </text>

                <rect id="mascotte" x="1524.8" y="528.53" width="390.55" height="547.23" fill-opacity="0" stroke-width=".26458"/>
            </svg>
            <!-- Image de la mascotte injectée par JS -->
            <img id="mascotte-modal-img" src="<?= base_url() ?>images/commun/mascotte/mascotte_profil.svg" alt="Mascotte" />
        </div>
    </div>

</div>

<?= script_tag('js/salle_6/accueilSalle6.js') ?>