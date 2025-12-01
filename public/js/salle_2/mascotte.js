    document.addEventListener("DOMContentLoaded", () => {
    const mascotte = document.getElementById("mascotte");
    const bulle = document.getElementById("mascotte-bulle");
    const txt = document.getElementById("bulle-texte");

        const indices = [
            "<?= esc($indice) ?>"
        ];


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

    // Masque automatiquement la bulle après 6 secondes
    timer = setTimeout(() => {
    bulle.style.display = "none";
    mascotte.src = "<?= base_url('images/salle_2/mascotte/mascotte_face.svg') ?>";
}, 6000);

    // Change l'image de la mascotte pendant l'affichage
    mascotte.src = "<?= base_url('images/salle_2/mascotte/mascotte_exclamee.svg') ?>";
}

    // Survol mascotte
    mascotte.addEventListener("mouseenter", () => {
    mascotte.src = "<?= base_url('images/salle_2/mascotte/mascotte_exclamee.svg') ?>";
});
    mascotte.addEventListener("mouseleave", () => {
    if (bulle.style.display !== "block") {
    mascotte.src = "<?= base_url('images/salle_2/mascotte/mascotte_face.svg') ?>";
}
});

    // Clic mascotte
    mascotte.addEventListener("click", () => {
    if (bulle.style.display === "block") {
    bulle.style.display = "none";
    mascotte.src = "<?= base_url('images/salle_2/mascotte/mascotte_face.svg') ?>";
} else {
    afficherIndice();
}
});

    // Repositionnement dynamique
    window.addEventListener("resize", () => { if (bulle.style.display === "block") positionnerBulle(); });
    window.addEventListener("scroll", () => { if (bulle.style.display === "block") positionnerBulle(); });
});
