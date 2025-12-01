document.addEventListener("DOMContentLoaded", () => {
    // 🔹 Voile noir désactivé au chargement
    const overlay = document.getElementById("transition-overlay");
    if (overlay) {
        overlay.style.opacity = "0";
        overlay.style.pointerEvents = "none";
        overlay.style.transition = "opacity 0.8s ease";
    }

    const baseUrl = document.body.dataset.baseurl;

    // BOUTON ACCUEIL
    const btnAccueil = document.getElementById("accueil");
    if (btnAccueil) {
        const baseUrl = document.body.dataset.baseurl;
        const isJour = document.body.dataset.mode === 'jour';
        const redirectUrl = isJour ? baseUrl + '/manoirJour' : baseUrl + '/';

        btnAccueil.style.cursor = "pointer";

        btnAccueil.addEventListener("click", () => {
            if (overlay) {
                overlay.style.opacity = "1";
                overlay.style.pointerEvents = "all";
            }

            setTimeout(() => {
                window.location.href = redirectUrl;
            }, 800);
        });
    }

    // -------------------------------------------------------
    //  ÉNIGMES
    // -------------------------------------------------------
    const objetsEnigmes = document.querySelectorAll('.objet-enigme');

    objetsEnigmes.forEach(objet => {
        const activiteNum = parseInt(objet.getAttribute('data-activite'));
        const zone = objet.querySelector('.piece-zone');

        if (!zone) return;

        // effet néon rouge
        objet.style.filter = 'drop-shadow(0 0 8px rgba(255, 0, 0, 0.8)) drop-shadow(0 0 15px rgba(255, 0, 0, 0.6))';
        objet.style.animation = 'neonPulse 2s ease-in-out infinite';

        zone.addEventListener('mouseenter', () => {
            objet.style.filter = 'drop-shadow(0 0 15px rgba(255, 0, 0, 1)) drop-shadow(0 0 25px rgba(255, 0, 0, 0.8))';
        });

        zone.addEventListener('mouseleave', () => {
            objet.style.filter = 'drop-shadow(0 0 8px rgba(255, 0, 0, 0.8)) drop-shadow(0 0 15px rgba(255, 0, 0, 0.6))';
        });

        zone.addEventListener('click', () => {
            if (overlay) {
                overlay.style.opacity = '1';
                overlay.style.pointerEvents = 'all';
            }

            setTimeout(() => {
                window.location.href = baseUrl + '/enigme/' + activiteNum;
            }, 800);
        });
    });

    // -------------------------------------------------------
    // Popup explicatif
    // -------------------------------------------------------
    const popup = document.getElementById("popup-explication");
    if (popup) {
        setTimeout(() => {
            popup.style.display = "flex";
        }, 1000);

        window.addEventListener("click", (event) => {
            if (event.target === popup) {
                popup.style.display = "none";
            }
        });

        window.closePopup = function () {
            popup.style.display = "none";
        };
    }
});

// -------------------------------------------------------
// Tooltip mascotte
// -------------------------------------------------------
document.addEventListener("DOMContentLoaded", () => {
    const mascotte = document.querySelector(".mascotte-img");
    const bulle = document.getElementById("infobulle");

    mascotte.addEventListener("click", () => {
        // alterner visible / caché
        bulle.style.display = (bulle.style.display === "none") ? "block" : "none";
    });
});

// Correction retour navigateur
window.addEventListener("pageshow", () => {
    const overlay = document.getElementById("transition-overlay");
    if (overlay) {
        overlay.style.opacity = "0";
        overlay.style.pointerEvents = "none";
    }
});
