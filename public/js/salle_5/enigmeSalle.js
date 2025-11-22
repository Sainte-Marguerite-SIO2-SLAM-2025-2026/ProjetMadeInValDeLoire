document.addEventListener('DOMContentLoaded', function() {
    const feedback = document.getElementById('feedback');
    const overlay = document.getElementById('transition-overlay');

    // ========================================
    // ÉNIGMES 1, 5, 6, 10 : Clics sur zones
    // ========================================
    const objetsCliquables = document.querySelectorAll('.objet-cliquable');
    const objetsValides = [];

    objetsCliquables.forEach(objet => {
        objet.addEventListener('mouseenter', () => {
            if (!objetsValides.includes(objet)) {
                objet.style.filter = 'drop-shadow(0 0 15px rgba(255, 255, 255, 1)) drop-shadow(0 0 25px rgba(255, 255, 255, 0.8))';
            }
        });

        objet.addEventListener('mouseleave', () => {
            if (!objetsValides.includes(objet)) {
                objet.style.filter = 'none';
            }
        });

        objet.addEventListener('click', function() {
            if (objet.classList.contains('disabled') || objetsValides.includes(objet)) return;

            const reponse = objet.getAttribute('data-reponse');

            // Désactiver temporairement tous les clics
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
                    // ✅ BONNE RÉPONSE
                    if (objet) {
                        objet.style.filter = 'drop-shadow(0 0 12px rgba(0, 255, 0, 1)) drop-shadow(0 0 25px rgba(0, 255, 0, 0.8))';
                        objetsValides.push(objet);
                    }

                    // 🎭 Mascotte exclamée (bonne réponse)
                    if (window.changerMascotte) {
                        window.changerMascotte('exclamee', 2000);
                    }

                    if (data.completed) {
                        // ⛔ ÉNIGME TERMINÉE - BLOQUER TOUT
                        objetsCliquables.forEach(o => o.classList.add('disabled'));

                        feedback.innerHTML = '✅ ' + data.message + '<br>';
                        let btn = document.createElement('button');
                        btn.textContent = 'Suivant';
                        btn.style.cssText = 'cursor: pointer; margin-top: 20px; padding: 10px 25px; font-size: 1em; border: none; border-radius: 8px; background: #f4d03f; color: #2c1810; font-weight: 700; transition: all 0.3s ease;';
                        feedback.appendChild(btn);
                        feedback.className = 'feedback success show';

                        btn.addEventListener('click', () => {
                            overlay.style.opacity = '1';
                            overlay.style.pointerEvents = 'all';
                            setTimeout(() => {
                                window.location.href = base_url + '/Salle5';
                            }, 500);
                        });
                    } else {
                        // 🔹 BONNE RÉPONSE mais il en reste - Réactiver les objets non validés
                        objetsCliquables.forEach(o => {
                            if (!objetsValides.includes(o)) {
                                o.classList.remove('disabled');
                            }
                        });
                    }
                } else {
                    // ❌ MAUVAISE RÉPONSE - BLOQUER TOUT et afficher feedback
                    objetsCliquables.forEach(o => o.classList.add('disabled'));

                    feedback.innerHTML = '❌ ' + data.message + '<br><button id="next-btn">Suivant</button>';
                    feedback.className = 'feedback error show';

                    // 😱 Mascotte choquée (mauvaise réponse)
                    if (window.changerMascotte) {
                        window.changerMascotte('choquee', 2000);
                    }

                    document.getElementById('next-btn').addEventListener('click', () => {
                        overlay.style.opacity = '1';
                        overlay.style.pointerEvents = 'all';
                        window.location.href = base_url + '/Salle5?echec=1&activite=' + activite_numero;
                    });
                }
            })
            .catch(error => {
                console.error('Erreur:', error);

                // ⛔ ERREUR - BLOQUER TOUT
                objetsCliquables.forEach(o => o.classList.add('disabled'));

                feedback.innerHTML = '❌ Erreur de connexion<br><button id="next-btn">Réessayer</button>';
                feedback.className = 'feedback error show';

                document.getElementById('next-btn').addEventListener('click', () => {
                    // Réactiver les objets non validés
                    objetsCliquables.forEach(o => {
                        if (!objetsValides.includes(o)) {
                            o.classList.remove('disabled');
                        }
                    });
                    feedback.classList.remove('show');
                });
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

                // 🎭 Mascotte exclamée (bonne réponse)
                if (window.changerMascotte) {
                    window.changerMascotte('exclamee', 2000);
                }

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

                // 😱 Mascotte choquée (mauvaise réponse)
                if (window.changerMascotte) {
                    window.changerMascotte('choquee', 2000);
                }

                setTimeout(() => feedback.classList.remove('show'), 2000);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
}