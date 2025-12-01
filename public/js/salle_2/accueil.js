// Titre animé par lettres. Aucune animation du fond, ni des paragraphes.
document.addEventListener('DOMContentLoaded', () => {
    splitLetters(document.querySelector('.site-title'), 'title-letter', 0.12, 12);

    // Active juste le reveal doux de la carte/boutons (non continu)
    document.body.classList.add('animate');
    requestAnimationFrame(() => {
        document.body.classList.add('ready');
    });
});

function splitLetters(rootEl, spanClass, delayStep = 0.1, group = 10) {
    if (!rootEl) return;
    if (rootEl.querySelector(`.${spanClass}`)) return;

    const text = rootEl.textContent;
    rootEl.textContent = '';

    Array.from(text).forEach((ch, i) => {
        const span = document.createElement('span');
        span.className = spanClass;
        span.textContent = ch === ' ' ? '\u00A0' : ch;
        span.style.animationDelay = `${(i % group) * delayStep}s`;
        rootEl.appendChild(span);
    });
}