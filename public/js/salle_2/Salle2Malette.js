// Au chargement, si pas de succès, champ vidé et focus
(function () {
    'use strict';

    const form = document.getElementById('complex-form');
    const input = document.getElementById('code');
    const labelMsg = document.getElementById('label-message');

    // Récupère l'état de succès depuis un data-attribute du formulaire: data-success="true|false"
    const hasSuccess = (form?.dataset.success ?? '').toLowerCase() === 'true';

    try {
        if (!hasSuccess && input) {
            input.value = '';
            input.defaultValue = '';
            input.focus();
        }
    } catch (e) {
        // Optionnel: journaliser si nécessaire
        // console.error(e);
    }

    // Sur réinitialisation du formulaire, nettoyage du champ et du message
    form?.addEventListener('reset', function () {
        // Utiliser rAF pour attendre la réinit effective des champs
        window.requestAnimationFrame(() => {
            if (input) {
                input.value = '';
                input.defaultValue = '';
                input.setAttribute('placeholder', input.dataset.defaultPlaceholder || 'Saisissez le mot de passe');
                input.setAttribute('aria-invalid', 'false');
                input.focus();
            }
            if (labelMsg) {
                labelMsg.textContent = '';
                labelMsg.classList.add('is-hidden');
            }
        });
    });
})();