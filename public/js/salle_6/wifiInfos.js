document.addEventListener('DOMContentLoaded', function() {
    const zoneCliquable = document.getElementById('zoneCliquable');
    const cartesContainer = document.getElementById('cartesContainer');
    const btnValider = document.getElementById('btnValider');
    const btnSuivant = document.getElementById('btnSuivant');
    const resultatContainer = document.getElementById('resultatContainer');
    const messageResultat = document.getElementById('messageResultat');
    const formWifiInfo = document.getElementById('formWifiInfo');
    const infoSelectionneeInput = document.getElementById('infoSelectionneeInput');

    // Éléments pour la mascotte et la bulle
    const mascotteLink = document.getElementById('mascotteLink');
    const bulle = document.querySelector('.bulle');
    const bulleTexte = document.querySelector('.bulle-texte-container p');

    // Textes pour la bulle
    const texteInitial = bulleTexte ? bulleTexte.textContent : '';
    const texteCartesAffichees = 'Cliquez sur l\'information qui rend ce WiFi sécurisé !';

    // Pour désactiver le hover :
    const carteWifi = document.getElementById('CarteWifi');
    if (carteWifi) {
        carteWifi.classList.add('no-hover');
    }

    let infoSelectionnee = null;
    let reponseCorrecte = false;
    let bulleVisible = false; // La bulle est CACHÉE au départ

    // Gestion du clic sur le lien de la mascotte
    if (mascotteLink && bulle) {
        mascotteLink.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Toggle de la visibilité de la bulle
            bulleVisible = !bulleVisible;
            bulle.style.display = bulleVisible ? 'block' : 'none';
        });
    }

    // Gérer le clic sur la zone cliquable
    if (zoneCliquable && cartesContainer) {
        zoneCliquable.addEventListener('click', function() {
            if (cartesContainer.style.display === 'none' || cartesContainer.style.display === '') {
                cartesContainer.style.display = 'flex';

                // Changer le texte de la bulle quand les cartes sont affichées
                if (bulleTexte) {
                    bulleTexte.textContent = texteCartesAffichees;
                }

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

                // Restaurer le texte initial quand les cartes sont cachées
                if (bulleTexte) {
                    bulleTexte.textContent = texteInitial;
                }

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

            // Mettre à jour le champ caché
            if (infoSelectionneeInput) {
                infoSelectionneeInput.value = typeInfo;
            }

            console.log('Info sélectionnée:', typeInfo);

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

            console.log('Validation - info sélectionnée:', infoSelectionnee.typeInfo);
            console.log('Validation - zone correcte:', zoneCorrecte);

            // Vérifier si l'info sélectionnée est la bonne en utilisant la variable globale
            const estInfoCorrecte = infoSelectionnee.typeInfo === zoneCorrecte;
            reponseCorrecte = estInfoCorrecte;

            if (resultatContainer && messageResultat) {
                resultatContainer.style.display = 'block';

                if (estInfoCorrecte) {
                    messageResultat.textContent = '✓ Excellent ! C\'est bien cette information qui rend ce WiFi sécurisé.';
                    infoSelectionnee.element.classList.add('info-correcte');
                } else {
                    messageResultat.textContent = '✗ Non, ce n\'est pas cette information qui garantit la sécurité de ce WiFi.';
                    infoSelectionnee.element.classList.add('info-incorrecte');

                    // Mettre en évidence la bonne info
                    const bonneInfo = document.querySelector('.info-selectionnable[data-info="' + zoneCorrecte + '"]');
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

    // Gestion du bouton Suivant
    if (btnSuivant) {
        btnSuivant.addEventListener('click', function(e) {
            e.preventDefault();

            if (infoSelectionnee && infoSelectionneeInput && formWifiInfo) {
                infoSelectionneeInput.value = infoSelectionnee.typeInfo;
                console.log('Soumission du formulaire avec:', infoSelectionneeInput.value);
                formWifiInfo.submit();
            }
        });
    }
});