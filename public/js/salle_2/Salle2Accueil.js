// Animation du titre lettre par lettre et activation des états CSS pour le reveal
document.addEventListener('DOMContentLoaded', () => {
    // Découpe le contenu de .site-title en spans pour animer chaque lettre
    splitLetters(document.querySelector('.site-title'), 'title-letter', 0.12, 12);

    // Déclenche les transitions CSS de la carte et des boutons
    document.body.classList.add('animate');
    requestAnimationFrame(() => {
        document.body.classList.add('ready');
    });
});

// Transforme le texte d un élément en lettres animables
function splitLetters(rootEl, spanClass, delayStep = 0.1, group = 10) {
    // Sécurité si aucun élément ou si déjà transformé
    if (!rootEl) return;
    if (rootEl.querySelector(`.${spanClass}`)) return;

    // Récupère le texte puis vide l élément
    const text = rootEl.textContent;
    rootEl.textContent = '';

    // Crée un span par caractère avec décalage d animation échelonné
    Array.from(text).forEach((ch, i) => {
        const span = document.createElement('span');
        span.className = spanClass;
        // Préserve les espaces avec un espace insécable pour éviter les retours imprévus
        span.textContent = ch === ' ' ? '\u00A0' : ch;
        // Délai d animation calculé par groupes pour un effet de vague
        span.style.animationDelay = `${(i % group) * delayStep}s`;
        rootEl.appendChild(span);
    });
}