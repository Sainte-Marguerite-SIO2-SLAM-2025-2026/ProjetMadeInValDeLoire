
document.addEventListener("DOMContentLoaded", function() {
    const choices = document.querySelectorAll(".choice");
    const input = document.getElementById("propositionInput");
    const form = document.getElementById("quiz-form");

    let selected = null;

    choices.forEach(choice => {
        choice.addEventListener("click", function() {
            // Désélection visuelle
            choices.forEach(c => c.classList.remove("selected"));
            this.classList.add("selected");

            // Stocke l'ID réel dans le champ caché
            const id = this.getAttribute("data-id");
            input.value = id;
            selected = id;
        });
    });

    // Valider via la zone SVG "clavier"
    const zoneValider = document.getElementById("clavier");
    if (zoneValider) {
        zoneValider.addEventListener("click", function() {
            if (input.value) {
                form.submit();
            } else {
                alert("Il faut choisir une réponse avant de valider !");
            }
        });
    }
    //  progression actuelle-->
    const progression =progressionNiveau; // en pourcentage
    const progressRect = document.getElementById("progressFill");

    // largeur maximale
    const maxWidth = 700;

    // la largeur à remplir
    const fillWidth = (progression / 100) * maxWidth;

    // animer la barre
    progressRect.setAttribute("width", fillWidth);
});

const retour = document.querySelector("#retour .retour-zone");
if (retour) {
    retour.addEventListener("click", () => {
        window.location.href = `${baseUrl}` ;
    });
}

//zone lumi tooltip
const lumi = document.querySelector('#lumi');
const tooltip = document.getElementById('html-tooltip-question');

if (lumi) {
    lumi.addEventListener('mouseenter', () => {
        // Récupérer le SVG parent
        const svg = lumi.closest('svg');
        const svgRect = svg.getBoundingClientRect();

        // Position de Lumi dans le SVG ( x="1722" y="741")
        const lumiX = 1722;
        const lumiY = 741;
        const lumiWidth = 140;

        // Calculer la position réelle à l'écran
        const scaleX = svgRect.width / 1920;
        const scaleY = svgRect.height / 1080;

        const screenX = svgRect.left + (lumiX + lumiWidth / 2) * scaleX;
        const screenY = svgRect.top + lumiY * scaleY;

        // Positionner la tooltip
        const tooltipWidth = tooltip.offsetWidth;
        tooltip.style.left = (-90 + screenX - tooltipWidth / 2) + 'px';
        tooltip.style.top = (screenY - 190) + 'px'; //  au-dessus
        tooltip.style.display = 'block';
    });

    lumi.addEventListener('mouseleave', () => tooltip.style.display = 'none');
}