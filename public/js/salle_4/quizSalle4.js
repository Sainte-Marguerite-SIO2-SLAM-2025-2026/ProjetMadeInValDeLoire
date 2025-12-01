// =====================================================
// Quiz Salle 4 - JavaScript
// =====================================================

const cartesQuiz = document.querySelectorAll('.carte-quiz');
const questionModal = document.getElementById('questionModal');
const questionText = document.getElementById('question-text');
const carteGrandeImg = document.getElementById('carte-grande-img');
const btnVrai = document.getElementById('btn-vrai');
const btnFaux = document.getElementById('btn-faux');
const closeQuestion = document.querySelector('.close-question');
const scoreDisplay = document.getElementById('score');
const resultModal = document.getElementById('resultModal');
const mascotteDefault = document.querySelector('.mascotte-default');
const mascotteHover = document.querySelector('.mascotte-hover');

let currentQuestionId = null;
let currentCarteElement = null;
let totalRepondu = 0;
let score = 0;


// =====================================================
// Fonction pour mettre à jour la mascotte selon le score
// =====================================================
function updateMascotte(finalScore) {
    if (finalScore >= 4) {
        // 4+ bonnes réponses : mascotte contente
        mascotteDefault.src = baseUrl + 'images/commun/mascotte/mascotte_contente.svg';
        mascotteHover.src = baseUrl + 'images/commun/mascotte/mascotte_contente.svg';
    } else if (finalScore <= 2) {
        // 2 ou moins : mascotte choquée
        mascotteDefault.src = baseUrl + 'images/commun/mascotte/mascotte_choquee.svg';
        mascotteHover.src = baseUrl + 'images/commun/mascotte/mascotte_choquee.svg';
    }
    // Entre 3 et 3 : mascotte normale (pas de changement)
}

// =====================================================
// Gestion des cartes quiz
// =====================================================

cartesQuiz.forEach(carte => {
    carte.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        // Vérifier si déjà répondue
        if (this.classList.contains('answered')) {
            return;
        }

        const questionId = this.dataset.questionId;
        const imageCarte = this.dataset.image;
        const question = questionsData.find(q => q.numero == questionId);

        if (question) {
            currentQuestionId = questionId;
            currentCarteElement = this;

            // Afficher la même image en grand
            carteGrandeImg.src = baseUrl + 'images/salle_4/images_finales/' + imageCarte;

            // Afficher la question
            questionText.textContent = question.libelle;

            // Ouvrir la modal
            questionModal.style.display = 'block';
        }
    });
});

// =====================================================
// Réponses Vrai/Faux
// =====================================================

if (btnVrai) {
    btnVrai.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        envoyerReponse('vrai');
    });
}

if (btnFaux) {
    btnFaux.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        envoyerReponse('faux');
    });
}

async function envoyerReponse(reponse) {

    if (!currentQuestionId) {
        console.error('Aucune question sélectionnée');
        alert('Erreur: Aucune question sélectionnée');
        return;
    }

    // Désactiver les boutons pendant l'envoi
    if (btnVrai) btnVrai.disabled = true;
    if (btnFaux) btnFaux.disabled = true;

    try {
        const url = baseUrl + 'verifierReponseQuiz';
        const data = {
            question_id: parseInt(currentQuestionId),
            reponse: reponse
        };

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const resultat = await response.json();

        if (resultat.success) {
            // Mettre à jour le score
            score = resultat.score;
            totalRepondu = resultat.total_repondu;
            scoreDisplay.textContent = score;

            // Marquer la carte comme répondue
            if (currentCarteElement) {
                currentCarteElement.classList.add('answered');

                // Ajouter le symbole ✓ ou ✗
                const status = document.createElement('div');
                status.className = 'carte-status';
                status.textContent = resultat.correct ? '✓' : '✗';
                currentCarteElement.appendChild(status);
            }

            // Fermer la modal
            questionModal.style.display = 'none';

            // Réinitialiser
            currentQuestionId = null;
            currentCarteElement = null;

            // Réactiver les boutons
            if (btnVrai) btnVrai.disabled = false;
            if (btnFaux) btnFaux.disabled = false;

            // Vérifier si toutes les questions sont répondues
            if (totalRepondu >= 6) {
                setTimeout(() => {
                    afficherResultatFinal2();
                }, 500);
            }
        } else {
            console.error('Erreur dans le résultat:', resultat);
            alert('Erreur: ' + (resultat.message || 'Erreur inconnue'));
            if (btnVrai) btnVrai.disabled = false;
            if (btnFaux) btnFaux.disabled = false;
        }
    } catch (error) {
        console.error('Erreur lors de l\'envoi:', error);
        alert('Erreur de communication avec le serveur: ' + error.message);
        if (btnVrai) btnVrai.disabled = false;
        if (btnFaux) btnFaux.disabled = false;
    }
}

// =====================================================
// Affichage du résultat final
// =====================================================
function afficherResultatFinal2() {
    const resultTitle = document.getElementById('resultTitle');
    const resultMessage = document.getElementById('resultMessage');
    const scoreMessage = document.getElementById('scoreMessage');

    // Mettre à jour la mascotte selon le score
    updateMascotte(score);

    // ================
    // TEXTES D'AFFICHAGE
    // ================
    if (score >= 5) {
        resultTitle.textContent = 'Excellent !';
        resultMessage.textContent = 'Vous maîtrisez bien le sujet des ransomwares !';
    } else if (score >= 3) {
        resultTitle.textContent = 'Bien joué !';
        resultMessage.textContent = 'Vous avez de bonnes connaissances sur les ransomwares.';
    } else {
        resultTitle.textContent = 'À améliorer';
        resultMessage.textContent = 'Continuez à vous former sur la cybersécurité !';
    }

    scoreMessage.textContent = `Votre score : ${score} / 6`;

    resultModal.style.display = 'block';

    // =============================
    // RÉCUPÉRATION DU MODE (jour/nuit)
    // =============================
    const btnRetourAccueil = document.getElementById('btnRetourAccueil');

    if (!btnRetourAccueil) return;

    let chemin = "";

    if (score > 3) {
        // Salle validée
        if (mode === 'jour') {
            chemin = baseUrl + 'validerJour/4';
        } else {
            chemin = baseUrl + 'valider/4';
        }
    }
    else if (mode === 'jour') {
        // Salle échouée en mode jour
        chemin = baseUrl + 'echouerJour/4';
    }
    else {
        chemin = baseUrl + 'valider/4';
    }

    btnRetourAccueil.onclick = () => {
        window.location.href = chemin;
    };

}

// =====================================================
// Fermer la modal de question
// =====================================================

if (closeQuestion) {
    closeQuestion.addEventListener('click', function() {
        questionModal.style.display = 'none';
        currentQuestionId = null;
        currentCarteElement = null;
        if (btnVrai) btnVrai.disabled = false;
        if (btnFaux) btnFaux.disabled = false;
    });
}

window.addEventListener('click', function(event) {
    if (event.target === questionModal) {
        questionModal.style.display = 'none';
        currentQuestionId = null;
        currentCarteElement = null;
        if (btnVrai) btnVrai.disabled = false;
        if (btnFaux) btnFaux.disabled = false;
    }
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
