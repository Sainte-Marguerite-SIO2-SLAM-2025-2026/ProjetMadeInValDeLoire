document.addEventListener("DOMContentLoaded", function() {

    const textZone = document.getElementById("text-zone");
    let motsTrouves = new Set();
    let indiceIndex = 0;

    // 🔵 Ajout pour la mascotte
    const popup = document.getElementById("popup");
    const popupTitre = document.getElementById("popup-titre");
    const popupMessage = document.getElementById("popup-message");
    const popupExplication = document.getElementById("popup-explication");
    const popupFermer = document.getElementById("popup-fermer");

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

    // Numéro activité
    const activiteNumero = textZone.dataset.activite || 0;

    // Normalize
    function normaliserMot(mot) {
        return mot.trim().toLowerCase().replace(/[.,!?;:]/g, '');
    }

    // Explication
    function getExplication(mot) {
        const motNormalise = normaliserMot(mot);

        const erreur = erreurs.find(e =>
            normaliserMot(e.mot_incorrect) === motNormalise
        );

        return erreur ? erreur.explication : '';
    }

    // 🎉 Victoire
    function verifierVictoire() {
        if (motsTrouves.size === motsSuspects.length && motsSuspects.length > 0) {

            const code = 8294;
            sessionStorage.setItem("codePorte", code);

            popupTitre.textContent = "🎉 Félicitations !";
            popupMessage.innerHTML = `Vous avez trouvé tous les mots suspects !<br><br>
                                       <strong>Voici votre code : ${code}</strong>`;

            if (popupExplication) popupExplication.style.display = "none";

            popup.style.display = "flex";

            popupFermer.onclick = function() {
                popup.style.display = "none";
                saveRoomCompletion(1);
            };
        }
    }

    // Nettoyage texte
    textZone.innerHTML = "";

    const nomSpan = document.createElement('span');
    const nomElement = document.getElementById('nom-personnage');
    nomSpan.textContent = nomElement ? nomElement.textContent.trim() : '';
    textZone.appendChild(nomSpan);
    textZone.appendChild(document.createElement('br'));
    textZone.appendChild(document.createElement('br'));

    // Affichage des mots
    mots.forEach((mot, idx) => {
        const span = document.createElement('span');
        span.textContent = mot;
        span.className = 'mot-cliquable';
        span.style.cursor = "pointer";

        span.addEventListener("click", function() {

            if (span.classList.contains('mot-clique')) {
                return;
            }

            span.classList.add('mot-clique');

            const motNettoye = normaliserMot(mot);

            const estSuspect = motsSuspects.some(s =>
                normaliserMot(s) === motNettoye
            );

            if (estSuspect) {
                // ✔ BON MOT
                span.style.color = "green";
                span.style.fontWeight = "bold";
                span.style.textDecoration = "underline";
                span.style.backgroundColor = "#d4edda";
                span.style.padding = "2px 6px";
                span.style.borderRadius = "4px";

                motsTrouves.add(motNettoye);

                popupTitre.textContent = "✅ Mot suspect trouvé !";
                popupTitre.style.color = "#27ae60";


                const explication = getExplication(mot);

                popupMessage.innerHTML = `<strong>Bien joué !</strong><br><br>
                "<em>${motNettoye}</em>" est un mot suspect.<br><br>
                Progression : <strong>${motsTrouves.size}/${motsSuspects.length}</strong>`;

                if (explication && popupExplication) {
                    popupExplication.innerHTML = `<strong>💡 Pourquoi c'est suspect ?</strong><br><br>${explication}`;
                    popupExplication.style.display = "block";
                } else {
                    popupExplication.style.display = "none";
                }

                popup.style.display = "flex";

                popupFermer.onclick = function() {
                    popup.style.display = "none";
                    popupExplication.style.display = "none";
                    setTimeout(verifierVictoire, 300);
                };

            } else {
                // ❌ MAUVAIS MOT
                span.style.color = "red";
                span.style.textDecoration = "line-through";
                span.style.backgroundColor = "#f8d7da";
                span.style.padding = "2px 6px";
                span.style.borderRadius = "4px";

                popupTitre.textContent = "❌ Erreur !";
                popupTitre.style.color = "#e74c3c";

                popupMessage.innerHTML = `"<em>${motNettoye}</em>" n'est pas un mot suspect.<br><br>Essayez encore !`;

                popupExplication.style.display = "none";

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

    // Indices
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

        if (popupIndice) {
            popupIndice.addEventListener("click", function(e) {
                if (e.target === popupIndice) {
                    popupIndice.style.display = "none";
                }
            });
        }
    }

    // Fermeture au clic extérieur
    if (popup) {
        popup.addEventListener("click", function(e) {
            if (e.target === popup) {
                popup.style.display = "none";
                if (popupExplication) popupExplication.style.display = "none";
            }
        });
    }

    // Sauvegarde salle
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
        }
    }

    console.log("Initialisation terminée");
});
