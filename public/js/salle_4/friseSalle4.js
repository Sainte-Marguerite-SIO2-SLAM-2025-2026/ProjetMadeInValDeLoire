const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');
const cartes = document.querySelectorAll('.carte');
const resetBtn = document.getElementById('resetBtn');
const undoBtn = document.getElementById('undoBtn');
const validateBtn = document.getElementById('validateBtn');
const info = document.getElementById('info');
const resultModal = document.getElementById('resultModal');
const closeModalBtn = document.getElementById('closeModalBtn');

// Références pour la mascotte
const mascotteDefault = document.querySelector('.mascotte-default');
const mascotteHover = document.querySelector('.mascotte-hover');

let selectedCarte = null;
let lines = [];
let lockedCartes = new Set();
let ordreSelection = [];
let cartesData = {};
let reussiteValidation = false; // Variable pour tracker le résultat

// Stocker les données des cartes au chargement
cartes.forEach(carte => {
    const numero = carte.dataset.numero;
    const explication = carte.closest('.carte-container').querySelector('.explication').textContent;
    cartesData[numero] = explication;
});

// Fonction pour comparer deux tableaux
function compareArrays(arr1, arr2) {
    if (arr1.length !== arr2.length) return false;

    for (let i = 0; i < arr1.length; i++) {
        if (parseInt(arr1[i]) !== parseInt(arr2[i])) {
            return false;
        }
    }

    return true;
}

// Fonction pour changer l'expression de la mascotte
function changerMascotte(reussite) {
    if (mascotteDefault && mascotteHover) {
        if (reussite) {
            // Mascotte contente
            mascotteDefault.src = baseUrl + 'images/commun/mascotte/mascotte_contente.svg';
            mascotteHover.src = baseUrl + 'images/commun/mascotte/mascotte_contente.svg';
        } else {
            // Mascotte saoûlée
            mascotteDefault.src = baseUrl + 'images/commun/mascotte/mascotte_saoulee.svg';
            mascotteHover.src = baseUrl + 'images/commun/mascotte/mascotte_saoulee.svg';
        }
    }
}

// Fonction pour obtenir les coordonnées du centre d'une carte
function getCarteCenter(carteElement) {
    const container = carteElement.closest('.carte-container');
    const containerRect = container.getBoundingClientRect();
    const canvasRect = canvas.getBoundingClientRect();

    const x = containerRect.left - canvasRect.left + containerRect.width / 2;
    const y = containerRect.top - canvasRect.top + containerRect.height / 2;

    return { x, y };
}

// Gérer le clic sur une carte
cartes.forEach(carte => {
    carte.addEventListener('click', function(e) {
        e.stopPropagation();

        const carteId = this.dataset.id;
        const carteNumero = this.dataset.numero;

        if (lockedCartes.has(carteId)) {
            info.innerHTML = '⌛ Cette carte est déjà utilisée !';
            return;
        }

        if (selectedCarte === null) {
            const center = getCarteCenter(this);

            selectedCarte = {
                id: carteId,
                numero: carteNumero,
                element: this,
                x: center.x,
                y: center.y
            };
            this.classList.add('selected');
            ordreSelection.push(parseInt(carteNumero));
            info.innerHTML = `✅ Carte ${ordreSelection.length}/8 sélectionnée`;
        } else {
            if (carteId === selectedCarte.id) {
                info.innerHTML = '⚠️ Vous ne pouvez pas relier une carte à elle-même !';
                return;
            }

            const center = getCarteCenter(this);

            const secondCarte = {
                id: carteId,
                numero: carteNumero,
                element: this,
                x: center.x,
                y: center.y
            };

            drawLine(selectedCarte.x, selectedCarte.y, secondCarte.x, secondCarte.y);

            lines.push({
                carte1Id: selectedCarte.id,
                carte2Id: secondCarte.id,
                x1: selectedCarte.x,
                y1: selectedCarte.y,
                x2: secondCarte.x,
                y2: secondCarte.y
            });

            lockedCartes.add(selectedCarte.id);
            selectedCarte.element.classList.add('locked');
            selectedCarte.element.classList.remove('selected');

            ordreSelection.push(parseInt(carteNumero));
            info.innerHTML = `✅ Carte ${ordreSelection.length}/8 sélectionnée`;

            this.classList.add('selected');
            selectedCarte = {
                id: secondCarte.id,
                numero: secondCarte.numero,
                element: this,
                x: secondCarte.x,
                y: secondCarte.y
            };

            if (ordreSelection.length === cartes.length) {
                selectedCarte.element.classList.remove('selected');
                selectedCarte = null;
                info.innerHTML = '🎯 Toutes les cartes sont reliées ! Cliquez sur "Valider" pour vérifier votre ordre.';
                validateBtn.disabled = false;
            }
        }
    });
});

function drawLine(x1, y1, x2, y2) {
    ctx.strokeStyle = '#e74c3c';
    ctx.lineWidth = 4;
    ctx.lineCap = 'round';
    ctx.shadowBlur = 10;
    ctx.shadowColor = 'rgba(231, 76, 60, 0.5)';

    ctx.beginPath();
    ctx.moveTo(x1, y1);
    ctx.lineTo(x2, y2);
    ctx.stroke();

    ctx.shadowBlur = 0;

    drawPoint(x1, y1);
    drawPoint(x2, y2);
}

function drawPoint(x, y) {
    ctx.fillStyle = '#e74c3c';
    ctx.beginPath();
    ctx.arc(x, y, 6, 0, 2 * Math.PI);
    ctx.fill();
}

function redrawAll() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    lines.forEach(line => {
        drawLine(line.x1, line.y1, line.x2, line.y2);
    });
}

function resetGame() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    lines = [];
    lockedCartes.clear();
    selectedCarte = null;
    ordreSelection = [];

    cartes.forEach(carte => {
        carte.classList.remove('locked', 'selected');
    });

    validateBtn.disabled = true;
    info.innerHTML = 'Cliquez sur les cartes dans l\'ordre chronologique pour reconstituer la frise';
}

resetBtn.addEventListener('click', resetGame);

undoBtn.addEventListener('click', function() {
    if (lines.length > 0) {
        const lastLine = lines.pop();

        lockedCartes.delete(lastLine.carte1Id);
        document.getElementById('carte' + lastLine.carte1Id).classList.remove('locked');

        if (selectedCarte) {
            selectedCarte.element.classList.remove('selected');
            ordreSelection.pop();
        }

        const carte1Element = document.getElementById('carte' + lastLine.carte1Id);
        const center = getCarteCenter(carte1Element);

        selectedCarte = {
            id: lastLine.carte1Id,
            numero: carte1Element.dataset.numero,
            element: carte1Element,
            x: center.x,
            y: center.y
        };
        carte1Element.classList.add('selected');

        validateBtn.disabled = true;
        redrawAll();
        info.innerHTML = `↶ Dernière ligne annulée - ${ordreSelection.length}/8 cartes sélectionnées`;
    } else if (selectedCarte !== null) {
        selectedCarte.element.classList.remove('selected');
        selectedCarte = null;
        ordreSelection.pop();
        info.innerHTML = '↶ Sélection annulée';
    } else {
        info.innerHTML = '⚠️ Rien à annuler';
    }
});

// Valider l'ordre
validateBtn.addEventListener('click', async function() {
    validateBtn.disabled = true;
    info.innerHTML = '⏳ Vérification en cours...';

    try {
        const response = await fetch(baseUrl + 'verifierOrdre', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ ordre: ordreSelection })
        });

        const resultat = await response.json();

        console.log('Ordre utilisateur:', ordreSelection);
        console.log('Ordre correct:', resultat.ordre_correct);
        console.log('Résultat du serveur:', resultat);

        // Vérifier si les ordres sont identiques (comparaison JS)
        const estCorrect = compareArrays(ordreSelection, resultat.ordre_correct);
        console.log('Comparaison JS:', estCorrect);

        // Si le JS dit que c'est correct mais pas le serveur, forcer la mise à jour
        if (estCorrect && !resultat.correct) {
            console.log('Correction du résultat serveur...');
            const forceResponse = await fetch(baseUrl + 'verifierOrdre', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    ordre: ordreSelection,
                    force_correct: true
                })
            });
            const forceResultat = await forceResponse.json();
            console.log('Résultat forcé:', forceResultat);
        }

        // Stocker le résultat pour le bouton
        reussiteValidation = estCorrect;

        // Changer l'expression de la mascotte
        changerMascotte(estCorrect);

        // Créer l'affichage de l'ordre du joueur
        const ordreUtilisateurHtml = document.createElement('div');
        ordreUtilisateurHtml.id = 'ordreUtilisateur';
        ordreUtilisateurHtml.innerHTML = '<h3>Votre ordre :</h3>';

        const listUtilisateur = document.createElement('ol');
        listUtilisateur.style.textAlign = 'left';
        listUtilisateur.style.marginBottom = '20px';

        ordreSelection.forEach(numero => {
            const li = document.createElement('li');
            li.textContent = cartesData[numero];
            listUtilisateur.appendChild(li);
        });

        ordreUtilisateurHtml.appendChild(listUtilisateur);

        if (estCorrect) {
            // SUCCÈS
            document.getElementById('resultTitle').innerHTML = '🎉 Bravo !';
            document.getElementById('resultMessage').innerHTML = 'Vous avez reconstitué la procédure dans le bon ordre !<br><br>Le quiz est maintenant débloqué.';



            // Changer le texte du bouton pour la réussite
            closeModalBtn.textContent = 'Continuer la salle';
        } else {
            // ÉCHEC
            document.getElementById('resultTitle').innerHTML = '❌ Ordre incorrect';
            document.getElementById('resultMessage').innerHTML = 'L\'ordre n\'est pas correct. Voici la comparaison :';

            const explicationZone = document.getElementById('explicationZone');
            explicationZone.innerHTML = '';

            const votreOrdreSection = document.createElement('div');
            votreOrdreSection.style.marginBottom = '20px';
            votreOrdreSection.innerHTML = '<h3 style="color: #e74c3c;">✗ Votre ordre :</h3>';

            const listUtilisateurError = document.createElement('ol');
            listUtilisateurError.style.textAlign = 'left';

            ordreSelection.forEach(numero => {
                const li = document.createElement('li');
                li.textContent = cartesData[numero];
                li.style.color = '#555';
                listUtilisateurError.appendChild(li);
            });

            votreOrdreSection.appendChild(listUtilisateurError);
            explicationZone.appendChild(votreOrdreSection);

            const separateur = document.createElement('hr');
            separateur.style.margin = '20px 0';
            separateur.style.border = 'none';
            separateur.style.borderTop = '2px solid #ddd';
            explicationZone.appendChild(separateur);

            const ordreCorrectDiv = document.createElement('div');
            ordreCorrectDiv.innerHTML = '<h3 style="color: #27ae60;">✓ Ordre correct :</h3>';

            const ordreCorrectList = document.createElement('ol');
            ordreCorrectList.style.textAlign = 'left';

            if (resultat.details && resultat.details.length > 0) {
                resultat.details.forEach(carte => {
                    const li = document.createElement('li');
                    li.textContent = carte.explication;
                    li.style.color = '#27ae60';
                    li.style.fontWeight = 'bold';
                    ordreCorrectList.appendChild(li);
                });
            }

            ordreCorrectDiv.appendChild(ordreCorrectList);
            explicationZone.appendChild(ordreCorrectDiv);

            explicationZone.style.display = 'block';

            // Changer le texte du bouton pour l'échec
            closeModalBtn.textContent = 'Retour à l\'accueil';
        }

        resultModal.style.display = 'block';
    } catch (error) {
        console.error('Erreur:', error);
        info.innerHTML = '❌ Erreur lors de la vérification';
        validateBtn.disabled = false;
    }
});

// Fermer la modal et rediriger selon le résultat
closeModalBtn.addEventListener('click', function() {

    let chemin = "";
    if (reussiteValidation) {
        // En cas de réussite : retour à la Salle 4
        chemin = baseUrl + 'Salle4';
    } else {
        if (mode === 'jour') {
            chemin = baseUrl + 'echouerJour/4'
        }
        else {
            // En cas d'échec : retour à l'accueil du site
            chemin = baseUrl + 'reset';
        }
    }
    window.location.href = chemin;
});

// Initialisation
validateBtn.disabled = true;

// Recalculer au resize
window.addEventListener('resize', function() {
    if (lines.length > 0) {
        lines.forEach(line => {
            const carte1 = document.getElementById('carte' + line.carte1Id);
            const carte2 = document.getElementById('carte' + line.carte2Id);

            const center1 = getCarteCenter(carte1);
            const center2 = getCarteCenter(carte2);

            line.x1 = center1.x;
            line.y1 = center1.y;
            line.x2 = center2.x;
            line.y2 = center2.y;
        });

        redrawAll();
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