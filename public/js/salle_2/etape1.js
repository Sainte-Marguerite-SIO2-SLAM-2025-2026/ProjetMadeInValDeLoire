document.addEventListener('DOMContentLoaded', () => {
    const editableLabel = document.querySelector('label.label-contour');
    const hiddenNom = document.getElementById('nom-hidden');
    const placeholder = 'Ecrire le Nom';

    if (!editableLabel || !hiddenNom) return;

    // Si on a une valeur serveur (old('nom')), l’afficher, sinon placeholder
    if (hiddenNom.value && hiddenNom.value.trim() !== '') {
        editableLabel.textContent = hiddenNom.value;
    } else {
        editableLabel.textContent = placeholder;
    }

    const isPlaceholder = () =>
        editableLabel.textContent.trim() === '' || editableLabel.textContent === placeholder;

    // Nettoie le placeholder à la prise de focus
    editableLabel.addEventListener('focus', () => {
        if (isPlaceholder()) {
            editableLabel.textContent = '';
            placeCaretAtEnd(editableLabel);
        }
    });

    // Restaure placeholder si vide à la perte de focus
    editableLabel.addEventListener('blur', () => {
        if (editableLabel.textContent.trim() === '') {
            editableLabel.textContent = placeholder;
        }
        syncToHidden();
    });

    // Empêche le retour à la ligne (Enter)
    editableLabel.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });

    // Synchronise à chaque saisie
    editableLabel.addEventListener('input', () => {
        syncToHidden();
    });

    function syncToHidden() {
        hiddenNom.value = isPlaceholder() ? '' : editableLabel.textContent;
    }

    function placeCaretAtEnd(el) {
        const range = document.createRange();
        const sel = window.getSelection();
        range.selectNodeContents(el);
        range.collapse(false);
        sel.removeAllRanges();
        sel.addRange(range);
        el.focus();
    }
});