document.addEventListener('DOMContentLoaded', function() {
    const zoneCliquable = document.getElementById('zoneCliquable');
    const cartesContainer = document.getElementById('cartesContainer');
    const btnValider = document.getElementById('btnValider');
    const btnSuivant = document.getElementById('btnSuivant');
    const vpnIdInput = document.getElementById('vpnIdInput');
    const resultatContainer = document.getElementById('resultatContainer');
    const messageResultat = document.getElementById('messageResultat');
    const formVpn = document.getElementById('formVpn');
    const cartesVpn = document.querySelectorAll('.CarteVpn');

    let carteSelectionnee = null;
    let reponseCorrecte = false; // Variable pour stocker si la réponse est correcte

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

    // Sélection d'une carte VPN
    cartesVpn.forEach(function(carte) {
        carte.addEventListener('click', function(e) {
            e.stopPropagation();

            // Retirer la sélection précédente
            cartesVpn.forEach(c => c.classList.remove('carte-selectionnee'));

            // Ajouter la sélection actuelle
            this.classList.add('carte-selectionnee');

            // Récupérer le numéro du VPN sélectionné
            carteSelectionnee = this.getAttribute('data-vpn-numero') || this.getAttribute('data-vpn-id');

            console.log('Carte sélectionnée:', carteSelectionnee);

            // Mettre à jour le champ caché
            if (vpnIdInput && carteSelectionnee) {
                vpnIdInput.value = carteSelectionnee;
                console.log('Valeur du champ caché:', vpnIdInput.value);
            }

            // Afficher le bouton valider
            btnValider.style.display = 'block';
        });
    });

    // Gestion du clic sur le bouton Valider
    btnValider.addEventListener('click', function(e) {
        e.preventDefault();

        console.log('Validation - carte sélectionnée:', carteSelectionnee);
        console.log('Validation - valeur input:', vpnIdInput ? vpnIdInput.value : 'input non trouvé');

        if (!carteSelectionnee) {
            alert('Veuillez sélectionner une affirmation');
            return;
        }

        // Récupérer si la carte sélectionnée est correcte
        let carteElement = document.querySelector(`.CarteVpn[data-vpn-numero="${carteSelectionnee}"]`);
        if (!carteElement) {
            carteElement = document.querySelector(`.CarteVpn[data-vpn-id="${carteSelectionnee}"]`);
        }

        const estCorrect = carteElement ? carteElement.getAttribute('data-est-correct') === '1' : false;
        reponseCorrecte = estCorrect; // Stocker le résultat

        console.log('Carte élément trouvé:', carteElement);
        console.log('Est correct:', estCorrect);

        // Afficher le résultat
        if (resultatContainer && messageResultat) {
            resultatContainer.style.display = 'block';

            if (estCorrect) {
                messageResultat.textContent = '✓ Bonne réponse ! Cette affirmation sur les VPN est correcte.';
                carteElement.classList.add('carte-correcte');
            } else {
                messageResultat.textContent = '✗ Mauvaise réponse. Cette affirmation sur les VPN est incorrecte.';
                carteElement.classList.add('carte-incorrecte');

                // Mettre en évidence la bonne carte
                const bonneCarteElement = document.querySelector('.CarteVpn[data-est-correct="1"]');
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
        cartesVpn.forEach(function(carte) {
            carte.style.pointerEvents = 'none';
            carte.style.opacity = '0.7';
        });
    });

    // Gestion du bouton Suivant
    if (btnSuivant) {
        btnSuivant.addEventListener('click', function(e) {
            e.preventDefault();

            if (carteSelectionnee && vpnIdInput) {
                vpnIdInput.value = carteSelectionnee;
                // Toujours soumettre le formulaire, le contrôleur vérifiera la réponse
                formVpn.submit();
            }
        });
    }
});