document.addEventListener('DOMContentLoaded', function() {
    // Récupération des infos depuis le HTML
    const scene = document.getElementById('scene-enigme');
    const usbElements = document.querySelectorAll('.usb');
    const feedback = document.getElementById('feedback');

    const base_url = scene.dataset.baseurl;         // base_url fourni par PHP
    const activite_numero = scene.dataset.activite; // numéro de l'activité

    usbElements.forEach(usb => {
        usb.addEventListener('click', function() {
            const cle = this.dataset.cle;

            // Désactive tous les clics pendant le traitement
            usbElements.forEach(u => u.style.pointerEvents = 'none');

            // Envoi au contrôleur pour validation
            console.log('Fetch vers :', base_url + 'Salle5/validerEnigme');
            fetch(base_url + 'Salle5/validerEnigme', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    'activite_numero': activite_numero,
                    'reponse': cle
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        feedback.textContent = '✅ Bonne réponse !';
                        feedback.style.color = '#4caf50';

                        // Redirection après 1.5s vers l'accueil des énigmes
                        setTimeout(() => {
                            window.location.href = base_url + 'mascotte';
                        }, 1500);
                    } else {
                        feedback.textContent = data.message || '❌ Mauvaise réponse !';
                        feedback.style.color = '#f44336';

                        // Réactive les clics pour réessayer
                        setTimeout(() => {
                            usbElements.forEach(u => u.style.pointerEvents = 'auto');
                            feedback.textContent = '';
                        }, 2000);
                    }
                })
                .catch(err => {
                    feedback.textContent = '⚠️ Erreur serveur.';
                    feedback.style.color = '#f44336';
                    usbElements.forEach(u => u.style.pointerEvents = 'auto');
                    console.error(err);
                });
        });
    });
});
