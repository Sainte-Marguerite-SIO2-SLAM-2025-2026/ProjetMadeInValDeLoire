document.addEventListener('DOMContentLoaded', function() {
    const usbElements = document.querySelectorAll('.usb');
    const feedback = document.getElementById('feedback');

    usbElements.forEach(usb => {
        usb.addEventListener('click', function() {
            const cle = this.getAttribute('data-cle');

            // Désactiver tous les clics
            usbElements.forEach(u => u.style.pointerEvents = 'none');

            if (cle === 'B') {
                // Bonne réponse (USB anonyme)
                feedback.textContent = '❌ Correct ! Cette clé USB anonyme est suspecte.';
                feedback.style.color = '#4caf50';

                // Envoyer la validation au serveur
                fetch(base_url + 'validerEnigme', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'activite_numero': activite_numero,
                        'reponse': cle
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            setTimeout(() => {
                                window.location.href = base_url + 'accueilEnigme';
                            }, 2000);
                        }
                    });
            } else {
                feedback.textContent = '❌ Cette clé semble légitime. Réessayez !';
                feedback.style.color = '#f44336';
                setTimeout(() => {
                    usbElements.forEach(u => u.style.pointerEvents = 'all');
                    feedback.textContent = '';
                }, 2000);
            }
        });
    });
});