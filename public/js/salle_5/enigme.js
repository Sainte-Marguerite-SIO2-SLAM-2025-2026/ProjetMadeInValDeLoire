document.addEventListener('DOMContentLoaded', function() {
    const objetsCliquables = document.querySelectorAll('.objet-cliquable');
    const zoneClick = [
        ...document.querySelectorAll('.zone-click'),
        ...document.querySelectorAll('.aucune')
    ];    const feedback = document.getElementById('feedback');
    const overlay = document.getElementById('transition-overlay');
    const objetsValides = []; // Stocker les objets déjà validés

    objetsCliquables.forEach(objet => {
        const zone = objet.querySelector('.zone-click');
        if (!zone) return;

        // Hover
        zone.addEventListener('mouseenter', () => {
            if (!objetsValides.includes(objet)&& !objet.classList.contains('disabled')) {
                objet.style.filter = 'drop-shadow(0 0 15px rgba(255, 255, 255, 1)) drop-shadow(0 0 25px rgba(255, 255, 255, 0.8))';
            }
        });

        zone.addEventListener('mouseleave', () => {
            if (!objetsValides.includes(objet) && !objet.classList.contains('disabled')) {
                objet.style.filter = 'drop-shadow(0 0 0 rgba(0, 0, 0, 0)) drop-shadow(0 0 0 rgba(0, 0, 0, 0))';
            }
        });

        // Clic
        zone.addEventListener('click', function() {
            if (objet.classList.contains('disabled') || objetsValides.includes(objet)) return;

            const reponse = objet.getAttribute('data-reponse');

            // Désactiver temporairement tous les clics
            objetsCliquables.forEach(o => o.classList.add('disabled'));
            zoneClick.forEach(z => z.classList.add('disabled'));

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

                        // 🎭 Mascotte exclamée
                        if (window.changerMascotte) window.changerMascotte('exclamee', 2000);

                        // Afficher le feedback avec bouton
                        if (data.completed) {
                            feedback.innerHTML = '✅ ' + data.message + '<br>';
                            let btn = document.createElement('button');
                            btn.textContent = 'Suivant';
                            feedback.appendChild(btn);
                            feedback.className = 'feedback success show';

                            btn.addEventListener('click', () => {
                                overlay.style.opacity = '1';
                                overlay.style.pointerEvents = 'all';
                                setTimeout(() => {
                                    window.location.href = base_url + '/salle/salle_5';
                                }, 500);
                            });
                        }else{// Réactiver les objets non validés
                            objetsCliquables.forEach(o => {
                                if (!objetsValides.includes(o)) o.classList.remove('disabled');
                            });
                            zoneClick.forEach(z => {
                                if (!objetsValides.includes(z)) z.classList.remove('disabled');
                            });}



                    } else {
                        // ❌ MAUVAISE RÉPONSE
                        feedback.innerHTML = '❌ ' + data.message + '<br><button id="next-btn">Suivant</button>';
                        feedback.className = 'feedback error show';

                        // 😱 Mascotte choquée
                        if (window.changerMascotte) window.changerMascotte('choquee', 2000);

                        document.getElementById('next-btn').addEventListener('click', () => {
                            overlay.style.opacity = '1';
                            overlay.style.pointerEvents = 'all';
                            window.location.href = base_url + '/salle/salle_5?echec=1&activite=' + activite_numero;
                        });
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    feedback.innerHTML = '❌ Erreur de connexion<br><button id="next-btn">Réessayer</button>';
                    feedback.className = 'feedback error show';

                    document.getElementById('next-btn').addEventListener('click', () => {
                        // Réactiver les objets non validés
                        objetsCliquables.forEach(o => {
                            if (!objetsValides.includes(o)) o.classList.remove('disabled');
                        });
                        feedback.classList.remove('show');
                    });
                });
        });
    });
});

// -------------------------------------------------------
// Tooltip mascotte
// -------------------------------------------------------
document.addEventListener("DOMContentLoaded", () => {
    const btn = document.querySelector(".lumi-zone");
    const bulle = document.getElementById("infobulle");

    btn.addEventListener("click", () => {
        if (bulle.style.display === "none" || bulle.style.display === "") {
            bulle.style.display = "block";
            setTimeout(() => {
                bulle.style.display = "none";
            }, 8000);
        } else {
            bulle.style.display = "none";
        }
    });
});
