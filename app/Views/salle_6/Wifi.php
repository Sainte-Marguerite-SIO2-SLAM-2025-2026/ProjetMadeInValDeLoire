<title>Wifi</title>
<?= link_tag(base_url()."styles/salle_6/Wifi.css") ?>
</head>
<body>
<div class="container">
    <h1 class="titre-temp">Wifi</h1>

    <!-- Bouton retour -->
    <?= anchor(base_url() . '/',"Projet Made in Val de Loire", [
            'class' => 'retour'
    ]);?>

    <!-- Zone cliquable -->
    <div class="zone-cliquable" id="zoneCliquable"></div>

    <!-- Formulaire pour envoyer le choix -->
    <?= form_open('wifi/validerCarte', ['id' => 'formWifi']) ?>
    <?= csrf_field() ?>
    <?= form_input([ "type" => "hidden",
            "name" => "wifi_id",
            "id" => "wifiIdInput",
            "value" => "'' " ])?>

    <!--     Conteneur des cartes WiFi (caché par défaut) -->
    <!--    <div class="cartes-container" id="cartesContainer">-->
    <!--        --><?php //foreach($wifis as $wifi): ?>
    <!--            <div class="CarteWifi" data-wifi-id="--><?php //= esc($wifi['id']) ?><!--">-->
    <!--                <div class="carte-contenu">-->
    <!--                    <h3 class="wifi-nom">--><?php //= esc($wifi['nom']) ?><!--</h3>-->
    <!--                    <p class="wifi-type">--><?php //= esc($wifi['type']) ?><!--</p>-->
    <!--                    <p class="wifi-chiffrement">--><?php //= esc($wifi['chiffrement']) ?><!--</p>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        --><?php //endforeach; ?>
    <!--    </div>-->

    <!-- Conteneur des cartes WiFi (caché par défaut) -->
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
        <!-- Div de résultat (cachée par défaut) -->
        <div class="resultat-container" id="resultatContainer" style="display: none;">
            <p id="messageResultat"></p>
        </div>
        <!-- Bouton suivant (caché par défaut) -->
        <?= anchor(base_url().'Salle6/wifi/resultat', 'Suivant', [
                'id' => 'btnSuivant',
                'class' => 'btn-suivant',
                'style' => 'display: none;'
        ]) ?>
    </div>


    <!-- Bouton valider -->
    <?= form_input([
            "type" => "submit",
            "id" => "btnValider",
            "class" => "btn-valider",
            "style" => "display: none;",
            "value" => "Valider"
    ]) ?>

    <?= form_close() ?>





</div>


<!-- Bouton d'accueil (caché par défaut, affiché en cas d'échec) -->
<?= anchor(base_url()."/", "Revenir à l'accueil", [
        "id" => "btnAccueil",
        "class" => "btn-valider"
]) ?>

<?= script_tag('js/salle6.js') ?>