const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');
const cartes = document.querySelectorAll('.carte');
const resetBtn = document.getElementById('resetBtn');
const undoBtn = document.getElementById('undoBtn');
const validateBtn = document.getElementById('validateBtn');
const info = document.getElementById('info');
const resultModal = document.getElementById('resultModal');
const closeModalBtn = document.getElementById('closeModalBtn');

let selectedCarte = null;
let lines = [];
let lockedCartes = new Set();
let ordreSelection = [];

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

    console.log('Ordre sélectionné:', ordreSelection);

    try {
        const response = await fetch(baseUrl + 'verifierOrdre', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ ordre: ordreSelection })
        });

        const resultat = await response.json();
        console.log('Résultat de la vérification:', resultat);

        if (resultat.correct) {
            // SUCCÈS
            document.getElementById('resultTitle').innerHTML = '🎉 Bravo !';
            document.getElementById('resultMessage').innerHTML = 'Vous avez reconstitué la procédure dans le bon ordre !<br><br>Le quiz est maintenant débloqué.';
            document.getElementById('explicationZone').style.display = 'none';
        } else {
            // ÉCHEC
            document.getElementById('resultTitle').innerHTML = '❌ Ordre incorrect';
            document.getElementById('resultMessage').innerHTML = 'L\'ordre n\'est pas correct. Voici l\'ordre attendu :';

            // Afficher l'ordre correct
            const ordreCorrectList = document.getElementById('ordreCorrectList');
            ordreCorrectList.innerHTML = '';

            if (resultat.details) {
                resultat.details.forEach((carte, index) => {
                    const li = document.createElement('li');
                    li.textContent = carte.explication;
                    ordreCorrectList.appendChild(li);
                });
            }

            document.getElementById('explicationZone').style.display = 'block';
        }

        resultModal.style.display = 'block';
    } catch (error) {
        console.error('Erreur:', error);
        info.innerHTML = '❌ Erreur lors de la vérification';
        validateBtn.disabled = false;
    }
});

// Fermer la modal et retourner à l'accueil
closeModalBtn.addEventListener('click', function() {
    window.location.href = baseUrl + 'resetSalle';
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

// Mascotte
document.getElementById("mascotteHelp").addEventListener("click", function () {
    document.getElementById("rulesModal").style.display = "block";
});

document.querySelector(".close-rules").addEventListener("click", function () {
    document.getElementById("rulesModal").style.display = "none";
});

window.addEventListener("click", function (event) {
    if (event.target.id === "rulesModal") {
        document.getElementById("rulesModal").style.display = "none";
    }
});