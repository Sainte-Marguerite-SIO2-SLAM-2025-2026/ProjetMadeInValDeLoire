
// Gestion de la mascotte et de la modal
const mascotteContainer = document.getElementById('mascotte-container');
const rulesModal = document.getElementById('rulesModal');
const startModal = document.getElementById('startModal');
const closeRules = document.querySelector('.close-rules');
const closeStart = document.querySelector('.close-start'); // ← ajoute un bouton de fermeture si besoin

// Ouvrir rulesModal
if (mascotteContainer) {
    mascotteContainer.addEventListener('click', function() {
        rulesModal.style.display = 'block';
    });
}

// Fermer rulesModal via le bouton
if (closeRules) {
    closeRules.addEventListener('click', function() {
        rulesModal.style.display = 'none';
    });
}

// Ouvrir startModal (à appeler quand tu veux l'afficher)
function openStartModal() {
    if (startModal) {
        startModal.style.display = 'block';
    }
}

// Fermer startModal via le bouton
if (closeStart) {
    closeStart.addEventListener('click', function() {
        startModal.style.display = 'none';
    });
}

// Fermer un modal en cliquant à côté (rulesModal + startModal)
window.addEventListener('click', function(event) {
    if (event.target === rulesModal) {
        rulesModal.style.display = 'none';
    }
    if (event.target === startModal) {
        startModal.style.display = 'none';
    }
});

// Fermer avec Échap
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        if (rulesModal && rulesModal.style.display === 'block') {
            rulesModal.style.display = 'none';
        }
        if (startModal && startModal.style.display === 'block') {
            startModal.style.display = 'none';
        }
    }
});