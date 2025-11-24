const clavier = document.getElementById('clavier');
const formSVG = document.getElementById('formulaire-quiz');
const form = document.querySelector('#formulaire-quiz form');

clavier.addEventListener('click', (e) => {
    e.stopPropagation(); // évite le clic "fermeture"
    form.submit();
});

const retour = document.querySelector("#retour .retour-zone");
if (retour) {
    retour.addEventListener("click", () => {
        window.location.href = `${baseUrl}manoirJour` ;
    });
}
document.addEventListener('DOMContentLoaded', () => {
    //zone lumi tooltip
    const lumi = document.querySelector('#lumi');
    const tooltip = document.getElementById('html-tooltip');

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
            tooltip.style.left = (-100 + screenX - tooltipWidth / 2) + 'px';
            tooltip.style.top = (screenY - 120) + 'px'; // px au-dessus
            tooltip.style.display = 'block';
        });

        lumi.addEventListener('mouseleave', () => tooltip.style.display = 'none');
    }
});