document.addEventListener("DOMContentLoaded", () => {
    // 🔹 Voile noir désactivé au chargement
    const overlay = document.getElementById("transition-overlay");
    if (overlay) {
        overlay.style.opacity = "0";
        overlay.style.pointerEvents = "none";
        overlay.style.transition = "opacity 0.8s ease";
    }

    // 🔹 Clés USB : feedback
    const feedback = document.getElementById("feedback");
    const usbKeys = document.querySelectorAll(".usb");

    usbKeys.forEach((key) => {
        key.addEventListener("click", () => {
            const cle = key.dataset.cle;
            if (!feedback) return;

            if (cle === "B") {
                feedback.innerHTML = "<strong>Bonne réponse !</strong> Cette clé peut contenir un malware (attaque BadUSB).";
                feedback.classList.add("success");
            } else {
                if (cle === "A"){
                    feedback.innerHTML = "Mauvaise réponse. La clé Finance appartient à l’entreprise.";
                    feedback.classList.remove("success");
                }else {
                        feedback.innerHTML = "Mauvaise réponse. La clé RH appartient à l’entreprise.";
                        feedback.classList.remove("success");
                    }

            }
        });
    });

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
