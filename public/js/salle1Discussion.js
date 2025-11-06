document.addEventListener("DOMContentLoaded", function() {
    const textZone = document.getElementById("text-zone");

    // Récupère tous les mots à afficher
    let mots = [];
    try {
        mots = JSON.parse(textZone.dataset.mots || "[]");
    } catch (e) { mots = []; }

    // Récupère les mots suspects
    let motsSuspects = [];
    try {
        motsSuspects = JSON.parse(textZone.dataset.suspects || "[]");
    } catch (e) { motsSuspects = []; }

    // Affichage du message avec chaque mot cliquable
    textZone.innerHTML = "";
    mots.forEach((mot, idx) => {
        const span = document.createElement('span');
        span.textContent = mot;
        span.style.cursor = "pointer";

        span.addEventListener("click", function() {
            const popup = document.getElementById("popup");
            const popupTitre = document.getElementById("popup-titre");
            const popupMessage = document.getElementById("popup-message");
            const popupFermer = document.getElementById("popup-fermer");

            if (motsSuspects.includes(mot)) {
                span.style.color = "green";
                popupTitre.textContent = "Mot suspect !";
                popupMessage.textContent = "Ceci est un mot suspect : méfie-toi !";
            } else {
                span.style.color = "red";
                popupTitre.textContent = "Erreur !";
                popupMessage.textContent = "Ce n'est pas un mot suspect.";
            }
            popup.style.display = "flex";

            popupFermer.onclick = function() {
                popup.style.display = "none";
            };
        });

        textZone.appendChild(span);
        if(idx < mots.length-1) textZone.appendChild(document.createTextNode(" "));
    });
});