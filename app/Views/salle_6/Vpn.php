<title>VPN</title>
<?= link_tag(base_url() . "styles/salle_6/Vpn.css") ?>
</head>
<body>
<div class="container">
    <h1 class="titre-temp">Sélectionnez l'affirmation vraie sur les VPN</h1>

    <!-- Bouton retour -->
    <?= anchor(base_url() . '/Salle6/RevenirAccueil', img(['src' => 'images/commun/btn_retour/home_icone_6.webp',
            '  alt' => 'Retour',
            'class' => 'retour']), [
            'class' => 'retour'
    ]); ?>

    <!-- Zone cliquable -->
    <div class="zone-cliquable" id="zoneCliquable"></div>

    <!-- Formulaire pour envoyer le choix -->
    <?= form_open(base_url() . 'Salle6/CompleteVpn', [
            'id' => 'formVpn',
            'data-explication-url' => base_url() . 'Salle6/Explication'
    ]) ?>
    <?= csrf_field() ?>
    <?= form_input(["type" => "hidden",
            "name" => "vpn_numero",
            "id" => "vpnIdInput",
            "value" => ""]) ?>
    <?= form_input(["type" => "hidden",
            "name" => "activite_numero",
            "value" => "2"]) ?>

    <!-- Conteneur des cartes VPN (caché par défaut) -->
    <div class="cartes-container" id="cartesContainer">
        <div class="cartes-wrapper">
            <?php if (isset($vpns) && !empty($vpns)): ?>
                <?php foreach ($vpns as $vpn): ?>
                    <div class="CarteVpn"
                         data-vpn-numero="<?= esc($vpn['vpn_numero']) ?>"
                         data-est-correct="<?= esc($vpn['bonne_reponse']) ?>">
                        <div class="carte-contenu">
                            <div class="texte-overlay">
                                <p class="vpn-libelle">
                                    <?= esc($vpn['libelle']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Version statique si pas de données -->
                <div class="CarteVpn" data-vpn-numero="1" data-est-correct="1">
                    <div class="carte-contenu">
                        <div class="texte-overlay">
                            <p class="vpn-libelle">Un VPN chiffre votre connexion internet</p>
                        </div>
                    </div>
                </div>
                <div class="CarteVpn" data-vpn-numero="2" data-est-correct="0">
                    <div class="carte-contenu">
                        <div class="texte-overlay">
                            <p class="vpn-libelle">Un VPN ralentit toujours votre connexion de 80%</p>
                        </div>
                    </div>
                </div>
                <div class="CarteVpn" data-vpn-numero="3" data-est-correct="0">
                    <div class="carte-contenu">
                        <div class="texte-overlay">
                            <p class="vpn-libelle">Les VPN sont illégaux en France</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Div de résultat (cachée par défaut) -->
        <div class="resultat-container" id="resultatContainer" style="display: none;">
            <p id="messageResultat"></p>
        </div>

        <!-- Bouton suivant (caché par défaut) -->
        <?= form_submit("btnSuivant", "Suivant", [
                'id' => 'btnSuivant',
                'class' => 'btn-suivant',
                'style' => 'display: none;',
                "content" => "Suivant"
        ]) ?>
    </div>

    <!-- Bouton valider -->
    <?= form_button([
            "content" => "Valider",
            "id" => "btnValider",
            "class" => "btn-valider",
            "style" => "display: none;"
    ]) ?>

    <?= form_close() ?>

    <!-- Bulle de dialogue SVG -->
    <div class="bulle" style="display: none;">
        <svg width="400" height="225" version="1.1" viewBox="0 0 400 225" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <style>
                    .cls-134 {
                        fill: #fff;
                    }
                    .cls-168 {
                        isolation: isolate;
                    }
                </style>
            </defs>
            <g class="cls-168">
                <g id="présentation-de-la-salle" transform="matrix(1.3745,0,0,1.7107,-152.22,-253.32)">
                    <path class="cls-134" d="m384.97 152.03v115.39l15.882 11.652h-286.14c-2.1947 0-3.9722-1.773-3.9722-3.9595v-123.08c0-2.1866 1.7776-3.9595 3.9722-3.9595h266.28c2.1947 0 3.9722 1.773 3.9722 3.9595z" stroke="#28160d" stroke-miterlimit="10" stroke-width=".22206"/>

                    <!-- Zone de texte -->
                    <foreignObject x="128.25" y="162.18" width="247.98" height="102.61">
                        <div xmlns="http://www.w3.org/1999/xhtml" style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">
                            <p class="bulle-texte-container" style="margin: 0; text-align: center; padding: 10px;"><?= $intitule ?></p>
                        </div>
                    </foreignObject>
                </g>
            </g>
        </svg>
    </div>

    <!-- Mascotte avec anchor -->
    <?= anchor('#', img([
            'src' => base_url() . 'images/commun/mascotte/mascotte_face.svg',
            'alt' => 'Mascotte',
            'class' => 'mascotte',
            'id' => 'mascotte',
            'data-hover' => base_url() . 'images/commun/mascotte/mascotte_exclamee.svg',
            'data-default' => base_url() . 'images/commun/mascotte/mascotte_face.svg'
    ]), [
            'id' => 'mascotteLink',
            'class' => 'mascotte-link'
    ]); ?>
</div>

<?= script_tag('js/salle_6/Vpn.js') ?>