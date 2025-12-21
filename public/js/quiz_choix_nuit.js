document.addEventListener('DOMContentLoaded', () => {
    //zone lumi tooltip
    const lumi = document.querySelector('#lumi');
    const tooltip = document.getElementById('html-tooltip');

    if (lumi) {
        lumi.addEventListener('mouseenter', () => {
            // Récupérer le SVG parent
            const svg = lumi.closest('svg');
            const svgRect = svg.getBoundingClientRect();

            // Position de Lumi dans le SVG (x="1390" y="610")
            const lumiX = 1390;
            const lumiY = 610;
            const lumiWidth = 140;

            // Calculer la position réelle à l'écran
            const scaleX = svgRect.width / 1920;
            const scaleY = svgRect.height / 1080;

            const screenX = svgRect.left + (lumiX + lumiWidth / 2) * scaleX;
            const screenY = svgRect.top + lumiY * scaleY;

            // Positionner la tooltip
            const tooltipWidth = tooltip.offsetWidth;
            tooltip.style.left = (-60 + screenX - tooltipWidth / 2) + 'px';
            tooltip.style.top = (screenY - 120) + 'px'; // 50px au-dessus
            tooltip.style.display = 'block';
        });

        lumi.addEventListener('mouseleave', () => tooltip.style.display = 'none');
    }

    // Zone du miroir

    const miroir = document.querySelector('#zone-miroir');
    const tooltipMiroir = document.getElementById('miroir-tooltip');

    if (miroir && tooltipMiroir) {
        miroir.addEventListener('mouseenter', () => {
            const miroirRect = miroir.getBoundingClientRect();

            // Afficher d'abord pour obtenir les dimensions
            tooltipMiroir.style.display = 'block';

            // Récupérer les dimensions de la tooltip
            const tooltipMiroirWidth = tooltipMiroir.offsetWidth;
            const tooltipMiroirHeight = tooltipMiroir.offsetHeight;

            // Centrer  le point d'interrogation
            tooltipMiroir.style.left = (miroirRect.left + (miroirRect.width / 2) - (tooltipMiroirWidth / 2)) + 'px';
            tooltipMiroir.style.top = (miroirRect.top + (miroirRect.height / 2) - (tooltipMiroirHeight / 2)) + 'px';
        });
        miroir.addEventListener('mouseleave', () => {
            tooltipMiroir.style.display = 'none';
        });
        miroir.addEventListener('click', () => {

            // Ensuite passage à la dernière salle
            window.location.href =   window.location.href = `${baseUrl}quiz/demarrer/nuit` ;
        });
    }
});