document.addEventListener("DOMContentLoaded", () => {
    const mascotte = document.getElementById("mascotte");
    const bulle = document.getElementById("mascotte-bulle");
    const txt = document.getElementById("bulle-texte");

    // --- LE SYSTÈME DE SÉCURITÉ ---
    // 1. On sauvegarde l'image définie dans le HTML (celle qui s'affiche avant le bug)
    // Si pas de src dans le HTML, on met une chaine vide
    const srcInitiale = mascotte.getAttribute("src") || "";

    // 2. Si jamais l'image plante (lien cassé), on remet instantanément l'image de base
    mascotte.onerror = function() {
        console.warn("Image introuvable, restauration de la mascotte de base.");
        this.onerror = null; // Évite une boucle infinie
        if(srcInitiale) this.src = srcInitiale;
    };
    // -----------------------------

    const mascotteContainer = mascotte.closest('.mascotte-container') || mascotte.parentElement;
    const baseUrl = typeof BASE_URL !== "undefined" ? BASE_URL : "";
    const indices = Array.isArray(INDICES) && INDICES.length > 0 ? INDICES : ["Aucun indice disponible"];

    // --- INITIALISATION CORRIGÉE ---
    // ON NE TOUCHE PAS au src ici. On fait confiance au HTML.
    // Si tu veux forcer une image, assure-toi que le chemin est bon :
    // mascotte.src = srcInitiale;

    // --- Préchargement des images (Pour éviter le clignotement plus tard) ---
    const imgInterrogee = new Image();
    imgInterrogee.src = baseUrl + "../images/salle_2/mascotte/mascotte_interrogee.svg";
    const imgExclamee = new Image();
    imgExclamee.src = baseUrl + "../images/salle_2/mascotte/mascotte_exclamee.svg";

    let index = 0;
    let timer = null;

    function positionnerBulle() {
        const r = mascotteContainer.getBoundingClientRect();
        bulle.style.left = Math.max(10, r.left + r.width / 2 - bulle.offsetWidth / 2) + "px";
        bulle.style.top = (r.top - bulle.offsetHeight - 20) + "px";
    }

    function afficherIndice() {
        clearTimeout(timer);
        txt.textContent = indices[index];
        index = (index + 1) % indices.length;

        bulle.style.display = "block";
        bulle.style.top = "";
        bulle.style.height = "auto";

        positionnerBulle();

        // Changement d'image sécurisé
        const targetSrc = baseUrl + "../images/salle_2/mascotte/mascotte_interrogee.svg";
        if (mascotte.src !== targetSrc) {
            mascotte.src = targetSrc;
        }

        timer = setTimeout(() => {
            fermerBulle();
        }, 5000);
    }

    function fermerBulle() {
        bulle.style.display = "none";
        // Retour à l'image de base mémorisée (plus fiable que de recalculer le chemin)
        if(srcInitiale) mascotte.src = srcInitiale;
    }

    // --- Événements ---

    mascotte.addEventListener("mouseenter", () => {
        if (bulle.style.display !== "block") {
            mascotte.src = baseUrl + "../images/salle_2/mascotte/mascotte_interrogee.svg";
        }
    });

    mascotte.addEventListener("mouseleave", () => {
        if (bulle.style.display !== "block") {
            // Retour sécurisé
            if(srcInitiale) mascotte.src = srcInitiale;
        }
    });

    mascotte.addEventListener("click", (e) => {
        e.stopPropagation();
        afficherIndice();
    });

    document.addEventListener("click", (e) => {
        if (bulle.style.display === "block" && !mascotteContainer.contains(e.target) && !bulle.contains(e.target)) {
            fermerBulle();
        }
    });

    window.addEventListener("resize", () => {
        if (bulle.style.display === "block") positionnerBulle();
    });

    window.addEventListener("scroll", () => {
        if (bulle.style.display === "block") positionnerBulle();
    });
});