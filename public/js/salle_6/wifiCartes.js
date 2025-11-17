document.addEventListener('DOMContentLoaded', function() {
    const zoneCliquable = document.getElementById('zoneCliquable');
    const cartesContainer = document.getElementById('cartesContainer');
    const btnValider = document.getElementById('btnValider');
    const btnSuivant = document.getElementById('btnSuivant');
    const wifiIdInput = document.getElementById('wifiIdInput');
    const resultatContainer = document.getElementById('resultatContainer');
    const messageResultat = document.getElementById('messageResultat');
    const formWifi = document.getElementById('formWifi');
    const cartesWifi = document.querySelectorAll('.CarteWifi');

    let carteSelectionnee = null;

    // Vérification des éléments requis
    if (!zoneCliquable || !cartesContainer || !btnValider) {
        console.warn('Éléments requis non trouvés');
        return;
    }

    // Gestion du clic sur la zone cliquable
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

    // Sélection d'une carte WiFi
    cartesWifi.forEach(function(carte) {
        carte.addEventListener('click', function(e) {
            e.stopPropagation(); // Empêche la propagation du clic

            // Retirer la sélection précédente
            cartesWifi.forEach(c => c.classList.remove('carte-selectionnee'));

            // Ajouter la sélection actuelle
            this.classList.add('carte-selectionnee');

            // Récupérer le numéro du WiFi sélectionné
            carteSelectionnee = this.getAttribute('data-wifi-numero');

            // Mettre à jour le champ caché
            if (wifiIdInput) {
                wifiIdInput.value = carteSelectionnee;
            }

            // Afficher le bouton valider
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

        // Récupérer si la carte sélectionnée est correcte
        const carteElement = document.querySelector(`.CarteWifi[data-wifi-numero="${carteSelectionnee}"]`);
        const estCorrect = carteElement ? carteElement.getAttribute('data-est-correct') === '1' : false;

        // Afficher le résultat
        if (resultatContainer && messageResultat) {
            resultatContainer.style.display = 'block';

            if (estCorrect) {
                messageResultat.textContent = '✓ Bonne réponse ! Vous avez sélectionné le WiFi sécurisé.';
                //messageResultat.style.color = '#2ecc71';
                carteElement.classList.add('carte-correcte');
            } else {
                messageResultat.textContent = '✗ Mauvaise réponse. Ce n\'est pas le WiFi le plus sécurisé.';
                //messageResultat.style.color = '#e74c3c';
                carteElement.classList.add('carte-incorrecte');

                // Mettre en évidence la bonne carte
                const bonneCarteElement = document.querySelector('.CarteWifi[data-est-correct="1"]');
                if (bonneCarteElement) {
                    bonneCarteElement.classList.add('carte-correcte');
                }
            }
        }

        // Masquer le bouton valider et afficher le bouton suivant
        btnValider.style.display = 'none';
        if (btnSuivant) {
            btnSuivant.style.display = 'block';
        }

        // Désactiver la sélection des cartes
        cartesWifi.forEach(function(carte) {
            carte.style.pointerEvents = 'none';
            carte.style.opacity = '0.7';
        });

        // Si correct, sauvegarder les données pour la page résultat
        if (estCorrect && carteElement) {
            const wifiNom = carteElement.querySelector('.wifi-nom').textContent;
            const wifiType = carteElement.querySelector('.wifi-type').textContent;
            const wifiChiffrement = carteElement.querySelector('.wifi-chiffrement').textContent;

            sessionStorage.setItem('wifiCorrect', JSON.stringify({
                nom: wifiNom,
                type: wifiType,
                chiffrement: wifiChiffrement
            }));
        }
    });

    // Gestion du bouton Suivant (soumission du formulaire)
    if (btnSuivant && formWifi) {
        btnSuivant.addEventListener('click', function(e) {
            e.preventDefault();

            if (carteSelectionnee && wifiIdInput) {
                wifiIdInput.value = carteSelectionnee;
                formWifi.submit();
            }
        });
    }
});