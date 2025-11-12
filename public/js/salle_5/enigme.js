document.addEventListener('DOMContentLoaded', function() {
    const objetsCliquables = document.querySelectorAll('.objet-cliquable');
    const feedback = document.getElementById('feedback');
    const overlay = document.getElementById('transition-overlay');

    objetsCliquables.forEach(objet => {
        const zone = objet.querySelector('.zone-click');

        if (!zone) return;

        // Effet néon rouge pulsant
        objet.style.filter = 'drop-shadow(0 0 8px rgba(255, 0, 0, 0.8)) drop-shadow(0 0 15px rgba(255, 0, 0, 0.6))';
        objet.style.animation = 'pulse-neon 2s ease-in-out infinite';

        // Hover
        zone.addEventListener('mouseenter', () => {
            objet.style.filter = 'drop-shadow(0 0 15px rgba(255, 0, 0, 1)) drop-shadow(0 0 25px rgba(255, 0, 0, 0.8))';
        });

        zone.addEventListener('mouseleave', () => {
            objet.style.filter = 'drop-shadow(0 0 8px rgba(255, 0, 0, 0.8)) drop-shadow(0 0 15px rgba(255, 0, 0, 0.6))';
        });

        // Clic
        zone.addEventListener('click', function() {
            if (objet.classList.contains('disabled')) return;

            const reponse = objet.getAttribute('data-reponse');

            // Désactiver tous les clics
            objetsCliquables.forEach(o => o.classList.add('disabled'));
            objet.classList.add('selected');

            // Envoyer au serveur
            fetch(base_url + '/validerEnigme', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    'activite_numero': activite_numero,
                    'reponse': reponse
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        feedback.textContent = '✅ ' + data.message;
                        feedback.className = 'feedback success show';
                        objet.classList.add('correct');

                        setTimeout(() => {
                            overlay.style.opacity = '1';
                            overlay.style.pointerEvents = 'all';
                            setTimeout(() => {
                                window.location.href = base_url + '/Salle5';
                            }, 800);
                        }, 2500);
                    } else {
                        feedback.textContent = '❌ ' + data.message;
                        feedback.className = 'feedback error show';
                        objet.classList.add('incorrect');

                        setTimeout(() => {
                            objetsCliquables.forEach(o => {
                                o.classList.remove('disabled', 'selected', 'incorrect');
                            });
                            feedback.classList.remove('show');
                        }, 2500);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    feedback.textContent = '❌ Erreur de connexion';
                    feedback.className = 'feedback error show';

                    setTimeout(() => {
                        objetsCliquables.forEach(o => o.classList.remove('disabled', 'selected'));
                        feedback.classList.remove('show');
                    }, 2000);
                });
        });
    });
});