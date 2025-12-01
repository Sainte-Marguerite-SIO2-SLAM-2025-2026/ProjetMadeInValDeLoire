document.addEventListener("DOMContentLoaded", () => {
    const popup = document.querySelector(".popup");

    // Création du bouton de fermeture
    const closeBtn = document.createElement("button");
    closeBtn.innerHTML = "×";
    closeBtn.classList.add("close-btn");
    popup.querySelector(".popup-content").appendChild(closeBtn);

    closeBtn.addEventListener("click", () => popup.classList.add("hidden"));
    popup.addEventListener("click", e => { if (e.target === popup) popup.classList.add("hidden"); });
});