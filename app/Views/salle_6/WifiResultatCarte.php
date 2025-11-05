<title>Wifi - Résultat</title>
<?= link_tag(base_url()."styles/salle_6/Wifi.css") ?>
</head>
<body>
<div class="container">
    <h1 class="titre-temp">Wifi - Résultat</h1>

    <!-- Bouton retour -->
    <?= anchor(base_url() . '/',"Projet Made in Val de Loire", [
            'class' => 'retour'
    ]);?>

    <!-- Zone cliquable -->
    <div class="zone-cliquable" id="zoneCliquable"></div>

    <!-- Conteneur de la carte WiFi correcte (caché par défaut) -->
    <div class="cartes-container" id="cartesContainer" style="display: none;">
        <div class="cartes-wrapper">
            <div class="CarteWifi" data-wifi-id="2">
                <div class="carte-contenu">
                    <h3 class="wifi-nom" id="wifiNom">Livebox-A3F2</h3>
                    <p class="wifi-type" id="wifiType">Privé</p>
                    <p class="wifi-chiffrement" id="wifiChiffrement">WPA3</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var zoneCliquable = document.getElementById('zoneCliquable');
        var cartesContainer = document.getElementById('cartesContainer');

        // Récupérer les données du WiFi depuis sessionStorage
        var wifiCorrectData = sessionStorage.getItem('wifiCorrect');

        if (wifiCorrectData) {
            var wifi = JSON.parse(wifiCorrectData);

            // Mettre à jour les informations de la carte
            document.getElementById('wifiNom').textContent = wifi.nom;
            document.getElementById('wifiType').textContent = wifi.type;
            document.getElementById('wifiChiffrement').textContent = wifi.chiffrement;
        }

        // Gérer le clic sur la zone cliquable
        if (zoneCliquable && cartesContainer) {
            zoneCliquable.addEventListener('click', function() {
                if (cartesContainer.style.display === 'none' || cartesContainer.style.display === '') {
                    cartesContainer.style.display = 'flex';
                } else {
                    cartesContainer.style.display = 'none';
                }
            });
        }
    });
</script>

<?= script_tag('js/salle6.js') ?>
