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

    // Éléments pour la mascotte et la bulle
    const mascotte = document.querySelector('.mascotte');
    const bulle = document.querySelector('.bulle');
    const bulleTexte = document.querySelector('.bulle-texte-container p');

    // Textes pour la bulle
    const texteInitial = bulleTexte ? bulleTexte.textContent : '';
    const texteCartesAffichees = 'Sélectionnez le WiFi qui vous semble le plus sécurisé !';

    let carteSelectionnee = null;
    let bulleVisible = true; // La bulle est visible au départ

    // Vérification des éléments requis
    if (!zoneCliquable || !cartesContainer || !btnValider) {
        console.warn('Éléments requis non trouvés');
        return;
    }

    // Gestion du clic sur la mascotte
    if (mascotte && bulle) {
        mascotte.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Toggle de la visibilité de la bulle
            bulleVisible = !bulleVisible;
            bulle.style.display = bulleVisible ? 'block' : 'none';
        });

        // Ajouter un style pour que la mascotte ait un curseur pointer
        mascotte.style.cursor = 'pointer';
    }

    // Gestion du clic sur la zone cliquable
    zoneCliquable.addEventListener('click', function() {
        if (cartesContainer.style.display === 'none' || cartesContainer.style.display === '') {
            cartesContainer.style.display = 'flex';

            // Changer le texte de la bulle quand les cartes sont affichées
            if (bulleTexte) {
                bulleTexte.textContent = texteCartesAffichees;
            }

            if (carteSelectionnee) {
                btnValider.style.display = 'block';
            }
        } else {
            cartesContainer.style.display = 'none';
            btnValider.style.display = 'none';

            // Restaurer le texte initial quand les cartes sont cachées
            if (bulleTexte) {
                bulleTexte.textContent = texteInitial;
            }
        }
    });

    // Sélection d'une carte WiFi
    cartesWifi.forEach(function(carte) {
        carte.addEventListener('click', function(e) {
            e.stopPropagation();

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
                carteElement.classList.add('carte-correcte');
            } else {
                messageResultat.textContent = '✗ Mauvaise réponse. Ce n\'est pas le WiFi le plus sécurisé.';
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