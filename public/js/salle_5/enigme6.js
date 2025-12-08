// ========================================
// DRAG & DROP POUR ÉNIGME 6
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    const objetsDrag = document.querySelectorAll('.objet-drag');
    const zoneDepot = document.getElementById('zone_depot');
    const btn = document.querySelector(".lumi-zone");
    const bulle = document.getElementById("infobulle");

    btn.addEventListener("click", () => {
        if (bulle.style.display === "none" || bulle.style.display === "") {
            bulle.style.display = "block";
            setTimeout(() => {
                bulle.style.display = "none";
            }, 8000);
        }
    });

    if (!zoneDepot || objetsDrag.length === 0) {
        console.log('Énigme 6 : éléments drag & drop non trouvés');
        return;
    }

    let objetDepose = null;
    let dragDisabled = false; // Flag pour bloquer le drag

    objetsDrag.forEach(objet => {
        objet.addEventListener('dragstart', (e) => {
            // Bloquer le drag si désactivé
            if (dragDisabled) {
                e.preventDefault();
                return;
            }

            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', e.target.dataset.objet);
            e.target.style.opacity = '0.5';
        });

        objet.addEventListener('dragend', (e) => {
            e.target.style.opacity = '1';
        });
    });

    zoneDepot.addEventListener('dragover', (e) => {
        if (dragDisabled) return;

        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        zoneDepot.style.backgroundColor = 'rgba(76, 175, 80, 0.1)';
    });

    zoneDepot.addEventListener('dragleave', () => {
        if (dragDisabled) return;
        zoneDepot.style.backgroundColor = 'transparent';
    });

    zoneDepot.addEventListener('drop', (e) => {
        if (dragDisabled) return;

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

            // ⛔ DÉSACTIVER TOUS LES DRAGS pendant la validation
            dragDisabled = true;
            objetsDrag.forEach(obj => {
                obj.draggable = false;
                obj.style.opacity = '0.5';
                obj.style.cursor = 'not-allowed';
            });

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
                            // ⛔ ÉNIGME TERMINÉE - TOUT RESTE BLOQUÉ
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
                                    window.location.href = base_url + '/salle/salle_5';
                                }, 500);
                            });
                        } else {
                            // Bonne réponse mais pas fini - réactiver les objets non déposés
                            dragDisabled = false;
                            objetsDrag.forEach(obj => {
                                if (obj.style.visibility !== 'hidden') {
                                    obj.draggable = true;
                                    obj.style.opacity = '1';
                                    obj.style.cursor = 'grab';
                                }
                            });
                        }
                    } else {
                        // ❌ MAUVAISE RÉPONSE - TOUT RESTE BLOQUÉ
                        feedback.innerHTML = '❌ ' + data.message + '<br>';

                        // Créer le bouton proprement
                        let btnError = document.createElement('button');
                        btnError.id = 'next-btn';
                        btnError.textContent = 'Suivant';
                        btnError.style.cssText = 'cursor: pointer; margin-top: 20px; padding: 10px 25px; font-size: 1em; border: none; border-radius: 8px; background: #f4d03f; color: #2c1810; font-weight: 700; transition: all 0.3s ease;';
                        feedback.appendChild(btnError);

                        feedback.className = 'feedback error show';

                        // 😱 Mascotte choquée (mauvaise réponse)
                        if (window.changerMascotte) {
                            window.changerMascotte('choquee', 2000);
                        }

                        btnError.addEventListener('click', () => {
                            overlay.style.opacity = '1';
                            overlay.style.pointerEvents = 'all';
                            window.location.href = base_url + '/salle/salle_5?echec=1&activite=' + activite_numero;
                        });
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);

                    // ⛔ ERREUR - TOUT RESTE BLOQUÉ
                    const feedback = document.getElementById('feedback');
                    feedback.innerHTML = '❌ Erreur de connexion<br><button id="retry-btn">Réessayer</button>';
                    feedback.className = 'feedback error show';

                    document.getElementById('retry-btn').addEventListener('click', () => {
                        // Réactiver les objets non déposés
                        dragDisabled = false;
                        objetsDrag.forEach(obj => {
                            if (obj.style.visibility !== 'hidden') {
                                obj.draggable = true;
                                obj.style.opacity = '1';
                                obj.style.cursor = 'grab';
                            }
                        });
                        feedback.classList.remove('show');
                    });
                });
        }
    });
});