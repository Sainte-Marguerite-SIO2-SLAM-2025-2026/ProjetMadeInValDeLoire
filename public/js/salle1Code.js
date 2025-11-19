document.addEventListener("DOMContentLoaded", function() {

    const codeInput = document.getElementById("code-input");
    const codeForm = document.getElementById("code-form");
    const popup = document.getElementById("popup");
    const popupTitre = document.getElementById("popup-titre");
    const popupMessage = document.getElementById("popup-message");
    const popupFermer = document.getElementById("popup-fermer");

    // 🔥 Récupération du code généré dans la discussion
    const codeCorrect = sessionStorage.getItem("codePorte");

    // Si aucun code n'a été généré
    if (!codeCorrect) {
        popupTitre.textContent = "⚠️ Attention";
        popupMessage.textContent = "Tu n'as pas encore trouvé tous les mots suspects ! Retourne dans la discussion.";
        popup.style.display = "flex";

        popupFermer.onclick = function() {
            window.location.href = "/ProjetMadeInValDeLoire/public/Salle1/accesMessage";
        };

        return;
    }

    // Formulaire validation du code
    codeForm.addEventListener("submit", function(e) {
        e.preventDefault();

        const codeEntre = codeInput.value.trim();

        if (codeEntre === codeCorrect) {

            popupTitre.textContent = "🎉 Bravo !";
            popupMessage.innerHTML = "Le code est correct !<br>Tu peux maintenant passer à la salle suivante.";
            popup.style.display = "flex";

            popupFermer.textContent = "Continuer";
            popupFermer.onclick = function() {
                // Nettoyage
                sessionStorage.removeItem("codePorte");

                // 🔥 Redirection vers la salle suivante
                window.location.href = "/ProjetMadeInValDeLoire/public/";
            };

        } else {
            popupTitre.textContent = "❌ Erreur";
            popupMessage.textContent = "Code incorrect. Essaye encore !";
            popup.style.display = "flex";

            popupFermer.onclick = function() {
                popup.style.display = "none";
                codeInput.value = "";
                codeInput.focus();
            };
        }
    });

    // Input numérique limité à 4 chiffres
    codeInput.addEventListener("input", function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);
    });

    codeInput.focus();

});