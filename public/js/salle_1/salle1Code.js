document.addEventListener("DOMContentLoaded", function() {

    const codeInput = document.getElementById("code-input");
    const codeForm = document.getElementById("code-form");
    const popup = document.getElementById("popup");
    const popupTitre = document.getElementById("popup-titre");
    const popupMessage = document.getElementById("popup-message");
    const popupFermer = document.getElementById("popup-fermer");

    // Récupère le code généré dans la page Discussion
    const codeCorrect = sessionStorage.getItem("codePorte");

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

        if (codeEntre === codeCorrect) {
            // Supprime le timer
            sessionStorage.removeItem("startTime");

            popupTitre.textContent = "🎉 Bravo !";
            popupMessage.innerHTML = `
                <strong>Le code est correct !</strong><br><br>
                <div style="font-size: 1.5em; color: #27ae60; margin: 15px 0;">
                    ✓ Accès autorisé
                </div>
                Tu peux maintenant passer à la salle suivante.
            `;
            popup.style.display = "flex";

            popupFermer.textContent = "Continuer";

            // Nettoyage des anciens onclick
            popupFermer.onclick = null;

            popupFermer.onclick = function () {
                // Supprime le code après utilisation
                sessionStorage.removeItem("codePorte");

                if (MODE === "jour") {
                    window.location.href = BASE_URL + "validerJour/1";
                } else {
                    window.location.href = BASE_URL + "valider/1";
                }
            };
        } else {

            // Afficher erreur
            popupTitre.textContent = "❌ Code incorrect";
            popupMessage.innerHTML = `
                <strong>Le code que vous avez entré n'est pas correct.</strong><br><br>
                <div style="color: #e74c3c; margin: 10px 0;">
                    Code entré : <strong>${codeEntre}</strong>
                </div>
                Vérifiez le code trouvé dans la discussion et réessayez !
            `;
            popup.style.display = "flex";

            popupFermer.textContent = "Réessayer";
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