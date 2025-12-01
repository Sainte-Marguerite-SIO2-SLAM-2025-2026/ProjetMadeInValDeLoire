// === TIMER GLOBAL (5 minutes) ===

// Durée totale du timer (en millisecondes)
const TOTAL_TIME = 4 * 60 * 1000; // 4 minutes

// Fonction pour démarrer le timer (appelée uniquement sur la page Discussion)
function startTimer() {
    if (!sessionStorage.getItem("startTime")) {
        sessionStorage.setItem("startTime", Date.now());
    }
}

// Fonction pour afficher la popup de défaite
function afficherDefaite() {
    const popupEchec = document.getElementById("popup-echec");

    if (popupEchec) {
        popupEchec.style.display = "flex"; // 🔥 La popup s’affiche !
        sessionStorage.removeItem("startTime");
    }
}

// Fonction principale du timer
function updateTimer() {
    const timerElement = document.getElementById("timer");
    if (!timerElement) return; // Si aucun élément #timer, on ne fait rien

    const startTime = parseInt(sessionStorage.getItem("startTime"), 10);
    if (!startTime) return;

    const elapsed = Date.now() - startTime;
    const remaining = Math.max(0, TOTAL_TIME - elapsed);

    const minutes = Math.floor(remaining / 60000);
    const seconds = Math.floor((remaining % 60000) / 1000);

    timerElement.textContent = `${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;

    // Changement de couleur quand il reste moins d'une minute
    if (remaining <= 60000 && remaining > 30000) {
        timerElement.style.color = "orange";
    } else if (remaining <= 30000 && remaining > 0) {
        timerElement.style.color = "red";
        timerElement.style.animation = "pulse 1s infinite";
    }

    // Si le temps est écoulé
    if (remaining <= 0) {
        timerElement.textContent = "00:00";
        clearInterval(timerInterval);
        afficherDefaite();
    }
}

// Démarrer le timer au chargement de la page
startTimer();

// Met à jour le timer chaque seconde
const timerInterval = setInterval(updateTimer, 1000);

// Met à jour immédiatement
updateTimer();