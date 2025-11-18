document.addEventListener("DOMContentLoaded", function() {

    const textZone = document.getElementById("text-zone");
    let motsTrouves = new Set();

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

    // Fonction de victoire
    function verifierVictoire() {
        if (motsTrouves.size === motsSuspects.length) {
            const popup = document.getElementById("popup");
            const popupTitre = document.getElementById("popup-titre");
            const popupMessage = document.getElementById("popup-message");
            const popupFermer = document.getElementById("popup-fermer");

            // Code fixe
            const code = 8294;

            // 🔥 Stocke le code pour la salle suivante
            sessionStorage.setItem("codePorte", code);

            popupTitre.textContent = "Félicitations !";
            popupMessage.innerHTML = `Tu as trouvé tous les mots suspects !<br><strong>Voici ton code : ${code}</strong>`;
            popup.style.display = "flex";

            popupFermer.onclick = function() {
                popup.style.display = "none";
            };
        }
    }

    // Affiche les mots cliquables
    textZone.innerHTML = "";

    const nomSpan = document.createElement('span');
    nomSpan.className = 'nom-personnage-bulle';
    nomSpan.textContent = textZone.parentElement.querySelector('#nom-personnage')?.textContent || '';
    textZone.appendChild(nomSpan);
    textZone.appendChild(document.createElement('br'));
    textZone.appendChild(document.createElement('br'));

    mots.forEach((mot, idx) => {
        const span = document.createElement('span');
        span.textContent = mot;
        span.style.cursor = "pointer";

        span.addEventListener("click", function() {
            if (span.classList.contains('mot-clique')) return;

            const popup = document.getElementById("popup");
            const popupTitre = document.getElementById("popup-titre");
            const popupMessage = document.getElementById("popup-message");
            const popupFermer = document.getElementById("popup-fermer");

            span.classList.add('mot-clique');

            if (motsSuspects.includes(mot)) {
                span.style.color = "green";
                span.style.fontWeight = "bold";
                motsTrouves.add(mot);

                popupTitre.textContent = "Mot suspect !";
                popupMessage.textContent = `Bien joué ! "${mot}" est un mot suspect. (${motsTrouves.size}/${motsSuspects.length})`;
                popup.style.display = "flex";

                popupFermer.onclick = function() {
                    popup.style.display = "none";
                    verifierVictoire();
                };

            } else {
                span.style.color = "red";
                span.style.textDecoration = "line-through";

                popupTitre.textContent = "Erreur !";
                popupMessage.textContent = `"${mot}" n'est pas un mot suspect.`;
                popup.style.display = "flex";

                popupFermer.onclick = function() {
                    popup.style.display = "none";
                };
            }
        });

        textZone.appendChild(span);
        if (idx < mots.length - 1) textZone.appendChild(document.createTextNode(" "));
    });

});