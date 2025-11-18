document.addEventListener("DOMContentLoaded", () => {
    const codeInput = document.getElementById("codeInput");
    const validerBtn = document.getElementById("validerCode");
    const message = document.getElementById("message");
    const popup = document.getElementById("popup");
    const popupFermer = document.getElementById("popup-fermer");

    const CODE_CORRECT = "4721"; // ✅ ton code secret à modifier

    validerBtn.addEventListener("click", () => {
        const code = codeInput.value.trim();

        if (code === CODE_CORRECT) {
            popup.style.display = "flex";
        } else {
            message.textContent = "❌ Mauvais code ! Réessaie...";
            message.style.color = "red";
        }
    });

    popupFermer.addEventListener("click", () => {
        popup.style.display = "none";
    });
});
