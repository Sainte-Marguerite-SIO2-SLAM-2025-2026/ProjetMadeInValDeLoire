document.addEventListener('DOMContentLoaded', function() {
    const zoneCliquable = document.getElementById('zoneCliquable');
    const cartesContainer = document.getElementById('cartesContainer');
    const btnValider = document.getElementById('btnValider');
    const btnSuivant = document.getElementById('btnSuivant');
    const resultatContainer = document.getElementById('resultatContainer');
    const messageResultat = document.getElementById('messageResultat');

    // Pour désactiver le hover :
    document.getElementById('CarteWifi').classList.add('no-hover');

    let infoSelectionnee = null;

    // Récupérer les données du WiFi depuis sessionStorage
    const wifiCorrectData = sessionStorage.getItem('wifiCorrect');

    if (wifiCorrectData) {
        const wifi = JSON.parse(wifiCorrectData);

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

                // Rendre les informations cliquables
                const infosSelectionnables = document.querySelectorAll('.info-selectionnable');
                infosSelectionnables.forEach(info => {
                    info.classList.add('info-cliquable');
                });

                // Afficher le bouton valider si une info est déjà sélectionnée
                if (infoSelectionnee && btnValider) {
                    btnValider.style.display = 'block';
                }
            } else {
                cartesContainer.style.display = 'none';
                if (btnValider) {
                    btnValider.style.display = 'none';
                }
            }
        });
    }

    // Sélection d'une information (nom, type, chiffrement)
    const infosSelectionnables = document.querySelectorAll('.info-selectionnable');
    infosSelectionnables.forEach(function(info) {
        info.addEventListener('click', function(e) {
            e.stopPropagation();

            // Retirer la sélection précédente
            infosSelectionnables.forEach(i => i.classList.remove('info-selectionnee'));

            // Ajouter la sélection actuelle
            this.classList.add('info-selectionnee');

            // Récupérer le type d'info sélectionnée
            const typeInfo = this.getAttribute('data-info');

            infoSelectionnee = {
                typeInfo: typeInfo,
                element: this
            };

            // Afficher le bouton valider
            if (btnValider) {
                btnValider.style.display = 'block';
            }
        });
    });

    // Gestion du clic sur le bouton Valider
    if (btnValider) {
        btnValider.addEventListener('click', function(e) {
            e.preventDefault();

            if (!infoSelectionnee) {
                alert('Veuillez sélectionner une information');
                return;
            }

            // Vérifier si l'info sélectionnée est la bonne (chiffrement)
            const estInfoCorrecte = infoSelectionnee.typeInfo === 'chiffrement';

            if (resultatContainer && messageResultat) {
                resultatContainer.style.display = 'block';

                if (estInfoCorrecte) {
                    messageResultat.textContent = '✓ Excellent ! Le chiffrement WPA3 est ce qui rend ce WiFi particulièrement sécurisé.';
                    infoSelectionnee.element.classList.add('info-correcte');
                } else {
                    messageResultat.textContent = '✗ Non, ce n\'est pas cette information. C\'est le chiffrement (WPA3) qui rend ce WiFi sécurisé.';
                    infoSelectionnee.element.classList.add('info-incorrecte');

                    // Mettre en évidence la bonne info
                    const bonneInfo = document.querySelector('.info-selectionnable[data-info="chiffrement"]');
                    if (bonneInfo) {
                        bonneInfo.classList.add('info-correcte');
                    }
                }

                // Masquer le bouton valider et afficher le bouton suivant
                btnValider.style.display = 'none';
                if (btnSuivant) {
                    btnSuivant.style.display = 'block';
                }

                // Désactiver la sélection des infos
                infosSelectionnables.forEach(function(info) {
                    info.style.pointerEvents = 'none';
                    info.classList.remove('info-cliquable');
                });
            }
        });
    }
});