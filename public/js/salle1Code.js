document.addEventListener("DOMContentLoaded", function() {

    const codeInput = document.getElementById("code-input");
    const codeForm = document.getElementById("code-form");
    const popup = document.getElementById("popup");
    const popupTitre = document.getElementById("popup-titre");
    const popupMessage = document.getElementById("popup-message");
    const popupFermer = document.getElementById("popup-fermer");

    const codeCorrect = sessionStorage.getItem("codePorte");

    console.log("=== DEBUG CODE SALLE 1 ===");
    console.log("Code correct:", codeCorrect);
    console.log("Mode:", MODE);
    console.log("Type de MODE:", typeof MODE);

    // --- SI CODE NON GÉNÉRÉ ---
    if (!codeCorrect) {
        popupTitre.textContent = "⚠️ Attention";
        popupMessage.textContent = "Tu n'as pas encore trouvé tous les mots suspects ! Retourne dans la discussion.";
        popup.style.display = "flex";

        popupFermer.onclick = function () {
            window.location.href = BASE_URL + "Salle1/accesMessage";
        };

        return;
    }

    // --- VALIDATION DU FORMULAIRE ---
    codeForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const codeEntre = codeInput.value.trim();
        console.log("Code entré:", codeEntre);
        console.log("Comparaison:", codeEntre, "===", codeCorrect);

        if (codeEntre === codeCorrect) {
            console.log("✅ Code correct !");

            popupTitre.textContent = "🎉 Bravo !";
            popupMessage.innerHTML = "Le code est correct !<br>Tu peux maintenant passer à la salle suivante.";
            popup.style.display = "flex";

            popupFermer.textContent = "Continuer";

            // Nettoyage des anciens onclick
            popupFermer.onclick = null;

            popupFermer.onclick = function () {
                sessionStorage.removeItem("codePorte");

                console.log("Redirection selon le mode:", MODE);

                if (MODE === "jour") {
                    console.log("→ Redirection mode JOUR");
                    window.location.href = BASE_URL + "validerJour/1";
                } else {
                    console.log("→ Redirection mode NUIT");
                    window.location.href = BASE_URL + "valider/1";
                }
            };
        } else {
            console.log("❌ Code incorrect");

            // Afficher erreur
            popupTitre.textContent = "❌ Code incorrect";
            popupMessage.textContent = "Le code que vous avez entré n'est pas correct. Réessayez !";
            popup.style.display = "flex";

            popupFermer.textContent = "Fermer";
            popupFermer.onclick = function() {
                popup.style.display = "none";
                codeInput.value = "";
                codeInput.focus();
            };
        }
    });

    // Input limité à 4 chiffres
    codeInput.addEventListener("input", function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);
    });

    codeInput.focus();
});