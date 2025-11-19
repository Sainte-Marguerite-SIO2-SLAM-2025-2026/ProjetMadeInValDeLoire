// ========================================
// DRAG & DROP POUR ÉNIGME 6
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    const objetsDrag = document.querySelectorAll('.objet-drag');
    const zoneDepot = document.getElementById('zone_depot');

    if (!zoneDepot || objetsDrag.length === 0) {
        console.log('Énigme 6 : éléments drag & drop non trouvés');
        return;
    }

    let objetDepose = null;

    objetsDrag.forEach(objet => {
        objet.addEventListener('dragstart', (e) => {
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', e.target.dataset.objet);
            e.target.style.opacity = '0.5';
        });

        objet.addEventListener('dragend', (e) => {
            e.target.style.opacity = '1';
        });
    });

    zoneDepot.addEventListener('dragover', (e) => {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        zoneDepot.style.backgroundColor = 'rgba(76, 175, 80, 0.1)';
    });

    zoneDepot.addEventListener('dragleave', () => {
        zoneDepot.style.backgroundColor = 'transparent';
    });

    zoneDepot.addEventListener('drop', (e) => {
        e.preventDefault();
        zoneDepot.style.backgroundColor = 'transparent';

        const objetNom = e.dataTransfer.getData('text/plain');
        objetDepose = objetNom;

        // Ajouter visuellement l'objet dans la zone
        const objetElement = document.querySelector(`[data-objet="${objetNom}"]`);
        if (objetElement) {
            const clone = objetElement.cloneNode(true);
            clone.draggable = false;
            clone.style.width = '60px';
            clone.style.margin = '5px';
            zoneDepot.appendChild(clone);

            // Masquer l'objet source
            objetElement.style.visibility = 'hidden';

            // Valider immédiatement avec AJAX
            fetch(base_url + '/validerEnigme', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    'activite_numero': activite_numero,
                    'reponse': objetNom
                })
            })
                .then(response => response.json())
                .then(data => {
                    const feedback = document.getElementById('feedback');
                    const overlay = document.getElementById('transition-overlay');

                    if (data.success && data.is_correct) {
                        // Effet vert sur la zone
                        zoneDepot.style.border = '3px solid #4caf50';
                        zoneDepot.style.backgroundColor = 'rgba(76, 175, 80, 0.2)';

                        // 🎭 Mascotte exclamée (bonne réponse)
                        if (window.changerMascotte) {
                            window.changerMascotte('exclamee', 2000);
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
                        }
                    } else {
                        // ❌ Mauvaise réponse - Redirection vers salle avec échec
                        feedback.textContent = '❌ ' + data.message;
                        feedback.className = 'feedback error show';

                        // 😱 Mascotte choquée (mauvaise réponse)
                        if (window.changerMascotte) {
                            window.changerMascotte('choquee', 2000);
                        }

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
                    const feedback = document.getElementById('feedback');
                    feedback.textContent = '❌ Erreur de connexion';
                    feedback.className = 'feedback error show';

                    setTimeout(() => {
                        feedback.classList.remove('show');
                    }, 2000);
                });
        }
    });
});