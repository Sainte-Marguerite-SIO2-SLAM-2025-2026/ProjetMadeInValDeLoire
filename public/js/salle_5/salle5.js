document.addEventListener("DOMContentLoaded", () => {
    // 🔹 Voile noir désactivé au chargement
    const overlay = document.getElementById("transition-overlay");
    if (overlay) {
        overlay.style.opacity = "0";
        overlay.style.pointerEvents = "none";
        overlay.style.transition = "opacity 0.8s ease";
    }

    // Récupérer tous les groupes d'objets énigmes
    const objetsEnigmes = document.querySelectorAll('.objet-enigme');
    const baseUrl = document.body.dataset.baseurl;


    objetsEnigmes.forEach(objet => {
        const activiteNum = parseInt(objet.getAttribute('data-activite'));
        const zone = objet.querySelector('.piece-zone');

        if (!zone) return;

        // Appliquer l'effet néon rouge pour les énigmes non réussies
        objet.style.filter = 'drop-shadow(0 0 8px rgba(255, 0, 0, 0.8)) drop-shadow(0 0 15px rgba(255, 0, 0, 0.6))';
        objet.style.animation = 'neonPulse 2s ease-in-out infinite';

        // Hover effect
        zone.addEventListener('mouseenter', () => {
            objet.style.filter = 'drop-shadow(0 0 15px rgba(255, 0, 0, 1)) drop-shadow(0 0 25px rgba(255, 0, 0, 0.8))';
        });

        zone.addEventListener('mouseleave', () => {
            objet.style.filter = 'drop-shadow(0 0 8px rgba(255, 0, 0, 0.8)) drop-shadow(0 0 15px rgba(255, 0, 0, 0.6))';
        });

        // Redirection au clic
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


    // 🔹 Popup explicatif (seulement si présent dans le DOM)
    const popup = document.getElementById("popup-explication");
    if (popup) {
        // Afficher la popup après 1 seconde
        setTimeout(() => {
            popup.style.display = "flex";
        }, 1000);

        // Fermer en cliquant en dehors
        window.addEventListener("click", (event) => {
            if (event.target === popup) {
                popup.style.display = "none";
            }
        });

        // Fonction pour fermer la popup
        window.closePopup = function () {
            popup.style.display = "none";
        };
    }
});

// 🔁 Correction du retour navigateur (pageshow = même si cache)
window.addEventListener("pageshow", () => {
    const overlay = document.getElementById("transition-overlay");
    if (overlay) {
        overlay.style.opacity = "0";
        overlay.style.pointerEvents = "none";
    }
});