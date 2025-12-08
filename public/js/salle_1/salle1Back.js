// -------------------------------
// Gestion des onglets
// -------------------------------
document.querySelectorAll(".tab").forEach(tab => {
    tab.addEventListener("click", () => {
        document.querySelectorAll(".tab").forEach(t => t.classList.remove("active"));
        document.querySelectorAll(".tab-content").forEach(c => c.classList.remove("active"));

        tab.classList.add("active");
        document.getElementById(tab.dataset.target).classList.add("active");

        if (tab.dataset.target === "stats") loadStats();
    });
});

// -------------------------------
// Alertes
// -------------------------------
function showAlert(msg, type = "success") {
    const alert = document.getElementById("alert");
    alert.className = `alert alert-${type} show`;
    alert.textContent = msg;
    setTimeout(() => alert.classList.remove("show"), 4000);
}

// -------------------------------
// Chargement des Activités
// -------------------------------
async function loadActivities() {
    const res = await fetch(`${API_BASE}/activites`);
    const json = await res.json();

    const list = document.getElementById("activitiesList");

    if (!json.success) {
        list.innerHTML = "Erreur de chargement";
        return;
    }

    list.innerHTML = `
        <table class="table">
            <thead>
                <tr><th>ID</th><th>Libellé</th><th>Difficulté</th><th>Malveillant</th></tr>
            </thead>
            <tbody>
                ${json.data.map(a => `
                    <tr>
                        <td>${a.numero}</td>
                        <td>${a.libelle.substring(0,80)}...</td>
                        <td>${a.difficulte || '-'}</td>
                        <td>${a.malveillant ? "Oui" : "Non"}</td>
                    </tr>`).join("")}
            </tbody>
        </table>
    `;

    populateSelects(json.data);
}

// -------------------------------
// Remplir <select>
// -------------------------------
function populateSelects(activities) {
    const selects = [
        document.getElementById("errorActivitySelect"),
        document.getElementById("viewErrorsSelect")
    ];

    selects.forEach(sel => {
        if (!sel) return;
        sel.innerHTML = `<option value="">Choisir...</option>` +
            activities.map(a =>
                `<option value="${a.numero}">${a.numero} - ${a.libelle.substring(0, 40)}...</option>`
            ).join("");
    });
}

// -------------------------------
// Charger erreurs
// -------------------------------
document.getElementById("viewErrorsSelect").addEventListener("change", async e => {
    const id = e.target.value;
    if (!id) return;

    const res = await fetch(`${API_BASE}/message/${id}/erreurs`);
    const json = await res.json();

    const list = document.getElementById("errorsList");

    if (!json.data.erreurs.length) {
        list.innerHTML = "<p>Aucune erreur.</p>";
        return;
    }

    list.innerHTML = `
        <table class="table">
            <thead><tr><th>Mot</th><th>Explication</th></tr></thead>
            <tbody>
                ${json.data.erreurs.map(e => `
                    <tr>
                        <td>${e.mot_incorrect}</td>
                        <td>${e.explication}</td>
                    </tr>`).join("")}
            </tbody>
        </table>
    `;
});

// -------------------------------
// Statistiques
// -------------------------------
async function loadStats() {
    const res = await fetch(`${API_BASE}/activites`);
    const data = await res.json();

    document.getElementById("totalActivites").textContent = data.total;

    let totalErr = 0;
    for (const act of data.data) {
        const r = await fetch(`${API_BASE}/message/${act.numero}/erreurs`);
        const j = await r.json();
        totalErr += j.data.total;
    }
    document.getElementById("totalErreurs").textContent = totalErr;
}

// -------------------------------
// Init
// -------------------------------
loadActivities();
