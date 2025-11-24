<title>Wifi</title>
<?= link_tag(base_url() . "styles/salle_6/Wifi.css") ?>
</head>
<body>
<div class="container">
    <h1 class="titre-temp">Wifi</h1>

    <!-- Bouton retour -->
    <?= anchor(base_url() . '/', img(['src' => 'images/commun/btn_retour/home_icone_6.webp',
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
                                WiFi-<?= esc($wifi['wifi_numero']) ?>
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

    </div>

    <!-- Bouton d'accueil (caché par défaut, affiché en cas d'échec) -->
    <?= anchor(base_url() . "/", "Revenir à l'accueil", [
            "id" => "btnAccueil",
            "class" => "btn-valider"
    ]) ?>

<?= script_tag('js/salle_6/wifiCartes.js') ?>