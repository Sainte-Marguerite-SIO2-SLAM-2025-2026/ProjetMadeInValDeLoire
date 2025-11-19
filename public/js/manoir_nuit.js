document.addEventListener('DOMContentLoaded', () => {
    const pieces = document.querySelectorAll('g.piece');

    if (currentRoom === null || currentRoom === -1) {
        console.log("Toutes les salles sont complétées !");
       // return;
    }
    if (currentRoom !== -1) {
        // Met en lumière la salle active
        function highlightActiveRoom() {
            pieces.forEach(piece => {
                const numero = parseInt(piece.dataset.numero);
                const isCompleted = piece.classList.contains('completed');

                piece.classList.remove('highlighted', 'inactive');

                if (numero === currentRoom) {
                    piece.classList.add('highlighted');
                    positionLabel(piece);
                } else {
                    piece.classList.add('inactive');
                }

                const img = piece.querySelector('.piece-image');
                if (isCompleted && img) img.style.opacity = '0.6';
            });
        }

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

        // Gestion des clics
        pieces.forEach(piece => {
            const zone = piece.querySelector('.piece-zone');
            const numero = parseInt(piece.dataset.numero);

            zone.addEventListener('click', () => {
                if (numero === currentRoom) {
                    window.location.href = `${baseUrl}salle/salle_${numero}`;
                }
            });

            zone.addEventListener('mouseenter', () => {
                if (numero === currentRoom) {
                    const img = piece.querySelector('.piece-image');
                    if (img) img.style.opacity = '1';
                }
            });
            zone.addEventListener('mouseleave', () => {
                if (numero === currentRoom) {
                    const img = piece.querySelector('.piece-image');
                    if (img) img.style.opacity = '0.9';
                }
            });
        });

        highlightActiveRoom();
    }
    // Modal Lumi
    const lumiZone = document.querySelector("#lumi .lumi-zone");
    if (lumiZone) {
        lumiZone.addEventListener("click", function() {
            const modal = new bootstrap.Modal(document.getElementById('modalLumi'));
            modal.show();
        });
    }

    // Zone Lune
    const luneZone = document.querySelector("#lune_soleil .lune-zone");
    if (luneZone) {
        luneZone.addEventListener("click", function() {

            // Ensuite passage en mode jour
            window.location.href = `${baseUrl}resetSalleJour`;
        });
    }
});
