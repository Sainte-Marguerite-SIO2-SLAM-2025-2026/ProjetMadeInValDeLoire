document.addEventListener("DOMContentLoaded", () => {
    const mots = document.querySelectorAll(".mot-cliquable");

    mots.forEach(mot => {
        const texte = mot.textContent.replace(/[.,!?;:]/g, '').toLowerCase();

        // Si le mot est dans la liste des mots suspects, on lui ajoute une classe spéciale
        if (motsSuspects.includes(texte)) {
            mot.classList.add("mot-suspect");

            mot.addEventListener("click", () => {
                mot.classList.add("mot-trouve");
                mot.classList.remove("mot-suspect");
            });
        }
    });
});
