document.addEventListener('DOMContentLoaded', function() {
    const feedback = document.getElementById('feedback');
    const overlay = document.getElementById('transition-overlay');

    // ========================================
    // ÉNIGMES 1, 5, 6, 10 : Clics sur zones
    // ========================================
    const objetsCliquables = document.querySelectorAll('.objet-cliquable');
    const objetsValides = [];

    objetsCliquables.forEach(objet => {
        // Effet néon rouge
        objet.style.filter = 'drop-shadow(0 0 8px rgba(255, 0, 0, 0.8)) drop-shadow(0 0 15px rgba(255, 0, 0, 0.6))';

        objet.addEventListener('mouseenter', () => {
            if (!objetsValides.includes(objet)) {
                objet.style.filter = 'drop-shadow(0 0 15px rgba(255, 0, 0, 1)) drop-shadow(0 0 25px rgba(255, 0, 0, 0.8))';
            }
        });

        objet.addEventListener('mouseleave', () => {
            if (!objetsValides.includes(objet)) {
                objet.style.filter = 'drop-shadow(0 0 8px rgba(255, 0, 0, 0.8)) drop-shadow(0 0 15px rgba(255, 0, 0, 0.6))';
            }
        });

        objet.addEventListener('click', function() {
            if (objet.classList.contains('disabled') || objetsValides.includes(objet)) return;

            const reponse = objet.getAttribute('data-reponse');
            objetsCliquables.forEach(o => o.classList.add('disabled'));

            validerReponse(reponse, objet);
        });
    });

    // ========================================
    // Fonction générique de validation
    // ========================================
    function validerReponse(reponse, objet) {
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
                    // Bonne réponse
                    if (objet) {
                        objet.style.filter = 'drop-shadow(0 0 12px rgba(0, 255, 0, 1)) drop-shadow(0 0 25px rgba(0, 255, 0, 0.8))';
                        objetsValides.push(objet);
                    }

                    if (data.completed) {
                        // Énigme terminée
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
                        // Bonne réponse mais il en reste
                        feedback.textContent = '✅ ' + data.message + ' (' + data.reponses_trouvees + '/' + data.total_attendu + ')';
                        feedback.className = 'feedback success show';

                        setTimeout(() => {
                            objetsCliquables.forEach(o => {
                                if (!objetsValides.includes(o)) {
                                    o.classList.remove('disabled');
                                }
                            });
                            feedback.classList.remove('show');
                        }, 2000);
                    }
                } else {
                    // Mauvaise réponse
                    feedback.textContent = '❌ ' + data.message;
                    feedback.className = 'feedback error show';

                    setTimeout(() => {
                        objetsCliquables.forEach(o => {
                            if (!objetsValides.includes(o)) {
                                o.classList.remove('disabled');
                            }
                        });
                        feedback.classList.remove('show');
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                feedback.textContent = '❌ Erreur de connexion';
                feedback.className = 'feedback error show';
            });
    }
});

// ========================================
// ÉNIGME 7 : QCM
// ========================================
function validerQCM() {
    const selectedOption = document.querySelector('input[name="reponse"]:checked');

    if (!selectedOption) {
        const feedback = document.getElementById('feedback');
        feedback.textContent = '⚠️ Veuillez sélectionner une réponse';
        feedback.className = 'feedback error show';
        setTimeout(() => feedback.classList.remove('show'), 2000);
        return;
    }

    const reponse = selectedOption.value;

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
            const feedback = document.getElementById('feedback');
            const overlay = document.getElementById('transition-overlay');

            if (data.success && data.is_correct) {
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
                feedback.textContent = '❌ ' + data.message;
                feedback.className = 'feedback error show';
                setTimeout(() => feedback.classList.remove('show'), 2000);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
}