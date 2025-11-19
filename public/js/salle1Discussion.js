document.addEventListener("DOMContentLoaded", function() {

    const textZone = document.getElementById("text-zone");
    let motsTrouves = new Set();
    let indiceIndex = 0;

    // Récupère tous les mots à afficher
    let mots = [];
    try {
        mots = JSON.parse(textZone.dataset.mots || "[]");
    } catch (e) {
        console.error("Erreur parsing mots:", e);
        mots = [];
    }

    // Récupère les mots suspects
    let motsSuspects = [];
    try {
        motsSuspects = JSON.parse(textZone.dataset.suspects || "[]");
        console.log("Mots suspects:", motsSuspects);
    } catch (e) {
        console.error("Erreur parsing suspects:", e);
        motsSuspects = [];
    }

    // Récupère les erreurs avec explications
    let erreurs = [];
    try {
        erreurs = JSON.parse(textZone.dataset.erreurs || "[]");
        console.log("Erreurs:", erreurs);
    } catch (e) {
        console.error("Erreur parsing erreurs:", e);
        erreurs = [];
    }

    // Récupère le numéro d'activité
    const activiteNumero = textZone.dataset.activite || 0;

    // Éléments popup
    const popup = document.getElementById("popup");
    const popupTitre = document.getElementById("popup-titre");
    const popupMessage = document.getElementById("popup-message");
    const popupExplication = document.getElementById("popup-explication");
    const popupFermer = document.getElementById("popup-fermer");

    // Fonction pour normaliser un mot (enlever ponctuation et espaces)
    function normaliserMot(mot) {
        return mot.trim().toLowerCase().replace(/[.,!?;:]/g, '');
    }

    // Fonction pour trouver l'explication d'un mot
    function getExplication(mot) {
        const motNormalise = normaliserMot(mot);
        console.log("🔍 Recherche explication pour:", motNormalise);
        console.log("📚 Liste des erreurs disponibles:", erreurs);

        const erreur = erreurs.find(e => {
            const motErreurNormalise = normaliserMot(e.mot_incorrect);
            console.log(`  Comparaison: "${motNormalise}" === "${motErreurNormalise}"`, motNormalise === motErreurNormalise);
            return motErreurNormalise === motNormalise;
        });

        if (erreur) {
            console.log("✅ Explication trouvée:", erreur.explication);
            return erreur.explication;
        }

        console.log("❌ Aucune explication trouvée pour:", motNormalise);
        return '';
    }

    // Fonction de victoire
    function verifierVictoire() {
        console.log("Vérification victoire:", motsTrouves.size, "/", motsSuspects.length);

        if (motsTrouves.size === motsSuspects.length && motsSuspects.length > 0) {
            // Code fixe ou généré
            const code = 8294;

            // Stocke le code pour la salle suivante
            sessionStorage.setItem("codePorte", code);

            popupTitre.textContent = "🎉 Félicitations !";
            popupMessage.innerHTML = `Vous avez trouvé tous les mots suspects !<br><br><strong>Voici votre code : ${code}</strong><br><br>Notez-le bien pour accéder à la suite !`;

            if (popupExplication) {
                popupExplication.style.display = "none";
            }

            popup.style.display = "flex";

            popupFermer.onclick = function() {
                popup.style.display = "none";
                // Sauvegarde la progression
                saveRoomCompletion(1);
            };
        }
    }

    // Affiche les mots cliquables
    textZone.innerHTML = "";

    const nomSpan = document.createElement('span');
    nomSpan.className = 'nom-personnage-bulle';
    const nomElement = document.getElementById('nom-personnage');
    nomSpan.textContent = nomElement ? nomElement.textContent.trim() : '';
    textZone.appendChild(nomSpan);
    textZone.appendChild(document.createElement('br'));
    textZone.appendChild(document.createElement('br'));

    mots.forEach((mot, idx) => {
        const span = document.createElement('span');
        span.textContent = mot;
        span.style.cursor = "pointer";
        span.className = 'mot-cliquable';

        span.addEventListener("click", function() {
            console.log("Clic sur mot:", mot);

            if (span.classList.contains('mot-clique')) {
                console.log("Mot déjà cliqué, ignoré");
                return;
            }

            span.classList.add('mot-clique');

            // Nettoie le mot (enlève la ponctuation)
            const motNettoye = normaliserMot(mot);
            console.log("Mot nettoyé:", motNettoye);

            // Vérifie si c'est un mot suspect
            const estSuspect = motsSuspects.some(suspect =>
                normaliserMot(suspect) === motNettoye
            );

            console.log("Est suspect?", estSuspect);

            if (estSuspect) {
                // BON MOT TROUVÉ
                span.style.color = "green";
                span.style.fontWeight = "bold";
                span.style.textDecoration = "underline";
                span.style.backgroundColor = "#d4edda";
                span.style.padding = "2px 6px";
                span.style.borderRadius = "4px";

                motsTrouves.add(motNettoye);
                console.log("Mots trouvés:", Array.from(motsTrouves));

                popupTitre.textContent = "✅ Mot suspect trouvé !";
                popupTitre.style.color = "#27ae60";

                // Récupère l'explication depuis la base de données
                const explication = getExplication(mot);

                if (explication) {
                    popupMessage.innerHTML = `<strong>Bien joué !</strong><br><br>"<em>${mot.replace(/[.,!?;:]/g, '')}</em>" est bien un mot suspect.<br><br>Progression : <strong>${motsTrouves.size}/${motsSuspects.length}</strong>`;

                    // Affiche l'explication dans une section dédiée
                    if (popupExplication) {
                        popupExplication.innerHTML = `<strong>💡 Pourquoi c'est suspect ?</strong><br><br>${explication}`;
                        popupExplication.style.display = "block";
                    }
                } else {
                    // Si pas d'explication, message par défaut
                    popupMessage.innerHTML = `<strong>Bien joué !</strong><br><br>"<em>${mot.replace(/[.,!?;:]/g, '')}</em>" est bien un mot suspect.<br><br>Progression : <strong>${motsTrouves.size}/${motsSuspects.length}</strong><br><br><em>Ce mot est considéré comme suspect dans ce contexte.</em>`;

                    if (popupExplication) {
                        popupExplication.style.display = "none";
                    }
                }

                popup.style.display = "flex";

                popupFermer.onclick = function() {
                    popup.style.display = "none";
                    if (popupExplication) {
                        popupExplication.style.display = "none";
                    }
                    // Vérifier la victoire après fermeture
                    setTimeout(verifierVictoire, 300);
                };

            } else {
                // MAUVAIS MOT
                span.style.color = "red";
                span.style.textDecoration = "line-through";
                span.style.backgroundColor = "#f8d7da";
                span.style.padding = "2px 6px";
                span.style.borderRadius = "4px";

                popupTitre.textContent = "❌ Erreur !";
                popupTitre.style.color = "#e74c3c";

                popupMessage.innerHTML = `"<em>${mot.replace(/[.,!?;:]/g, '')}</em>" n'est pas un mot suspect.<br><br>Essayez encore !`;

                if (popupExplication) {
                    popupExplication.style.display = "none";
                }

                popup.style.display = "flex";

                popupFermer.onclick = function() {
                    popup.style.display = "none";
                };
            }
        });

        textZone.appendChild(span);
        if (idx < mots.length - 1) {
            textZone.appendChild(document.createTextNode(" "));
        }
    });

    // Gestion des indices
    const btnIndice = document.getElementById("btn-indice");
    const popupIndice = document.getElementById("popup-indice");
    const indiceMessage = document.getElementById("indice-message");
    const indiceFermer = document.getElementById("indice-fermer");
    const indicesRestants = document.getElementById("indices-restants");

    if (btnIndice && typeof INDICES !== 'undefined' && INDICES.length > 0) {
        btnIndice.addEventListener("click", function() {
            if (indiceIndex < INDICES.length) {
                const indice = INDICES[indiceIndex];
                indiceMessage.textContent = indice.libelle;
                popupIndice.style.display = "flex";

                indiceIndex++;
                indicesRestants.textContent = INDICES.length - indiceIndex;

                if (indiceIndex >= INDICES.length) {
                    btnIndice.disabled = true;
                    btnIndice.textContent = "💡 Plus d'indices";
                }
            }
        });

        if (indiceFermer) {
            indiceFermer.addEventListener("click", function() {
                popupIndice.style.display = "none";
            });
        }

        // Fermer au clic en dehors
        if (popupIndice) {
            popupIndice.addEventListener("click", function(e) {
                if (e.target === popupIndice) {
                    popupIndice.style.display = "none";
                }
            });
        }
    }

    // Fermer popup principale au clic en dehors
    if (popup) {
        popup.addEventListener("click", function(e) {
            if (e.target === popup) {
                popup.style.display = "none";
                if (popupExplication) {
                    popupExplication.style.display = "none";
                }
            }
        });
    }

    // Fonction pour sauvegarder la complétion de la salle
    function saveRoomCompletion(roomNumber) {
        let completedRooms = [];
        try {
            const stored = localStorage.getItem('completedRooms');
            completedRooms = stored ? JSON.parse(stored) : [];
        } catch(e) {
            completedRooms = [];
        }

        if (!completedRooms.includes(roomNumber)) {
            completedRooms.push(roomNumber);
            localStorage.setItem('completedRooms', JSON.stringify(completedRooms));
            console.log("Salle complétée sauvegardée:", roomNumber);
        }
    }

    console.log("Initialisation terminée");
    console.log("Nombre de mots:", mots.length);
    console.log("Nombre de mots suspects:", motsSuspects.length);
});