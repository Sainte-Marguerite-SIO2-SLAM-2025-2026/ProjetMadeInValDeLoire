// Fichier à créer : js/salle_6/mascotteHover.js
// Gestion du changement d'image au survol de la mascotte

document.addEventListener('DOMContentLoaded', function() {
    const mascotteImg = document.getElementById('mascotte');

    if (!mascotteImg) {
        console.warn('Image mascotte non trouvée');
        return;
    }

    // Récupérer les URLs depuis les attributs data
    const hoverSrc = mascotteImg.getAttribute('data-hover');
    const defaultSrc = mascotteImg.getAttribute('data-default');

    if (!hoverSrc || !defaultSrc) {
        console.warn('Attributs data-hover ou data-default manquants sur la mascotte');
        return;
    }

    // Événement mouseenter (survol)
    mascotteImg.addEventListener('mouseenter', function() {
        this.src = hoverSrc;
    });

    // Événement mouseleave (sortie du survol)
    mascotteImg.addEventListener('mouseleave', function() {
        this.src = defaultSrc;
    });
});