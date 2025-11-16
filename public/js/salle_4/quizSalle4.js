// =====================================================
// Quiz Salle 4 - JavaScript
// =====================================================

console.log('Script chargé');
console.log('Base URL:', baseUrl);
console.log('Questions:', questionsData);

const cartesQuiz = document.querySelectorAll('.carte-quiz');
const questionModal = document.getElementById('questionModal');
const questionText = document.getElementById('question-text');
const carteGrandeImg = document.getElementById('carte-grande-img');
const btnVrai = document.getElementById('btn-vrai');
const btnFaux = document.getElementById('btn-faux');
const closeQuestion = document.querySelector('.close-question');
const scoreDisplay = document.getElementById('score');
const resultModal = document.getElementById('resultModal');

let currentQuestionId = null;
let currentCarteElement = null;
let totalRepondu = 0;
let score = 0;

console.log('Bouton Vrai:', btnVrai);
console.log('Bouton Faux:', btnFaux);

// =====================================================
// Gestion des cartes quiz
// =====================================================

cartesQuiz.forEach(carte => {
    carte.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        console.log('Carte cliquée');

        // Vérifier si déjà répondue
        if (this.classList.contains('answered')) {
            console.log('Carte déjà répondue');
            return;
        }

        const questionId = this.dataset.questionId;
        const imageCarte = this.dataset.image;
        const question = questionsData.find(q => q.numero == questionId);

        console.log('Question ID:', questionId);
        console.log('Image carte:', imageCarte);
        console.log('Question:', question);

        if (question) {
            currentQuestionId = questionId;
            currentCarteElement = this;

            // Afficher la même image en grand
            carteGrandeImg.src = baseUrl + 'images/salle_4/images_finales/' + imageCarte;

            // Afficher la question
            questionText.textContent = question.question;

            // Ouvrir la modal
            questionModal.style.display = 'block';

            console.log('Modal ouverte');
        }
    });
});

// =====================================================
// Réponses Vrai/Faux
// =====================================================

if (btnVrai) {
    btnVrai.addEventListener('click', function(e) {
        console.log('Bouton VRAI cliqué');
        e.preventDefault();
        e.stopPropagation();
        envoyerReponse('vrai');
    });
}

if (btnFaux) {
    btnFaux.addEventListener('click', function(e) {
        console.log('Bouton FAUX cliqué');
        e.preventDefault();
        e.stopPropagation();
        envoyerReponse('faux');
    });
}

async function envoyerReponse(reponse) {
    console.log('Envoi de la réponse:', reponse);
    console.log('Question ID actuelle:', currentQuestionId);

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

        console.log('URL:', url);
        console.log('Données envoyées:', data);

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        console.log('Réponse HTTP:', response);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const resultat = await response.json();
        console.log('Résultat:', resultat);

        if (resultat.success) {
            // Mettre à jour le score
            score = resultat.score;
            totalRepondu = resultat.total_repondu;
            scoreDisplay.textContent = score;

            console.log('Score mis à jour:', score);
            console.log('Total répondu:', totalRepondu);

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
                console.log('Toutes les questions répondues!');
                setTimeout(() => {
                    afficherResultatFinal();
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

function afficherResultatFinal() {
    const resultTitle = document.getElementById('resultTitle');
    const resultMessage = document.getElementById('resultMessage');
    const scoreMessage = document.getElementById('scoreMessage');

    if (score >= 5) {
        resultTitle.textContent = '🎉 Excellent !';
        resultMessage.textContent = 'Vous maîtrisez bien le sujet des ransomwares !';
    } else if (score >= 3) {
        resultTitle.textContent = '👍 Bien joué !';
        resultMessage.textContent = 'Vous avez de bonnes connaissances sur les ransomwares.';
    } else {
        resultTitle.textContent = '📚 À améliorer';
        resultMessage.textContent = 'Continuez à vous former sur la cybersécurité !';
    }

    scoreMessage.textContent = `Votre score : ${score} / 6`;

    resultModal.style.display = 'block';

    // Compte à rebours de redirection
    let countdown = 5;
    const countdownEl = document.getElementById('countdown');

    const interval = setInterval(() => {
        countdown--;
        countdownEl.textContent = countdown;

        if (countdown <= 0) {
            clearInterval(interval);
            window.location.href = baseUrl + 'resetQuiz';
        }
    }, 1000);
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

console.log('Script initialisé complètement');