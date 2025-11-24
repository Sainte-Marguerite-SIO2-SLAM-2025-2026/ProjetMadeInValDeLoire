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
                            WiFi-<?= esc($wifi['numero']) ?>
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
</div>

<!-- Passer la zone correcte au JavaScript -->
<script>
    const zoneCorrecte = '<?= isset($zone_correcte) ? esc($zone_correcte) : 'chiffrement' ?>';
</script>
<?= script_tag('js/salle_6/wifiInfos.js') ?>