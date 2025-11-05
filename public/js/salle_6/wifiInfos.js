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