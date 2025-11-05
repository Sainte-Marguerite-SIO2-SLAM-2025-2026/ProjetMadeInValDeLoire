// === TIMER GLOBAL (5 minutes) ===

// Durée totale du timer (en millisecondes)
const TOTAL_TIME = 5 * 60 * 1000; // 5 minutes

// Si aucun "startTime" n'existe encore, on le crée
if (!localStorage.getItem("startTime")) {
    localStorage.setItem("startTime", Date.now());
}

// Fonction principale du timer
function updateTimer() {
    const timerElement = document.getElementById("timer");
    if (!timerElement) return; // Si aucun élément #timer, on ne fait rien

    const startTime = parseInt(localStorage.getItem("startTime"), 10);
    const elapsed = Date.now() - startTime;
    const remaining = Math.max(0, TOTAL_TIME - elapsed);

    const minutes = Math.floor(remaining / 60000);
    const seconds = Math.floor((remaining % 60000) / 1000);

    timerElement.textContent = `${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;

    // Si le temps est écoulé
    if (remaining <= 0) {
        timerElement.textContent = "00:00";
        clearInterval(timerInterval);
        localStorage.removeItem("startTime"); // Réinitialise le timer
    }
}

// Met à jour le timer chaque seconde
const timerInterval = setInterval(updateTimer, 1000);

// Met à jour immédiatement
updateTimer();
