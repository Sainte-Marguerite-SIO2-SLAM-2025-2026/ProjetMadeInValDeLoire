// Affiche la modal de victoire quand le joueur termine le jeu
function showVictoryModal() {
    document.getElementById('victoryOverlay').classList.remove('hidden');
    console.log('victoire ');
}
// Cache la modal de victoire
function hideVictoryModal() {
    document.getElementById('victoryOverlay').classList.add('hidden');
}
// Gère l'action quand le joueur clique sur le bouton de la modal
function handleVictoryButton() {
    // Modifier ici selon le choix (rejouer, retour menu, etc.)
    // choix actuel, retour avec reset
    console.log('Bouton victoire cliqué !');
    hideVictoryModal();
    window.location.href = `${baseUrl}reset`;
}

// Permet de fermer la modal avec la touche Échap
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideVictoryModal();
    }
});

document.addEventListener('DOMContentLoaded', () => {
    // Récupère toutes les pièces/salles du SVG
    const pieces = document.querySelectorAll('g.piece');
// Vérifie si toutes les salles sont terminées
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
// Réinitialise les classes
                piece.classList.remove('highlighted', 'inactive');
                // La salle courante est mise en évidence
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
//gestion de étiquettes
        function positionLabel(piece) {
            const label = piece.querySelector('.piece-label');
            const zone = piece.querySelector('.piece-zone');
            if (!label || !zone) return;

            let cx = 0, cy = 0;
            // Calcule le centre selon le type d'élément SVG
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
            // Clic : navigue vers la salle si c'est la salle active
            zone.addEventListener('click', () => {
                if (numero === currentRoom) {
                    window.location.href = `${baseUrl}salle/salle_${numero}`;
                }
            });
// Survol : augmente l'opacité de la salle active
            zone.addEventListener('mouseenter', () => {
                if (numero === currentRoom) {
                    const img = piece.querySelector('.piece-image');
                    if (img) img.style.opacity = '1';
                }
            });
            // Fin de survol : rétablit l'opacité normale
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
            // Affiche une modal Bootstrap
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
    //zone Lune tooltip
    const lune = document.querySelector('#lune_soleil');
    const tooltip = document.getElementById('html-tooltip');

    if (lune) {
        lune.addEventListener('mouseenter', () => tooltip.style.display = 'block');
        lune.addEventListener('mouseleave', () => tooltip.style.display = 'none');

        // déplacer la tooltip avec la souris
        lune.addEventListener('mousemove', (e) => {
            // on ajoute un petit offset pour éviter de couvrir le curseur
            const offset = 12;
            tooltip.style.left = (e.clientX + offset) + 'px';
            tooltip.style.top  = (e.clientY + offset) + 'px';
        });

        // utile pour accessibilité clavier
        lune.setAttribute('tabindex', '0');
        lune.addEventListener('focus', () => tooltip.style.display = 'block');
        lune.addEventListener('blur',  () => tooltip.style.display = 'none');
    }
});




