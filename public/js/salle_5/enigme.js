document.addEventListener('DOMContentLoaded', function() {
    const objetsCliquables = document.querySelectorAll('.objet-cliquable');
    const feedback = document.getElementById('feedback');
    const overlay = document.getElementById('transition-overlay');
    const objetsValides = []; // Stocker les objets déjà validés

    objetsCliquables.forEach(objet => {
        const zone = objet.querySelector('.zone-click');

        if (!zone) return;

        // Hover
        zone.addEventListener('mouseenter', () => {
            if (!objetsValides.includes(objet)) {
                objet.style.filter = 'drop-shadow(0 0 15px rgba(255, 255, 255, 1)) drop-shadow(0 0 25px rgba(255, 255, 255, 0.8))';
            }
        });

        zone.addEventListener('mouseleave', () => {
            if (!objetsValides.includes(objet)) {
                objet.style.filter = 'drop-shadow(0 0 0 rgba(0, 0, 0, 0)) drop-shadow(0 0 0 rgba(0, 0, 0, 0))';
            }
        });

        // Clic
        zone.addEventListener('click', function() {
            if (objet.classList.contains('disabled') || objetsValides.includes(objet)) return;

            const reponse = objet.getAttribute('data-reponse');

            // Désactiver temporairement tous les clics
            objetsCliquables.forEach(o => o.classList.add('disabled'));

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
                    if (data.success && data.is_correct) {
                        // ✅ BONNE RÉPONSE
                        objet.style.filter = 'drop-shadow(0 0 12px rgba(0, 255, 0, 1)) drop-shadow(0 0 25px rgba(0, 255, 0, 0.8))';
                        objet.classList.add('correct');
                        objetsValides.push(objet);

                        if (data.completed) {
                            // ÉNIGME TERMINÉE
                            feedback.textContent = '✅ ' + data.message;
                            feedback.className = 'feedback success show';

                            setTimeout(() => {
                                overlay.style.opacity = '1';
                                overlay.style.pointerEvents = 'all';

                                setTimeout(() => {
                                    window.location.href = base_url + '/Salle5';
                                }, 800);
                            }, 3000);
                        } else {
                            // 🔹 BONNE RÉPONSE mais il en reste - NE PAS AFFICHER DE MESSAGE
                            // Juste réactiver les objets non validés
                            objetsCliquables.forEach(o => {
                                if (!objetsValides.includes(o)) {
                                    o.classList.remove('disabled');
                                }
                            });
                        }
                    } else {
                        // ❌ MAUVAISE RÉPONSE - Redirection vers salle avec échec
                        feedback.textContent = '❌ ' + data.message;
                        feedback.className = 'feedback error show';

                        setTimeout(() => {
                            overlay.style.opacity = '1';
                            overlay.style.pointerEvents = 'all';

                            setTimeout(() => {
                                window.location.href = base_url + '/Salle5?echec=1&activite=' + activite_numero;
                            }, 800);
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    feedback.textContent = '❌ Erreur de connexion';
                    feedback.className = 'feedback error show';

                    setTimeout(() => {
                        objetsCliquables.forEach(o => {
                            if (!objetsValides.includes(o)) {
                                o.classList.remove('disabled');
                            }
                        });
                        feedback.classList.remove('show');
                    }, 2000);
                });
        });
    });
});