<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relier des cartes</title>
    <link href="style_3.css" rel="stylesheet" />
</head>
<body>
<h1> Relier les cartes</h1>

<div id="info">
    Cliquez sur deux cartes pour les relier avec une ligne rouge
</div>

<div class="controls">
    <button id="resetBtn">🔄 Réinitialiser</button>
    <button id="undoBtn">↶ Annuler la dernière ligne</button>
</div>

<div id="gameContainer">
    <!-- L'image de fond sera remplacée par votre fond.png -->
    <img id="fondImage" src="fond.png
    width='800' height='600'%3E%3Cdefs%3E%3Cpattern id='grid'
    width='40' height='40' patternUnits='userSpaceOnUse'%3E%3Cpath d='M 40 0 L 0 0 0 40'
    fill='none' stroke='%23ffffff' stroke-width='0.5'
    opacity='0.1'/%3E%3C/pattern%3E%3C/defs%3E%3Crect width='800' height='600'
     fill='%2334495e'/%3E%3Crect width='800' height='600' fill='url(%23grid)'/%3E%3C/svg%3E" alt="Fond">
    <canvas id="canvas" width="800" height="600"></canvas>

    <!-- Les 4 cartes avec vos images -->
    <img class="carte" id="carte1" data-id="1" src="carte1.png" alt="Carte 1" style="left: 100px; top: 100px;">
    <img class="carte" id="carte2" data-id="2" src="carte2.png" alt="Carte 2" style="left: 600px; top: 100px;">
    <img class="carte" id="carte3" data-id="3" src="carte3.png" alt="Carte 3" style="left: 100px; top: 400px;">
    <img class="carte" id="carte4" data-id="4" src="carte4.png" alt="Carte 4" style="left: 600px; top: 400px;">
</div>

<script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    const cartes = document.querySelectorAll('.carte');
    const resetBtn = document.getElementById('resetBtn');
    const undoBtn = document.getElementById('undoBtn');
    const info = document.getElementById('info');

    let selectedCarte = null;
    let lines = [];
    let lockedCartes = new Set();

    // Gérer le clic sur une carte
    cartes.forEach(carte => {
        carte.addEventListener('click', function(e) {
            e.stopPropagation();

            const carteId = this.dataset.id;

            // Vérifier si la carte est déjà verrouillée
            if (lockedCartes.has(carteId)) {
                info.innerHTML = '❌ Cette carte est déjà utilisée !';
                return;
            }

            if (selectedCarte === null) {
                // Premier clic
                selectedCarte = {
                    id: carteId,
                    element: this,
                    x: this.offsetLeft + this.offsetWidth / 2,
                    y: this.offsetTop + this.offsetHeight / 2
                };
                this.classList.add('selected');
                info.innerHTML = '✅ Première carte sélectionnée ! Cliquez sur une deuxième carte.';
            } else {
                // Deuxième clic
                if (carteId === selectedCarte.id) {
                    // Même carte cliquée deux fois
                    info.innerHTML = '⚠️ Vous ne pouvez pas relier une carte à elle-même !';
                    return;
                }

                const secondCarte = {
                    id: carteId,
                    element: this,
                    x: this.offsetLeft + this.offsetWidth / 2,
                    y: this.offsetTop + this.offsetHeight / 2
                };

                // Dessiner la ligne
                drawLine(selectedCarte.x, selectedCarte.y, secondCarte.x, secondCarte.y);

                // Sauvegarder la ligne
                lines.push({
                    carte1Id: selectedCarte.id,
                    carte2Id: secondCarte.id,
                    x1: selectedCarte.x,
                    y1: selectedCarte.y,
                    x2: secondCarte.x,
                    y2: secondCarte.y
                });

                // Verrouiller seulement la première carte
                lockedCartes.add(selectedCarte.id);
                selectedCarte.element.classList.add('locked');
                selectedCarte.element.classList.remove('selected');

                info.innerHTML = `🎉 Cartes ${selectedCarte.id} et ${secondCarte.id} reliées ! Carte ${secondCarte.id} reste active.`;

                // La deuxième carte devient le point de départ suivant
                this.classList.add('selected');
                selectedCarte = {
                    id: secondCarte.id,
                    element: this,
                    x: secondCarte.x,
                    y: secondCarte.y
                };

                // Vérifier si toutes les cartes sont verrouillées
                if (lockedCartes.size === cartes.length) {
                    selectedCarte.element.classList.remove('selected');
                    selectedCarte = null;
                    info.innerHTML = '🏆 Toutes les cartes sont reliées !';
                }
            }
        });
    });

    // Dessiner une ligne
    function drawLine(x1, y1, x2, y2) {
        ctx.strokeStyle = 'red';
        ctx.lineWidth = 4;
        ctx.lineCap = 'round';
        ctx.shadowBlur = 10;
        ctx.shadowColor = 'rgba(255, 0, 0, 0.5)';

        ctx.beginPath();
        ctx.moveTo(x1, y1);
        ctx.lineTo(x2, y2);
        ctx.stroke();

        // Réinitialiser l'ombre pour éviter les effets indésirables
        ctx.shadowBlur = 0;

        // Dessiner des points aux extrémités
        drawPoint(x1, y1);
        drawPoint(x2, y2);
    }

    // Dessiner un point
    function drawPoint(x, y) {
        ctx.fillStyle = 'red';
        ctx.beginPath();
        ctx.arc(x, y, 6, 0, 2 * Math.PI);
        ctx.fill();
    }

    // Redessiner toutes les lignes
    function redrawAll() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        lines.forEach(line => {
            drawLine(line.x1, line.y1, line.x2, line.y2);
        });
    }

    // Réinitialiser tout
    resetBtn.addEventListener('click', function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        lines = [];
        lockedCartes.clear();
        selectedCarte = null;

        cartes.forEach(carte => {
            carte.classList.remove('locked', 'selected');
        });

        info.innerHTML = 'Cliquez sur deux cartes pour les relier avec une ligne rouge';
    });

    // Annuler la dernière ligne
    undoBtn.addEventListener('click', function() {
        if (lines.length > 0) {
            const lastLine = lines.pop();

            // Déverrouiller seulement la seconde carte
            lockedCartes.delete(lastLine.carte2Id);
            document.getElementById('carte' + lastLine.carte2Id).classList.remove('locked');

            // La première carte de la dernière ligne redevient sélectionnée
            if (selectedCarte) {
                selectedCarte.element.classList.remove('selected');
            }

            const carte1Element = document.getElementById('carte' + lastLine.carte1Id);
            selectedCarte = {
                id: lastLine.carte1Id,
                element: carte1Element,
                x: lastLine.x1,
                y: lastLine.y1
            };
            carte1Element.classList.add('selected');

            redrawAll();
            info.innerHTML = '↶ Dernière ligne annulée';
        } else if (selectedCarte !== null) {
            selectedCarte.element.classList.remove('selected');
            selectedCarte = null;
            info.innerHTML = '↶ Sélection annulée';
        } else {
            info.innerHTML = '⚠️ Rien à annuler';
        }
    });
</script>
</body>
</html>