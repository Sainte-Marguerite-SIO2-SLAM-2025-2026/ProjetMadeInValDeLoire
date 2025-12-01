<title>Wifi - Informations</title>
<?= link_tag(base_url() . "styles/salle_6/Wifi.css") ?>
</head>
<body>
<div class="container">
    <h1 class="titre-temp">Wifi - Quelle information rend ce WiFi sécurisé ?</h1>

    <!-- Bouton retour -->
    <?= anchor(base_url() . '/Salle6/RevenirAccueil', img(['src' => 'images/commun/btn_retour/home_icone_6.webp',
            '  alt' => 'Retour',
            'class' => 'retour']), [
            'class' => 'retour'
    ]); ?>

    <!-- Zone cliquable -->
    <div class="zone-cliquable" id="zoneCliquable"></div>

    <!-- Formulaire pour envoyer le choix d'information -->
    <?= form_open(base_url() . 'Salle6/CompleteWifi', [
            'id' => 'formWifiInfo',
            'data-explication-url' => base_url() . 'Salle6/Explication'
    ]) ?>
    <?= csrf_field() ?>
    <?= form_input(["type" => "hidden",
            "name" => "info_selectionnee",
            "id" => "infoSelectionneeInput",
            "value" => ""]) ?>
    <?= form_input(["type" => "hidden",
            "name" => "wifi_numero",
            "value" => isset($wifi_numero) ? $wifi_numero : ""]) ?>
    <?= form_input(["type" => "hidden",
            "name" => "activite_numero",
            "value" => isset($activite_numero) ? $activite_numero : "1"]) ?>

    <!-- Conteneur de la carte WiFi correcte (caché par défaut) -->
    <div class="cartes-container" id="cartesContainer">
        <div class="cartes-wrapper">
            <div class="CarteWifi" id="CarteWifi">
                <div class="carte-contenu">
                    <?php if (isset($wifi)): ?>
                        <h3 class="wifi-nom info-selectionnable"
                            data-info="nom"
                            id="wifiNom">
                            <?= esc($wifi['nom']) ?>
                        </h3>
                        <p class="wifi-type info-selectionnable"
                           data-info="public_prive"
                           id="wifiType">
                            <?= $wifi['public'] == 1 ? 'Public' : 'Privé' ?>
                        </p>
                        <p class="wifi-chiffrement info-selectionnable"
                           data-info="chiffrement"
                           id="wifiChiffrement">
                            <?= esc($wifi['chiffrement']) ?>
                        </p>
                    <?php else: ?>
                        <!-- Valeurs par défaut si pas de données -->
                        <h3 class="wifi-nom info-selectionnable" data-info="nom" id="wifiNom">WiFi-1</h3>
                        <p class="wifi-type info-selectionnable" data-info="public_prive" id="wifiType">Privé</p>
                        <p class="wifi-chiffrement info-selectionnable" data-info="chiffrement" id="wifiChiffrement">
                            WPA3</p>
                    <?php endif; ?>
                </div>
            </div>
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

            <!-- Bouton valider -->
            <?= form_button([
                    "content" => "Valider",
                    "id" => "btnValider",
                    "class" => "btn-valider",
                    "style" => "display: none;"
            ]) ?>

        </div>
    </div>

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

<!-- Passer la zone correcte au JavaScript -->
<script>
    const zoneCorrecte = '<?= isset($zone_correcte) ? esc($zone_correcte) : 'chiffrement' ?>';
</script>
<?= script_tag('js/salle_6/wifiInfos.js') ?>
<?= script_tag('js/salle_6/mascotteHover.js') ?>
