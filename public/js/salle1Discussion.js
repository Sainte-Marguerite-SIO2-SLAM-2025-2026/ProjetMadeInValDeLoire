document.addEventListener("DOMContentLoaded", function () {

    // --- CONFIGURATION ---
    const motsSuspects = {
        "lien": "Les liens suspects sont souvent utilisés dans les tentatives de phishing.",
        "email": "Fais attention aux emails inconnus demandant des informations personnelles.",
        "cliquer": "Ne clique jamais sur un lien si tu n’es pas sûr de sa provenance."
    };

    let vies = 3;
    let motsTrouvés = [];

    const zoneTexte = document.getElementById("text-zone");
    const popup = document.getElementById("popup");
    const popupTitre = document.getElementById("popup-titre");
    const popupMessage = document.getElementById("popup-message");
    const popupFermer = document.getElementById("popup-fermer");
    const zoneCode = document.getElementById("zone-code");
    const codePorte = document.getElementById("code-porte");
    const viesEl = document.getElementById("vies");

    // --- ACTION SUR LES MOTS ---
    zoneTexte.querySelectorAll(".mot-cliquable").forEach(mot => {
        mot.addEventListener("click", () => {
            const texte = mot.textContent.trim().toLowerCase();

            if (motsSuspects[texte]) {
                // mot correct
                mot.style.color = "lime";
                mot.style.pointerEvents = "none";
                motsTrouvés.push(texte);

                popupTitre.textContent = "Bonne réponse !";
                popupMessage.textContent = motsSuspects[texte];
                popup.style.display = "flex";

                // si tous les mots ont été trouvés
                if (motsTrouvés.length === Object.keys(motsSuspects).length) {
                    setTimeout(() => {
                        const code = Math.floor(1000 + Math.random() * 9000);
                        codePorte.textContent = code;
                        zoneCode.style.display = "block";
                        popupTitre.textContent = "Félicitations !";
                        popupMessage.textContent = "Tu as trouvé tous les mots suspects ! Voici ton code : " + code;
                        popup.style.display = "flex";
                    }, 1000);
                }

            } else {
                // mauvaise réponse
                vies--;
                mot.style.color = "red";
                mot.style.pointerEvents = "none";
                viesEl.textContent = "❤️".repeat(vies);

                if (vies <= 0) {
                    popupTitre.textContent = "Perdu !";
                    popupMessage.textContent = "Tu as épuisé toutes tes vies... Recommence.";
                    popup.style.display = "flex";
                    zoneTexte.querySelectorAll(".mot-cliquable").forEach(m => m.style.pointerEvents = "none");
                }
            }
        });
    });

    // --- FERMETURE POPUP ---
    popupFermer.addEventListener("click", () => {
        popup.style.display = "none";
    });
});