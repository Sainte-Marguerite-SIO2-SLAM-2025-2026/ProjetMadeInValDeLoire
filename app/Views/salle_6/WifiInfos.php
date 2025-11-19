<title>Wifi - Informations</title>
<?= link_tag(base_url() . "styles/salle_6/Wifi.css") ?>
</head>
<body>
<div class="container">
    <h1 class="titre-temp">Wifi - Quelle information rend ce WiFi sécurisé ?</h1>

    <!-- Bouton retour -->
    <?= anchor(base_url() . '/', "Projet Made in Val de Loire", [
            'class' => 'retour'
    ]); ?>

    <!-- Zone cliquable -->
    <div class="zone-cliquable" id="zoneCliquable"></div>

    <!-- Conteneur de la carte WiFi correcte (caché par défaut) -->
    <div class="cartes-container" id="cartesContainer" style="display: none;">
        <div class="cartes-wrapper">
            <div class="CarteWifi" id="CarteWifi">
                <div class="carte-contenu">
                    <?php if (isset($wifi)): ?>
                        <h3 class="wifi-nom info-selectionnable" data-info="nom" id="wifiNom">
                            <?= esc($wifi['nom']) ?>
                        </h3>
                        <p class="wifi-type info-selectionnable" data-info="type" id="wifiType">
                            <?= esc($wifi['type']) ?>
                        </p>
                        <p class="wifi-chiffrement info-selectionnable" data-info="chiffrement" id="wifiChiffrement">
                            <?= esc($wifi['chiffrement']) ?>
                        </p>
                    <?php else: ?>
                        <!-- Valeurs par défaut si pas de données -->
                        <h3 class="wifi-nom info-selectionnable" data-info="nom" id="wifiNom">WiFi-1</h3>
                        <p class="wifi-type info-selectionnable" data-info="type" id="wifiType">Privé</p>
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
            <?= anchor(base_url() . 'Salle6/CompleteWifi', "Suivant", [
                    'id' => 'btnSuivant',
                    'class' => 'btn-suivant',
                    'style' => 'display: none;',
                    "content" => "Suivant"
            ]);?>

            <!-- Bouton valider -->
            <?= form_button([
                    "content" => "Valider",
                    "id" => "btnValider",
                    "class" => "btn-valider",
                    "style" => "display: none;"
            ]) ?>

        </div>
    </div>
</div>

<?= script_tag('js/salle_6/wifiInfos.js') ?>
