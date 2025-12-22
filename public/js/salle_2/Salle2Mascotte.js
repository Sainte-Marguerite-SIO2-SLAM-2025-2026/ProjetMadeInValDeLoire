// Bulle de mascotte avec sécurité d'image et indices cycliques
document.addEventListener('DOMContentLoaded', () => {
    const mascotte = document.getElementById('mascotte');
    const bulle = document.getElementById('mascotte-bulle');
    const txt = document.getElementById('bulle-texte');

    // Sécurité d'image
    const srcInitiale = mascotte.getAttribute('src') || '';
    mascotte.onerror = function() {
        console.warn('Image introuvable, restauration de la mascotte de base.');
        this.onerror = null;
        if (srcInitiale) this.src = srcInitiale;
    };

    const mascotteContainer = mascotte.closest('.mascotte-container') || mascotte.parentElement;
    const baseUrl = typeof BASE_URL !== 'undefined' ? BASE_URL : '';
    const indices = Array.isArray(INDICES) && INDICES.length > 0 ? INDICES : ['Aucun indice disponible'];

    // Préchargement des variantes de la mascotte
    const imgInterrogee = new Image();
    imgInterrogee.src = baseUrl + '../images/salle_2/mascotte/mascotte_interrogee.svg';
    const imgExclamee = new Image();
    imgExclamee.src = baseUrl + '../images/salle_2/mascotte/mascotte_exclamee.svg';

    let index = 0;
    let timer = null;

    function positionnerBulle() {
        const r = mascotteContainer.getBoundingClientRect();
        bulle.style.left = Math.max(10, r.left + r.width / 2 - bulle.offsetWidth / 2) + 'px';
        bulle.style.top = r.top - bulle.offsetHeight - 20 + 'px';
    }

    function afficherIndice() {
        clearTimeout(timer);
        txt.textContent = indices[index];
        index = (index + 1) % indices.length;

        bulle.style.display = 'block';
        bulle.style.top = '';
        bulle.style.height = 'auto';
        positionnerBulle();

        const targetSrc = baseUrl + '../images/salle_2/mascotte/mascotte_interrogee.svg';
        if (mascotte.src !== targetSrc) {
            mascotte.src = targetSrc;
        }

        timer = setTimeout(() => {
            fermerBulle();
        }, 5000);
    }

    function fermerBulle() {
        bulle.style.display = 'none';
        if (srcInitiale) mascotte.src = srcInitiale;
    }

    // Événements
    mascotte.addEventListener('mouseenter', () => {
        if (bulle.style.display !== 'block') {
            mascotte.src = baseUrl + '../images/salle_2/mascotte/mascotte_interrogee.svg';
        }
    });

    mascotte.addEventListener('mouseleave', () => {
        if (bulle.style.display !== 'block') {
            if (srcInitiale) mascotte.src = srcInitiale;
        }
    });

    mascotte.addEventListener('click', (e) => {
        e.stopPropagation();
        afficherIndice();
    });

    document.addEventListener('click', (e) => {
        const outsideMascotte = !mascotteContainer.contains(e.target);
        const outsideBulle = !bulle.contains(e.target);
        if (bulle.style.display === 'block' && outsideMascotte && outsideBulle) {
            fermerBulle();
        }
    });

    window.addEventListener('resize', () => {
        if (bulle.style.display === 'block') positionnerBulle();
    });

    window.addEventListener('scroll', () => {
        if (bulle.style.display === 'block') positionnerBulle();
    });
});