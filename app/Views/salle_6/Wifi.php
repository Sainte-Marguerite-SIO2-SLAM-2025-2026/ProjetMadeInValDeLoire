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

    <!-- Conteneur des cartes WiFi (caché par défaut) -->
    <div class="cartes-container" id="cartesContainer">
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

    <!-- Bouton valider (caché par défaut, affiché en cas de réussite) -->
    <?= anchor(base_url()."/WifiResultatCarte", "Valider", [
            "id" => "btnAccueil",
            "class" => "btn-valider"
    ]) ?>

</div>

<?= script_tag('js/salle6.js') ?>