document.addEventListener("DOMContentLoaded", () => {
    // 🔹 Voile noir désactivé au chargement
    const overlay = document.getElementById("transition-overlay");
    if (overlay) {
        overlay.style.opacity = "0";
        overlay.style.pointerEvents = "none";
        overlay.style.transition = "opacity 0.8s ease";
    }

    // 🔹 Popup explicatif
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

    // 🔹 Mascotte : transition + redirection
    const mascotte = document.querySelector(".mascotte");
    if (mascotte && overlay) {
        mascotte.addEventListener("click", () => {
            overlay.style.opacity = "1";
            overlay.style.pointerEvents = "auto";

            const redirectUrl = mascotte.dataset.url || "/";
            setTimeout(() => {
                window.location.href = redirectUrl;
            }, 800);
        });
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
