<title>Wifi</title>
<?= link_tag(base_url() . "styles/salle_6/Wifi.css") ?>
</head>
<body>
<div class="container">
    <h1 class="titre-temp">Wifi</h1>

    <!-- Bouton retour -->
    <?= anchor(base_url() . '/Salle6/RevenirAccueil', img(['src' => 'images/commun/btn_retour/home_icone_6.webp',
            '  alt' => 'Retour',
            'class' => 'retour']), [
            'class' => 'retour'
    ]); ?>

    <!-- Zone cliquable -->
    <div class="zone-cliquable" id="zoneCliquable"></div>

    <!-- Formulaire pour envoyer le choix -->
    <?= form_open(base_url() . 'wifi/validerCarte', ['id' => 'formWifi']) ?>
    <?= csrf_field() ?>
    <?= form_input(["type" => "hidden",
            "name" => "wifi_numero",
            "id" => "wifiIdInput",
            "value" => ""]) ?>

    <!-- Conteneur des cartes WiFi (caché par défaut) -->
    <div class="cartes-container" id="cartesContainer">
        <div class="cartes-wrapper">
            <?php if (isset($wifis) && !empty($wifis)): ?>
                <?php foreach ($wifis as $wifi): ?>
                    <div class="CarteWifi"
                         data-wifi-numero="<?= esc($wifi['wifi_numero']) ?>"
                         data-est-correct="<?= esc($wifi['bonne_reponse']) ?>">
                        <div class="carte-contenu">
                            <h3 class="wifi-nom info-selectionnable" data-info="nom">
                                <?= esc($wifi['nom']) ?>
                            </h3>
                            <p class="wifi-type info-selectionnable" data-info="type">
                                <?= $wifi['public'] == 1 ? 'Public' : 'Privé' ?>
                            </p>
                            <p class="wifi-chiffrement info-selectionnable" data-info="chiffrement">
                                <?= esc($wifi['chiffrement']) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>

            <!-- Version statique si pas de données -->
            <div class="cartes-container" id="cartesContainer">
                <div class="cartes-wrapper">
                    <div class="CarteWifi" data-wifi-id="1">
                        <div class="carte-contenu">
                            <h3 class="wifi-nom info-selectionnable" data-info="nom">FreeWifi</h3>
                            <p class="wifi-type info-selectionnable" data-info="type">Public</p>
                            <p class="wifi-chiffrement info-selectionnable" data-info="chiffrement">WPA2</p>
                        </div>
                    </div>
                    <div class="CarteWifi" data-wifi-id="2">
                        <div class="carte-contenu">
                            <h3 class="wifi-nom info-selectionnable" data-info="nom">Livebox-A3F2</h3>
                            <p class="wifi-type info-selectionnable" data-info="type">Privé</p>
                            <p class="wifi-chiffrement info-selectionnable" data-info="chiffrement">WPA3</p>
                        </div>
                    </div>
                    <div class="CarteWifi" data-wifi-id="3">
                        <div class="carte-contenu">
                            <h3 class="wifi-nom info-selectionnable" data-info="nom">SFR-Guest</h3>
                            <p class="wifi-type info-selectionnable" data-info="type">Public</p>
                            <p class="wifi-chiffrement info-selectionnable" data-info="chiffrement">WPA2-PSK</p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <!-- Conteneur pour aligner résultat et bouton horizontalement -->
            <div class="resultat-et-bouton">
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
        </div>


        <!-- Bouton valider -->
        <?= form_button([
                "content" => "Valider",
                "id" => "btnValider",
                "class" => "btn-valider",
                "style" => "display: none;"
        ]) ?>

        <?= form_close() ?>

    </div>

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

<!-- Bouton d'accueil (caché par défaut, affiché en cas d'échec) -->
<?= anchor(base_url() . "/", "Revenir à l'accueil", [
        "id" => "btnAccueil",
        "class" => "btn-valider"
]) ?>

<?= script_tag('js/salle_6/wifiCartes.js') ?>
<?= script_tag('js/salle_6/mascotteHover.js') ?>
