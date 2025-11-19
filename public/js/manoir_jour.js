
    document.addEventListener('DOMContentLoaded', () => {
    const pieces = document.querySelectorAll('g.piece');

        pieces.forEach(piece => {
            const numero = parseInt(piece.dataset.numero);

            if (completedRooms.includes(numero)) {
                piece.classList.add('completed');
            }

            if (failedRooms.includes(numero)) {
                piece.classList.add('failed');
            }
        });

    // Positionne le label au centre de la salle
    function positionLabel(piece) {
    const label = piece.querySelector('.piece-label');
    const zone = piece.querySelector('.piece-zone');

    if (!label || !zone) return;

    let cx = 0, cy = 0;

    if (zone.tagName === 'rect') {
    cx = parseFloat(zone.getAttribute('x')) + parseFloat(zone.getAttribute('width')) / 2;
    cy = parseFloat(zone.getAttribute('y')) + parseFloat(zone.getAttribute('height')) / 2;
} else if (zone.tagName === 'path') {
    const bbox = zone.getBBox();
    cx = bbox.x + bbox.width / 2;
    cy = bbox.y + bbox.height / 2;
}

    label.setAttribute('x', cx - parseFloat(label.getAttribute('width')) / 2);
    label.setAttribute('y', cy - parseFloat(label.getAttribute('height')) / 2);
}

    // Initialisation : affiche toutes les étiquettes et images
    pieces.forEach(piece => {
    const isCompleted = piece.classList.contains('completed');

    // Affiche toujours l'étiquette
    const label = piece.querySelector('.piece-label');
    if (label) {
    label.style.opacity = '1';
    positionLabel(piece);
}

    // Affiche l'image des salles complétées
    const img = piece.querySelector('.piece-image');
    if (isCompleted && img) {
    img.style.opacity = '0.6';
}
});

    // Gestion des clics - toutes les salles sont cliquables
    pieces.forEach(piece => {
    const zone = piece.querySelector('.piece-zone');
    const numero = parseInt(piece.dataset.numero);

    zone.addEventListener('click', () => {
    // Toutes les salles sont cliquables
        window.location.href = `${baseUrl}salle/salle_${numero}`;
});

    // Hover effect sur toutes les salles
    zone.addEventListener('mouseenter', () => {
    const img = piece.querySelector('.piece-image');
    if (img) {
    // Si la salle n'est pas complétée, montre l'image au survol
    if (!piece.classList.contains('completed')) {
    img.style.opacity = '0.5';
} else {
    img.style.opacity = '0.8';
}
}
});

    zone.addEventListener('mouseleave', () => {
    const img = piece.querySelector('.piece-image');
    if (img) {
    // Retour à l'opacité d'origine
    if (!piece.classList.contains('completed')) {
    img.style.opacity = '0';
} else {
    img.style.opacity = '0.6';
}
}
});
});
});

    // Modal Lumi
    document.addEventListener("DOMContentLoaded", function() {
    const lumiZone = document.querySelector("#lumi .lumi-zone");
    if (lumiZone) {
    lumiZone.addEventListener("click", function() {
    const modal = new bootstrap.Modal(document.getElementById('modalLumi'));
    modal.show();
});
}
});

    // Zone Lune/Soleil
    document.addEventListener("DOMContentLoaded", function() {
    const luneZone = document.querySelector("#lune_soleil .lune-zone");
    if (luneZone) {
    luneZone.addEventListener("click", function() {
        window.location.href = `${baseUrl}/reset`;
});
}
});

    // Zone Quiz
    document.addEventListener("DOMContentLoaded", function() {
        const quizzZone = document.querySelector("#quizz .quizz-zone");
        if (quizzZone) {
            quizzZone.addEventListener("click", function() {
                window.location.href = `${baseUrl}quiz`;
            });
        }
    });
