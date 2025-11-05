document.addEventListener('DOMContentLoaded', function() {
    var zoneCliquable = document.getElementById('zoneCliquable');
    var cartesContainer = document.getElementById('cartesContainer');
    var btnValider = document.getElementById('btnValider');
    var btnSuivant = document.getElementById('btnSuivant');
    var wifiIdInput = document.getElementById('wifiIdInput');
    var resultatContainer = document.getElementById('resultatContainer');
    var messageResultat = document.getElementById('messageResultat');
    var cartes = document.querySelectorAll('.CarteWifi');
    var carteSelectionnee = null;
    var formWifi = document.getElementById('formWifi');

    // ID du WiFi correct (Livebox-A3F2)
    var wifiCorrectId = '2';

    if (!zoneCliquable || !cartesContainer || !btnValider) {
        console.warn('Éléments requis non trouvés');
        return;
    }

    zoneCliquable.addEventListener('click', function() {
        if (cartesContainer.style.display === 'none' || cartesContainer.style.display === '') {
            cartesContainer.style.display = 'flex';
            if (carteSelectionnee) {
                btnValider.style.display = 'block';
            }
        } else {
            cartesContainer.style.display = 'none';
            btnValider.style.display = 'none';
        }
    });

    // Sélection d'une carte
    cartes.forEach(function(carte) {
        carte.addEventListener('click', function(e) {
            cartes.forEach(function(c) {
                c.classList.remove('carte-selectionnee');
            });

            this.classList.add('carte-selectionnee');
            carteSelectionnee = this.getAttribute('data-wifi-id');
            wifiIdInput.value = carteSelectionnee;
            btnValider.style.display = 'block';
        });
    });

    // Gestion du clic sur le bouton Valider
    btnValider.addEventListener('click', function(e) {
        e.preventDefault();

        if (!carteSelectionnee) {
            alert('Veuillez sélectionner un WiFi');
            return;
        }

        // Vérifier si la réponse est correcte
        var estCorrect = (carteSelectionnee === wifiCorrectId);

        // Afficher le résultat
        resultatContainer.style.display = 'block';

        if (estCorrect) {
            messageResultat.textContent = '✓ Bonne réponse ! Le Livebox-A3F2 est le WiFi sécurisé.';
            resultatContainer.style.backgroundImage = 'url("' + '<?= base_url("images/salle6/bandeRouge.svg") ?>' + '")';
        } else {
            messageResultat.textContent = '✗ Mauvaise réponse. Le WiFi correct est le Livebox-A3F2 (Privé, WPA3).';
            resultatContainer.style.backgroundImage = 'url("' + '<?= base_url("images/salle6/bandeRouge.svg") ?>' + '")';   //a revérif
        }

        // Masquer le bouton valider et afficher le bouton suivant
        btnValider.style.display = 'none';
        btnSuivant.style.display = 'block';

        // Désactiver la sélection des cartes
        cartes.forEach(function(carte) {
            carte.style.pointerEvents = 'none';
            carte.style.opacity = '0.7';
        });
    });
});