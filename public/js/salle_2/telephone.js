// public/js/salle_2/telephone.js

document.addEventListener('DOMContentLoaded', function () {
    const phoneDiv     = document.getElementById('genere-telephone');
    const displaySpan  = document.getElementById('password-display');
    const hiddenCode   = document.getElementById('code-hidden');
    const errorBox     = document.getElementById('code-error');
    const validateBtn  = document.getElementById('btn-validate');

    if (!phoneDiv || !displaySpan || !hiddenCode) return;

    let generating = false;

    phoneDiv.addEventListener('click', function () {
        if (generating) return;

        // Récupération de l'URL depuis l'attribut HTML data-url
        // C'est ici que la magie opère pour éviter le PHP dans le JS
        const url = phoneDiv.dataset.url;

        if (errorBox) {
            errorBox.textContent = '';
            errorBox.style.display = 'none';
        }

        generating = true;
        phoneDiv.classList.add('loading');
        phoneDiv.setAttribute('aria-busy', 'true');

        fetch(url, { // On utilise la variable url ici
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) throw new Error('Réponse HTTP invalide');
                return response.json();
            })
            .then(data => {
                if (data.status === 'ok') {
                    const password = (data.password || '').trim();
                    displaySpan.textContent = password;
                    hiddenCode.value = password;
                } else {
                    displaySpan.textContent = '';
                    hiddenCode.value = '';
                    alert(data.message || 'Erreur lors de la génération du code');
                }
            })
            .catch(err => {
                console.error(err);
                displaySpan.textContent = '';
                hiddenCode.value = '';
                alert('Erreur réseau lors de la génération du code');
            })
            .finally(() => {
                generating = false;
                phoneDiv.classList.remove('loading');
                phoneDiv.removeAttribute('aria-busy');
            });
    });

    if (validateBtn) {
        validateBtn.addEventListener('click', () => {
        });
    }
});