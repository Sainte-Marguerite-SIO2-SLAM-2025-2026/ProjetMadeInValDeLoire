document.addEventListener("DOMContentLoaded", function() {

    const textZone = document.getElementById("text-zone");
    let motsTrouves = new Set();
    let indiceIndex = 0;

    const popup = document.getElementById("popup");
    const popupTitre = document.getElementById("popup-titre");
    const popupMessage = document.getElementById("popup-message");
    const popupExplication = document.getElementById("popup-explication");
    const popupFermer = document.getElementById("popup-fermer");

    // Récupère tous les mots à afficher
    let mots = [];
    try { mots = JSON.parse(textZone.dataset.mots || "[]"); } catch (e) {}

    // Récupère les mots suspects
    let motsSuspects = [];
    try { motsSuspects = JSON.parse(textZone.dataset.suspects || "[]"); } catch (e) {}

    // Récupère les erreurs
    let erreurs = [];
    try { erreurs = JSON.parse(textZone.dataset.erreurs || "[]"); } catch (e) {}

    const activiteNumero = textZone.dataset.activite || 0;

    // AJOUT DU COMPTEUR
    const compteur = document.createElement("div");
    compteur.id = "compteur-suspects";
    compteur.className = "compteur-suspects";
    document.body.appendChild(compteur);

    function updateCompteur() {
        compteur.textContent = `Mots Trouvés : ${motsTrouves.size} / ${motsSuspects.length}`;
    }

    updateCompteur();

    function normaliserMot(mot) {
        return mot.trim().toLowerCase().replace(/[.,!?;:]/g, '');
    }

    function getExplication(mot) {
        const motNormalise = normaliserMot(mot);
        const erreur = erreurs.find(e =>
            normaliserMot(e.mot_incorrect) === motNormalise
        );
        return erreur ? erreur.explication : '';
    }

    // FONCTION POUR GÉNÉRER UN CODE ALÉATOIRE À 4 CHIFFRES
    function genererCodeAleatoire() {
        // Génère un nombre entre 1000 et 9999
        const code = Math.floor(1000 + Math.random() * 9000).toString();
        return code;
    }

    function verifierVictoire() {
        if (motsTrouves.size === motsSuspects.length && motsSuspects.length > 0) {

            // Génère le code à 4 chiffres
            const code = genererCodeAleatoire();

            // Sauvegarde le code dans sessionStorage pour la page suivante
            sessionStorage.setItem("codePorte", code);

            popupTitre.textContent = "🎉 Félicitations !";
            popupMessage.innerHTML = `
                <strong>Vous avez trouvé tous les mots suspects !</strong><br><br>
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                            padding: 20px; 
                            border-radius: 15px; 
                            margin: 20px 0;
                            box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
                    <div style="color: white; font-size: 1.1em; margin-bottom: 10px;">
                        🔐 Votre code secret
                    </div>
                    <div style="background: white; 
                                padding: 15px; 
                                border-radius: 10px; 
                                font-size: 2.5em; 
                                font-weight: bold; 
                                color: #667eea; 
                                letter-spacing: 8px;
                                text-align: center;
                                font-family: 'Courier New', monospace;">
                        ${code}
                    </div>
                </div>
                <span style="font-size: 0.95em; color: #e74c3c; font-weight: bold;">
                    ⚠️ Notez bien ce code, vous en aurez besoin pour ouvrir la porte !
                </span>
            `;

            if (popupExplication) popupExplication.style.display = "none";

            popup.style.display = "flex";

            popupFermer.textContent = "J'ai noté le code !";
            popupFermer.onclick = function() {
                popup.style.display = "none";
            };
        }
    }

    // Affichage texte
    textZone.innerHTML = "";

    const nomSpan = document.createElement('span');
    const nomElement = document.getElementById('nom-personnage');
    nomSpan.textContent = nomElement ? nomElement.textContent.trim() : '';
    textZone.appendChild(nomSpan);
    textZone.appendChild(document.createElement('br'));
    textZone.appendChild(document.createElement('br'));

    // Génération des mots
    mots.forEach((mot, idx) => {
        const span = document.createElement('span');
        span.textContent = mot;
        span.className = 'mot-cliquable';
        span.style.cursor = "pointer";

        span.addEventListener("click", function() {

            if (span.classList.contains('mot-clique')) return;

            span.classList.add('mot-clique');
            const motNettoye = normaliserMot(mot);

            const estSuspect = motsSuspects.some(s =>
                normaliserMot(s) === motNettoye
            );

            if (estSuspect) {
                // ✓ Mot suspect
                span.style.color = "green";
                span.style.fontWeight = "bold";
                span.style.textDecoration = "underline";
                span.style.backgroundColor = "#d4edda";
                span.style.padding = "2px 6px";
                span.style.borderRadius = "4px";

                motsTrouves.add(motNettoye);
                updateCompteur(); // Mise à jour compteur

                popupTitre.textContent = "✅ Mot suspect trouvé !";
                popupTitre.style.color = "#27ae60";

                const explication = getExplication(mot);

                popupMessage.innerHTML = `<strong>Bien joué !</strong><br><br>
                "<em>${motNettoye}</em>" est un mot suspect.<br><br>
                Progression : <strong>${motsTrouves.size}/${motsSuspects.length}</strong>`;

                if (explication) {
                    popupExplication.innerHTML = `<strong>💡 Pourquoi c'est suspect ?</strong><br><br>${explication}`;
                    popupExplication.style.display = "block";
                } else {
                    popupExplication.style.display = "none";
                }

                popup.style.display = "flex";

                popupFermer.textContent = "Fermer";
                popupFermer.onclick = function() {
                    popup.style.display = "none";
                    popupExplication.style.display = "none";
                    setTimeout(verifierVictoire, 300);
                };

            } else {
                // ✗ Mauvais mot
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

                popupFermer.textContent = "Fermer";
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
});