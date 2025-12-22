// ==================== GESTION DES ONGLETS ====================

document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', function() {
        const target = this.dataset.target;

        // Retirer la classe active
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

        // Ajouter la classe active
        this.classList.add('active');
        document.getElementById(target).classList.add('active');

        // Charger les données selon l'onglet
        if (target === 'activites') {
            loadActivitesTable();
        } else if (target === 'erreurs') {
            loadActivitiesForSelects();
            loadErreursTable();
        } else if (target === 'indices') {
            loadActivitiesForSelects();
            loadIndicesTable();
        } else if (target === 'stats') {
            loadStats();
        }
    });
});

// ==================== AFFICHAGE DES ALERTES ====================

function showAlert(message, type = 'success') {
    const alert = document.getElementById('alert');
    alert.textContent = message;
    alert.className = `alert alert-${type}`;
    alert.style.display = 'block';

    setTimeout(() => {
        alert.style.display = 'none';
    }, 5000);
}

// ==================== ACTIVITÉS - TABLEAU ====================

/**
 * Charger les activités dans un tableau
 */
async function loadActivitesTable() {
    const tbody = document.getElementById('activitiesTableBody');
    tbody.innerHTML = '<tr><td colspan="7" class="empty-state">Chargement...</td></tr>';

    try {
        const response = await fetch(`${API_URL}/activites`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success && data.data.length > 0) {
            tbody.innerHTML = data.data.map(act => {
                const difficulteLabel = getDifficulteLabel(act.difficulte_numero);
                const difficulteClass = getDifficulteClass(act.difficulte_numero);

                return `
                    <tr data-id="${act.activite_numero}">
                        <td><strong>#${act.activite_numero}</strong></td>
                        <td class="truncate" title="${escapeHtml(act.libelle)}">${escapeHtml(act.libelle)}</td>
                        <td><span class="badge ${difficulteClass}">${difficulteLabel}</span></td>
                        <td><span class="badge" style="background:#95a5a6">${act.nb_erreurs || 0}</span></td>
                        <td><span class="badge" style="background:#95a5a6">${act.nb_indices || 0}</span></td>
                        <td><small>${formatDate(act.created_at)}</small></td>
                        <td>
                            <div class="table-actions">
                                <button class="btn-edit" onclick="editActiviteModal(${act.activite_numero}, '${escapeHtml(act.libelle).replace(/'/g, "\\'")}', ${act.difficulte_numero})" title="Modifier">
                                    ✏️
                                </button>
                                <button class="btn-delete" onclick="deleteActivite(${act.activite_numero})" title="Supprimer">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="7" class="empty-state">📭 Aucune activité trouvée</td></tr>';
        }
    } catch (error) {
        tbody.innerHTML = '<tr><td colspan="7" class="empty-state" style="color:red">❌ Erreur lors du chargement</td></tr>';
        console.error('Erreur loadActivitesTable:', error);
    }
}

/**
 * Ajouter une activité
 */
document.getElementById('addActivityForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = '⏳ Ajout en cours...';

    const formData = new FormData(this);

    try {
        const response = await fetch(`${API_URL}/activites/add`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showAlert('✅ ' + data.message, 'success');
            this.reset();
            loadActivitesTable();
        } else {
            showAlert('❌ ' + (data.message || 'Erreur lors de l\'ajout'), 'error');
            if (data.errors) {
                console.error('Erreurs de validation:', data.errors);
            }
        }
    } catch (error) {
        showAlert('❌ Erreur lors de l\'ajout', 'error');
        console.error('Erreur addActivite:', error);
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
});

/**
 * Modifier une activité avec modal
 */
async function editActiviteModal(id, libelle, difficulte) {
    const newLibelle = prompt('📝 Nouveau libellé:', libelle);
    if (!newLibelle || newLibelle === libelle) {
        const confirmDiff = confirm('Voulez-vous modifier uniquement la difficulté ?');
        if (!confirmDiff) return;
    }

    const newDifficulte = prompt('🎯 Nouvelle difficulté (1=Facile, 2=Moyen, 3=Difficile):', difficulte);
    if (!newDifficulte) return;

    const formData = new FormData();
    formData.append('libelle', newLibelle || libelle);
    formData.append('difficulte_numero', newDifficulte);

    try {
        const response = await fetch(`${API_URL}/activites/update/${id}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showAlert('✅ ' + data.message, 'success');
            loadActivitesTable();
        } else {
            showAlert('❌ ' + (data.message || 'Erreur lors de la modification'), 'error');
        }
    } catch (error) {
        showAlert('❌ Erreur lors de la modification', 'error');
        console.error('Erreur editActivite:', error);
    }
}

/**
 * Supprimer une activité
 */
async function deleteActivite(id) {
    if (!confirm('⚠️ Voulez-vous vraiment supprimer cette activité ?\n\n⚠️ Toutes les erreurs et indices associés seront également supprimés !')) {
        return;
    }

    try {
        const response = await fetch(`${API_URL}/activites/delete/${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            showAlert('✅ ' + data.message, 'success');
            loadActivitesTable();
        } else {
            showAlert('❌ ' + (data.message || 'Erreur lors de la suppression'), 'error');
        }
    } catch (error) {
        showAlert('❌ Erreur lors de la suppression', 'error');
        console.error('Erreur deleteActivite:', error);
    }
}

// ==================== ERREURS - TABLEAU ====================

/**
 * Charger les erreurs dans un tableau
 */
async function loadErreursTable(activiteId = null) {
    const tbody = document.getElementById('errorsTableBody');
    tbody.innerHTML = '<tr><td colspan="6" class="empty-state">Chargement...</td></tr>';

    const url = activiteId
        ? `${API_URL}/erreurs?activite_id=${activiteId}`
        : `${API_URL}/erreurs`;

    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success && data.data.length > 0) {
            tbody.innerHTML = data.data.map(err => `
                <tr data-id="${err.erreur_numero}">
                    <td><strong>#${err.erreur_numero}</strong></td>
                    <td><small>${escapeHtml(err.activite_libelle || 'N/A')}</small></td>
                    <td><strong>${escapeHtml(err.mot_incorrect)}</strong></td>
                    <td class="truncate" title="${escapeHtml(err.explication)}">${escapeHtml(err.explication)}</td>
                    <td><small>${formatDate(err.created_at)}</small></td>
                    <td>
                        <div class="table-actions">
                            <button class="btn-edit" onclick="editErreurModal(${err.erreur_numero})" title="Modifier">
                                ✏️
                            </button>
                            <button class="btn-delete" onclick="deleteErreur(${err.erreur_numero})" title="Supprimer">
                                🗑️
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="6" class="empty-state">📭 Aucune erreur trouvée</td></tr>';
        }
    } catch (error) {
        tbody.innerHTML = '<tr><td colspan="6" class="empty-state" style="color:red">❌ Erreur lors du chargement</td></tr>';
        console.error('Erreur loadErreursTable:', error);
    }
}

/**
 * Ajouter une erreur
 */
document.getElementById('addErrorForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = '⏳ Ajout en cours...';

    const formData = new FormData(this);

    try {
        const response = await fetch(`${API_URL}/erreurs/add`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showAlert('✅ ' + data.message, 'success');
            this.reset();
            loadErreursTable();
        } else {
            showAlert('❌ ' + (data.message || 'Erreur lors de l\'ajout'), 'error');
        }
    } catch (error) {
        showAlert('❌ Erreur lors de l\'ajout', 'error');
        console.error('Erreur addErreur:', error);
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
});

/**
 * Modifier une erreur
 */
async function editErreurModal(id) {
    const newMot = prompt('📝 Nouveau mot incorrect:');
    if (!newMot) return;

    const newExplication = prompt('💬 Nouvelle explication:');
    if (!newExplication) return;

    const newActivite = prompt('🔢 Numéro de l\'activité:');
    if (!newActivite) return;

    const formData = new FormData();
    formData.append('mot_incorrect', newMot);
    formData.append('explication', newExplication);
    formData.append('activite_numero', newActivite);

    try {
        const response = await fetch(`${API_URL}/erreurs/update/${id}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            showAlert('✅ ' + data.message, 'success');
            loadErreursTable();
        } else {
            showAlert('❌ ' + (data.message || 'Erreur lors de la modification'), 'error');
        }
    } catch (error) {
        showAlert('❌ Erreur lors de la modification', 'error');
        console.error('Erreur editErreur:', error);
    }
}

/**
 * Supprimer une erreur
 */
async function deleteErreur(id) {
    if (!confirm('⚠️ Voulez-vous vraiment supprimer cette erreur ?')) return;

    try {
        const response = await fetch(`${API_URL}/erreurs/delete/${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            showAlert('✅ ' + data.message, 'success');
            loadErreursTable();
        } else {
            showAlert('❌ ' + (data.message || 'Erreur lors de la suppression'), 'error');
        }
    } catch (error) {
        showAlert('❌ Erreur lors de la suppression', 'error');
        console.error('Erreur deleteErreur:', error);
    }
}
// ==================== SELECTS ====================

/**
 * Charger les activités dans les selects
 */
async function loadActivitiesForSelects() {
    try {
        const response = await fetch(`${API_URL}/activites`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success && data.data.length > 0) {
            const options = data.data.map(act =>
                `<option value="${act.activite_numero}">#${act.activite_numero} - ${escapeHtml(act.libelle.substring(0, 50))}...</option>`
            ).join('');

            // Pour les erreurs
            const errorSelect = document.getElementById('errorActivitySelect');
            const viewErrorsSelect = document.getElementById('viewErrorsSelect');

            if (errorSelect) {
                errorSelect.innerHTML = '<option value="">Sélectionnez une activité</option>' + options;
            }

            if (viewErrorsSelect) {
                viewErrorsSelect.innerHTML = '<option value="">Toutes les erreurs</option>' + options;
            }

            // Pour les indices
            const indiceSelect = document.getElementById('indiceActivitySelect');
            const viewIndicesSelect = document.getElementById('viewIndicesSelect');

            if (indiceSelect) {
                indiceSelect.innerHTML = '<option value="">Sélectionnez une activité</option>' + options;
            }

            if (viewIndicesSelect) {
                viewIndicesSelect.innerHTML = '<option value="">Tous les indices</option>' + options;
            }
        }
    } catch (error) {
        console.error('Erreur loadActivitiesForSelects:', error);
    }
}

// Écouter les changements de filtres
document.getElementById('viewErrorsSelect')?.addEventListener('change', function() {
    loadErreursTable(this.value || null);
});

document.getElementById('viewIndicesSelect')?.addEventListener('change', function() {
    loadIndicesTable(this.value || null);
});

// ==================== STATISTIQUES ====================

/**
 * Charger les statistiques
 */
async function loadStats() {
    try {
        const response = await fetch(`${API_URL}/stats`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            const stats = data.data;

            // Mettre à jour les compteurs
            document.getElementById('totalActivites').textContent = stats.total_activites || 0;
            document.getElementById('totalErreurs').textContent = stats.total_erreurs || 0;
            document.getElementById('totalIndices').textContent = stats.total_indices || 0;

            // Afficher les détails dans un tableau
            const tbody = document.getElementById('statsDetailsTable');
            if (stats.activites && stats.activites.length > 0) {
                tbody.innerHTML = stats.activites.map(act => {
                    const difficulteLabel = getDifficulteLabel(act.difficulte_numero);
                    const difficulteClass = getDifficulteClass(act.difficulte_numero);

                    return `
                        <tr>
                            <td><strong>#${act.activite_numero}</strong></td>
                            <td>${escapeHtml(act.libelle)}</td>
                            <td><span class="badge ${difficulteClass}">${difficulteLabel}</span></td>
                            <td><span class="badge" style="background:#e74c3c">${act.nb_erreurs || 0}</span></td>
                            <td><span class="badge" style="background:#3498db">${act.nb_indices || 0}</span></td>
                        </tr>
                    `;
                }).join('');
            } else {
                tbody.innerHTML = '<tr><td colspan="5" class="empty-state">📭 Aucune donnée disponible</td></tr>';
            }
        }
    } catch (error) {
        console.error('Erreur loadStats:', error);
        showAlert('❌ Erreur lors du chargement des statistiques', 'error');
    }
}

// ==================== RECHERCHE ====================

// Recherche dans les activités
document.getElementById('searchActivites')?.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#activitiesTableBody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Recherche dans les erreurs
document.getElementById('searchErreurs')?.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#errorsTableBody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Recherche dans les indices
document.getElementById('searchIndices')?.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#indicesTableBody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// ==================== UTILITAIRES ====================

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' });
}

function getDifficulteLabel(num) {
    const labels = { 1: 'Facile', 2: 'Moyen', 3: 'Difficile' };
    return labels[num] || 'Inconnu';
}

function getDifficulteClass(num) {
    const classes = { 1: 'badge-facile', 2: 'badge-moyen', 3: 'badge-difficile' };
    return classes[num] || '';
}

// ==================== INITIALISATION ====================

document.addEventListener('DOMContentLoaded', function() {
    loadActivitesTable();
    console.log('✅ Interface admin Salle 1 initialisée');
});