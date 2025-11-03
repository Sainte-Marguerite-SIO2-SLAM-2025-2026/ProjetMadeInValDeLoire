(function() {
    var zoneCliquable = document.getElementById('zoneCliquable');
    var cartesContainer = document.getElementById('cartesContainer');
    var btnValider = document.getElementById('btnValider');
    var btnAccueil = document.getElementById('btnAccueil');
    var cartes = document.querySelectorAll('.CarteWifi');
    var carteSelectionnee = null;
    var bonneCarte = "2"; // ID de la bonne carte (Livebox-A3F2 avec WPA3)
    var bonneInfo = "chiffrement"; // La bonne information à sélectionner
    var infoSelectionnee = null;
    var carteCorrecteTrouvee = false;
    var etapeValidation = 'carte'; // 'carte' ou 'info'
    var cartesVisibles = false;
    var validationEnCours = false; // Pour savoir si on affiche un résultat
    var peutSelectionnerInfo = false; // Pour bloquer la sélection des infos avant "Suivant"

    // Sécurité : vérifier que les éléments existent
    if (!zoneCliquable || !cartesContainer || !btnValider) {
        console.warn('Éléments requis non trouvés');
        return;
    }

    // Toggle affichage des cartes (sans réinitialiser l'état)
    zoneCliquable.addEventListener('click', function() {
        try {
            if (cartesContainer.style.display === 'none' || cartesContainer.style.display === '') {
                // Afficher les cartes
                cartesContainer.style.display = 'flex';
                cartesVisibles = true;

                // Réafficher le bouton si une sélection est en cours ou si on affiche un résultat
                if ((etapeValidation === 'carte' && carteSelectionnee && !carteCorrecteTrouvee) ||
                    (etapeValidation === 'info' && infoSelectionnee && !validationEnCours) ||
                    validationEnCours) {
                    btnValider.style.display = 'block';
                }

                // Réactiver le hover sur les infos si on peut les sélectionner
                if (peutSelectionnerInfo) {
                    var carteCorrecte = document.querySelector('.CarteWifi.carte-correcte');
                    if (carteCorrecte) {
                        var infos = carteCorrecte.querySelectorAll('.info-selectionnable');
                        infos.forEach(function(info) {
                            if (!info.classList.contains('info-correcte') && !info.classList.contains('info-incorrecte')) {
                                info.classList.remove('info-cliquable-attente');
                                info.classList.add('info-cliquable');
                            }
                        });
                    }
                }
            } else {
                // Cacher les cartes (sans réinitialiser)
                cartesContainer.style.display = 'none';
                cartesVisibles = false;

                // Cacher le bouton aussi
                btnValider.style.display = 'none';
            }
        } catch (error) {
            console.error('Erreur lors du toggle des cartes:', error);
        }
    });

    // Sélection d'une carte
    cartes.forEach(function(carte) {
        carte.addEventListener('click', function(e) {
            try {
                // Si on a déjà validé la carte correcte, ne pas permettre la sélection de carte
                if (carteCorrecteTrouvee) {
                    return;
                }

                // Empêcher la sélection si déjà validé
                if (this.classList.contains('carte-correcte') || this.classList.contains('carte-incorrecte')) {
                    return;
                }

                // Si on clique sur une info, ne pas sélectionner la carte
                if (e.target.classList.contains('info-selectionnable')) {
                    return;
                }

                // Retirer la sélection précédente
                cartes.forEach(function(c) {
                    c.classList.remove('carte-selectionnee');
                });

                // Sélectionner la carte cliquée
                this.classList.add('carte-selectionnee');
                carteSelectionnee = this.getAttribute('data-wifi-id');

                // Afficher le bouton valider
                etapeValidation = 'carte';
                validationEnCours = false;
                btnValider.textContent = 'Valider';
                btnValider.style.display = 'block';
            } catch (error) {
                console.error('Erreur lors de la sélection de carte:', error);
            }
        });
    });

    // Sélection d'une information
    document.addEventListener('click', function(e) {
        try {
            if (!e.target.classList.contains('info-selectionnable')) {
                return;
            }

            // Vérifier que la carte est correcte et validée
            var carte = e.target.closest('.CarteWifi');
            if (!carte || !carte.classList.contains('carte-correcte')) {
                return;
            }

            // Bloquer la sélection si on n'a pas encore cliqué sur "Suivant"
            if (!peutSelectionnerInfo) {
                return;
            }

            // Empêcher la sélection si déjà validé les infos
            if (e.target.classList.contains('info-correcte') || e.target.classList.contains('info-incorrecte')) {
                return;
            }

            // Retirer la sélection précédente
            var infos = carte.querySelectorAll('.info-selectionnable');
            infos.forEach(function(info) {
                info.classList.remove('info-selectionnee');
            });

            // Sélectionner l'info cliquée
            e.target.classList.add('info-selectionnee');
            infoSelectionnee = e.target.getAttribute('data-info');

            // Afficher le bouton valider avec texte adapté
            etapeValidation = 'info';
            validationEnCours = false;
            btnValider.textContent = 'Valider l\'information';
            btnValider.style.display = 'block';
        } catch (error) {
            console.error('Erreur lors de la sélection d\'info:', error);
        }
    });

    // Validation unique (carte ou info selon l'étape)
    if (btnValider) {
        btnValider.addEventListener('click', function() {
            try {
                // Si on est en mode "Suivant"
                if (validationEnCours) {
                    if (btnValider.textContent === 'Suivant') {
                        // Si on vient de valider la carte, on passe à la sélection d'infos
                        if (etapeValidation === 'carte') {
                            // Cacher les cartes et le bouton, permettre la sélection d'infos
                            cartesContainer.style.display = 'none';
                            btnValider.style.display = 'none';
                            cartesVisibles = false;
                            validationEnCours = false;
                            peutSelectionnerInfo = true;
                            return;
                        }
                        // Si on vient de valider l'info, on cache tout
                        else if (etapeValidation === 'info') {
                            cartesContainer.style.display = 'none';
                            btnValider.style.display = 'none';
                            cartesVisibles = false;
                            validationEnCours = false;
                            peutSelectionnerInfo = false;
                            return;
                        }
                    }
                }

                if (etapeValidation === 'carte') {
                    // Validation de la carte
                    if (!carteSelectionnee) {
                        return;
                    }

                    var bonChoix = false;

                    // Appliquer les styles correct/incorrect
                    cartes.forEach(function(carte) {
                        var carteId = carte.getAttribute('data-wifi-id');
                        carte.classList.remove('carte-selectionnee');

                        if (carteId === bonneCarte) {
                            carte.classList.add('carte-correcte');

                            if (carteId === carteSelectionnee) {
                                bonChoix = true;
                                carteCorrecteTrouvee = true;

                                // Rendre les infos cliquables sur la bonne carte (visuellement seulement)
                                var infos = carte.querySelectorAll('.info-selectionnable');
                                infos.forEach(function(info) {
                                    info.classList.add('info-cliquable-attente');
                                });
                            }
                        } else {
                            carte.classList.add('carte-incorrecte');
                        }
                    });

                    // Changer le texte du bouton selon le résultat
                    validationEnCours = true;
                    if (bonChoix) {
                        btnValider.textContent = 'Suivant';
                    } else {
                        // Afficher le bouton d'accueil et cacher le bouton valider
                        if (btnAccueil) {
                            btnAccueil.style.display = 'block';
                            btnValider.style.display = 'none';
                        }
                    }

                } else if (etapeValidation === 'info') {
                    // Validation de l'information
                    if (!infoSelectionnee) {
                        return;
                    }

                    // Trouver la carte correcte
                    var carteCorrecte = document.querySelector('.CarteWifi.carte-correcte');
                    if (!carteCorrecte) {
                        return;
                    }

                    var bonChoix = (infoSelectionnee === bonneInfo);

                    // Appliquer les styles correct/incorrect aux infos
                    var infos = carteCorrecte.querySelectorAll('.info-selectionnable');
                    infos.forEach(function(info) {
                        info.classList.remove('info-selectionnee', 'info-cliquable', 'info-cliquable-attente');
                        var infoType = info.getAttribute('data-info');

                        if (infoType === bonneInfo) {
                            info.classList.add('info-correcte');
                        } else {
                            info.classList.add('info-incorrecte');
                        }
                    });

                    // Changer le texte du bouton selon le résultat
                    validationEnCours = true;
                    if (bonChoix) {
                        btnValider.textContent = 'Suivant';
                    } else {
                        // Afficher le bouton d'accueil et cacher le bouton valider
                        if (btnAccueil) {
                            btnAccueil.style.display = 'block';
                            btnValider.style.display = 'none';
                        }
                    }
                }
            } catch (error) {
                console.error('Erreur lors de la validation:', error);
            }
        });
    }

    // Activer les infos cliquables quand on rouvre les cartes après avoir cliqué sur "Suivant"
    document.addEventListener('DOMContentLoaded', function() {
        var observer = new MutationObserver(function() {
            if (peutSelectionnerInfo && cartesVisibles) {
                var carteCorrecte = document.querySelector('.CarteWifi.carte-correcte');
                if (carteCorrecte) {
                    var infos = carteCorrecte.querySelectorAll('.info-selectionnable');
                    infos.forEach(function(info) {
                        if (!info.classList.contains('info-correcte') && !info.classList.contains('info-incorrecte')) {
                            info.classList.remove('info-cliquable-attente');
                            info.classList.add('info-cliquable');
                        }
                    });
                }
            }
        });
    });
})();