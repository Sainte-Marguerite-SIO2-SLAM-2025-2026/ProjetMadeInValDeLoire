document.addEventListener('DOMContentLoaded', () => {

    const objetsCliquables = document.querySelectorAll('.objet-cliquable');
    const zonesClick = [
        ...document.querySelectorAll('.zone-click'),
        ...document.querySelectorAll('.aucune')
    ];

    const feedback = document.getElementById('feedback');
    const overlay = document.getElementById('transition-overlay');
    const objetsValides = [];

    // ===============================
    // GESTION OBJETS CLIQUABLES
    // ===============================
    objetsCliquables.forEach(objet => {
        const zone = objet.querySelector('.zone-click');
        if (!zone) return;

        // -------- HOVER --------
        zone.addEventListener('mouseenter', () => {
            if (!objetsValides.includes(objet) && !objet.classList.contains('disabled')) {
                objet.style.filter =
                    'drop-shadow(0 0 15px rgba(255,255,255,1)) drop-shadow(0 0 25px rgba(255,255,255,0.8))';
            }
        });

        zone.addEventListener('mouseleave', () => {
            if (!objetsValides.includes(objet)) {
                objet.style.filter = 'none';
            }
        });

        // -------- CLICK --------
        zone.addEventListener('click', () => {
            if (objet.classList.contains('disabled') || objetsValides.includes(objet)) return;

            const reponse = objet.dataset.reponse;

            // Désactiver tout temporairement
            objetsCliquables.forEach(o => o.classList.add('disabled'));
            zonesClick.forEach(z => z.classList.add('disabled'));

            fetch(base_url + '/validerEnigme', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    activite_numero,
                    reponse
                })
            })
                .then(res => res.json())
                .then(data => {

                    // ================= BONNE REPONSE =================
                    if (data.success && data.is_correct) {
                        objet.style.filter =
                            'drop-shadow(0 0 12px rgba(0,255,0,1)) drop-shadow(0 0 25px rgba(0,255,0,0.8))';
                        objet.classList.add('correct');
                        objetsValides.push(objet);

                        if (window.changerMascotte) {
                            window.changerMascotte('exclamee', 2000);
                        }

                        // Enigme terminée
                        if (data.completed) {
                            feedback.innerHTML = `✅ ${data.message}<br>`;
                            const btn = document.createElement('button');
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
                        } else {
                            // Réactiver seulement les non validés
                            objetsCliquables.forEach(o => {
                                if (!objetsValides.includes(o)) o.classList.remove('disabled');
                            });
                            zonesClick.forEach(z => z.classList.remove('disabled'));
                        }

                        // ================= MAUVAISE REPONSE =================
                    } else {
                        feedback.innerHTML =
                            `❌ ${data.message}<br><button id="next-btn">Suivant</button>`;
                        feedback.className = 'feedback error show';

                        if (window.changerMascotte) {
                            window.changerMascotte('choquee', 2000);
                        }

                        document.getElementById('next-btn').addEventListener('click', () => {
                            overlay.style.opacity = '1';
                            overlay.style.pointerEvents = 'all';
                            window.location.href =
                                `${base_url}/salle/salle_5?echec=1&activite=${activite_numero}`;
                        });
                    }
                })
                .catch(() => {
                    feedback.innerHTML =
                        '❌ Erreur de connexion<br><button id="retry-btn">Réessayer</button>';
                    feedback.className = 'feedback error show';

                    document.getElementById('retry-btn').addEventListener('click', () => {
                        objetsCliquables.forEach(o => {
                            if (!objetsValides.includes(o)) o.classList.remove('disabled');
                        });
                        zonesClick.forEach(z => z.classList.remove('disabled'));
                        feedback.classList.remove('show');
                    });
                });
        });
    });

    // ===============================
    // TOOLTIP MASCOTTE (LUMI)
    // ===============================
    const lumiZone = document.querySelector('.lumi-zone');
    const bulle = document.getElementById('infobulle');

    if (lumiZone && bulle) {
        lumiZone.addEventListener('click', () => {
            const visible = bulle.style.display === 'block';
            bulle.style.display = visible ? 'none' : 'block';

            if (!visible) {
                setTimeout(() => {
                    bulle.style.display = 'none';
                }, 8000);
            }
        });
    }
});
