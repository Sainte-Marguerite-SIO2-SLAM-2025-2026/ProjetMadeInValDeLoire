// =====================================================
// ACTIVITÉ 402 : Bonnes pratiques vs Pièges
// =====================================================

const cartes402 = document.querySelectorAll('.carte-402');
const resultModal = document.getElementById('resultModal');
const closeModalBtn = document.getElementById('closeModalBtn');

let cartesJouees = [];
let jeuTermine = false;
let reussiteValidation = false;

cartes402.forEach(carte => {
    carte.addEventListener('click', async function(e) {
        e.stopPropagation();

        if (jeuTermine) return;

        const numeroCarte = parseInt(this.dataset.numero);

        if (cartesJouees.includes(numeroCarte)) {
            return;
        }

        cartes402.forEach(c => c.style.pointerEvents = 'none');

        try {
            const response = await fetch(baseUrl + 'verifierCarte402', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    numero_carte: numeroCarte,
                    cartes_jouees: cartesJouees
                })
            });

            const resultat = await response.json();

            if (resultat.erreur) {
                console.error('Erreur:', resultat.message);
                cartes402.forEach(c => c.style.pointerEvents = 'auto');
                return;
            }

            cartesJouees = resultat.cartes_jouees || cartesJouees;
            this.classList.add('locked');
            this.style.opacity = '0.5';

            if (!resultat.continuer) {
                jeuTermine = true;
                reussiteValidation = resultat.reussi;

                cartes402.forEach(c => {
                    c.classList.add('locked');
                    c.style.pointerEvents = 'none';
                });

                if (resultat.reussi) {
                    afficherModalSucces(resultat);
                } else {
                    afficherModalEchec(resultat);
                }
            } else {
                cartes402.forEach(c => {
                    if (!cartesJouees.includes(parseInt(c.dataset.numero))) {
                        c.style.pointerEvents = 'auto';
                    }
                });
            }

        } catch (error) {
            console.error('Erreur:', error);
            cartes402.forEach(c => c.style.pointerEvents = 'auto');
        }
    });

    carte.addEventListener('mouseenter', function() {
        if (!jeuTermine && !cartesJouees.includes(parseInt(this.dataset.numero))) {
            this.style.transform = 'scale(1.05)';
            this.style.filter = 'brightness(1.1)';
            this.style.boxShadow = '0 8px 20px rgba(0,0,0,0.5)';
        }
    });

    carte.addEventListener('mouseleave', function() {
        if (!jeuTermine && !cartesJouees.includes(parseInt(this.dataset.numero))) {
            this.style.transform = 'scale(1)';
            this.style.filter = 'brightness(1)';
            this.style.boxShadow = 'none';
        }
    });
});

function afficherModalSucces(resultat) {
    document.getElementById('resultTitle').innerHTML = '🎉 Bravo !';
    document.getElementById('resultMessage').innerHTML =
        `Vous avez trouvé toutes les bonnes pratiques !<br><br>
        Score : ${resultat.score}/${resultat.total_bonnes_pratiques}<br><br>
        Le quiz est maintenant débloqué.`;

    document.getElementById('explicationZone').style.display = 'none';
    closeModalBtn.textContent = 'Retourner dans la chambre';
    resultModal.style.display = 'block';
}

function afficherModalEchec(resultat) {
    document.getElementById('resultTitle').innerHTML = '❌ Piège activé !';

    let messageHtml = `Vous avez cliqué sur un piège !<br><br>`;
    messageHtml += `<strong>Score final :</strong> ${resultat.score}/${resultat.total_bonnes_pratiques} bonnes pratiques trouvées<br><br>`;

    if (resultat.carte && resultat.carte.explication_piege) {
        messageHtml += `<div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107; margin-top: 20px; text-align: left;">`;
        messageHtml += `<strong style="color: #856404;">⚠️ Pourquoi c'est un piège :</strong><br>`;
        messageHtml += `<span style="color: #856404;">${resultat.carte.explication_piege}</span>`;
        messageHtml += `</div>`;
    }

    document.getElementById('resultMessage').innerHTML = messageHtml;
    document.getElementById('explicationZone').style.display = 'none';
    closeModalBtn.textContent = 'Retourner au Manoir';
    resultModal.style.display = 'block';
}

closeModalBtn.addEventListener('click', function() {
    let chemin = "";
    if (reussiteValidation) {
        chemin = baseUrl + 'Salle4';
    } else {
        if (mode === 'jour') {
            chemin = baseUrl + 'echouerJour/4';
        } else {
            chemin = baseUrl + 'reset';
        }
    }
    window.location.href = chemin;
});



// =====================================================
// Mascotte avec règles
// =====================================================

const mascotteContainer = document.querySelector("#mascotte-container");
const rulesModal = document.getElementById('rulesModal');
const closeRules = document.querySelector('.close-rules');

if (mascotteContainer) {
    mascotteContainer.addEventListener("click", function() {
        if (rulesModal) {
            rulesModal.style.display = 'block';
        }
    });
}

if (closeRules) {
    closeRules.addEventListener('click', function() {
        closeRulesModal();
    });
}

window.addEventListener('click', function(event) {
    if (event.target === rulesModal) {
        closeRulesModal();
    }
});

function closeRulesModal() {
    if (rulesModal) {
        rulesModal.style.display = 'none';
    }
}

// Fermer avec la touche Échap
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        if (questionModal && questionModal.style.display === 'block') {
            questionModal.style.display = 'none';
            currentQuestionId = null;
            currentCarteElement = null;
            if (btnVrai) btnVrai.disabled = false;
            if (btnFaux) btnFaux.disabled = false;
        }
        if (rulesModal && rulesModal.style.display === 'block') {
            closeRulesModal();
        }
    }
});