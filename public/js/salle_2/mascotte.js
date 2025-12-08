document.addEventListener("DOMContentLoaded", () => {
    const mascotte = document.getElementById("mascotte");
    const bulle = document.getElementById("mascotte-bulle");
    const txt = document.getElementById("bulle-texte");

    // Sécurisation des variables globales
    const baseUrl = typeof BASE_URL !== "undefined" ? BASE_URL : "";
    const indices = Array.isArray(INDICES) && INDICES.length > 0 ? INDICES : ["Aucun indice disponible"];

    let index = 0;
    let timer = null;

    function positionnerBulle() {
        const r = mascotte.getBoundingClientRect();
        bulle.style.left = Math.max(10, r.left + r.width / 2 - bulle.offsetWidth / 2) + "px";
        bulle.style.top = Math.max(10, r.top - bulle.offsetHeight - 20) + "px";
    }

    function afficherIndice() {
        clearTimeout(timer);

        txt.textContent = indices[index];
        index = (index + 1) % indices.length;

        bulle.style.display = "block";
        positionnerBulle();

        mascotte.src = baseUrl + "/images/salle_2/mascotte/mascotte_exclamee.svg";

        timer = setTimeout(() => {
            bulle.style.display = "none";
            mascotte.src = baseUrl + "/images/salle_2/mascotte/mascotte_face.svg";
        }, 5000);
    }

    mascotte.addEventListener("mouseenter", () => {
        mascotte.src = baseUrl + "/images/salle_2/mascotte/mascotte_exclamee.svg";
    });

    mascotte.addEventListener("mouseleave", () => {
        if (bulle.style.display !== "block") {
            mascotte.src = baseUrl + "/images/salle_2/mascotte/mascotte_face.svg";
        }
    });

    mascotte.addEventListener("click", () => {
        if (bulle.style.display === "block") {
            bulle.style.display = "none";
            mascotte.src = baseUrl + "/images/salle_2/mascotte/mascotte_face.svg";
        } else {
            afficherIndice();
        }
    });

    window.addEventListener("resize", () => {
        if (bulle.style.display === "block") positionnerBulle();
    });

    window.addEventListener("scroll", () => {
        if (bulle.style.display === "block") positionnerBulle();
    });
});
