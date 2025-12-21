let oldData = {};

function showSection(name) {
    document.querySelectorAll('.content-section, #generic-form').forEach(e => e.classList.add('hidden'));
    document.querySelectorAll('.nav-card').forEach(e => e.classList.remove('active'));
    const section = document.getElementById('section-' + name);
    if(section) section.classList.remove('hidden');
    const nav = document.getElementById('nav-' + name);
    if(nav) nav.classList.add('active');
}

function setupNumeroSanitizer() {
    const numero = document.getElementById('inp-numero');
    if (!numero) return;

    // Force uniquement des chiffres dans le champ
    const sanitize = () => {
        numero.value = (numero.value || '').replace(/\D/g, '');
    };
    numero.addEventListener('input', sanitize);

    // Optionnel: empêcher le collage de caractères non numériques
    numero.addEventListener('paste', (e) => {
        e.preventDefault();
        const text = (e.clipboardData || window.clipboardData).getData('text');
        const digits = (text || '').replace(/\D/g, '');
        const start = numero.selectionStart ?? numero.value.length;
        const end = numero.selectionEnd ?? numero.value.length;
        const value = numero.value;
        numero.value = value.slice(0, start) + digits + value.slice(end);
    });

    // Nettoyage initial
    sanitize();
}

function openForm(type, mode, id='', num='', desc='', val='') {
    document.querySelectorAll('.content-section').forEach(e => e.classList.add('hidden'));
    document.getElementById('generic-form').classList.remove('hidden');

    oldData = { type, id, num, desc, val, mode };

    document.getElementById('inp-type').value = type;
    document.getElementById('inp-id').value = id;
    document.getElementById('inp-numero').value = num ?? '';
    document.getElementById('inp-desc').value = desc ?? '';

    setupNumeroSanitizer();

    // Pré-remplissage du combo box pour l’étape (valeur)
    const selectValeur = document.getElementById('inp-valeur');
    if (selectValeur) {
        selectValeur.value = val || ''; // si val correspond à une des options, ça sélectionne automatiquement
    }

    const lbl = document.getElementById('lbl-desc');
    const grpVal = document.getElementById('group-valeur');
    const lblVal = document.getElementById('lbl-valeur');

    if(type === 'mdp') {
        if (lbl) lbl.innerText = "Mot de Passe";
        if (grpVal) grpVal.classList.remove('hidden-field');
        if (lblVal) lblVal.innerText = "Étape";
        if (selectValeur) selectValeur.required = true; // Étape obligatoire pour MDP
    } else {
        if (lbl) lbl.innerText = "Libellé / Description";
        if (grpVal) grpVal.classList.add('hidden-field');
        if (lblVal) lblVal.innerText = "Valeur Associée";
        // Nettoyage du select si on quitte MDP
        if (selectValeur) {
            selectValeur.value = '';
            selectValeur.required = false; // Ne pas bloquer la validation pour autres types
        }
    }

    const titleEl = document.getElementById('form-title');
    if (titleEl) {
        titleEl.innerText = (mode==='add'?'Ajouter ':'Modifier ') + type.toUpperCase();
    }
}

function closeForm() {
    const currentType = document.getElementById('inp-type').value || 'explication';
    showSection(currentType);
}

// Récupération de la base URL de suppression depuis le data-attribute de <body>
function getDeleteBaseUrl() {
    const base = document.body?.dataset?.deleteBase;
    return base || '/gingembre/deleteElement'; // fallback si l’attribut n’est pas présent
}

function confirmDelete(type, id, numero, libelle) {
    Swal.fire({
        title: 'SUPPRESSION',
        html: `
                <div class="diff-container" style="border-left-color: #ff7675;">
                    <b style="color:#ff7675">Attention :</b> Vous allez supprimer l'élément suivant :<br><br>
                    <b>Type :</b> ${String(type || '').toUpperCase()}<br>
                    <b>N° :</b> ${numero}<br>
                    <b>Contenu :</b> ${libelle}
                </div><br>Confirmer l'action ?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff7675',
        cancelButtonColor: '#2d3436',
        confirmButtonText: 'OUI, SUPPRIMER',
        cancelButtonText: 'ANNULER'
    }).then((result) => {
        if (result.isConfirmed) {
            const base = getDeleteBaseUrl();

            // Garde-fous basiques
            if (!type || !id) {
                console.error('Suppression impossible : type ou id manquant.', { type, id });
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Suppression impossible : type ou id manquant.'
                });
                return;
            }

            // Construction de l’URL finale en GET (Route: gingembre/deleteElement/(:segment)/(:num))
            const url = `${base}/${encodeURIComponent(type)}/${encodeURIComponent(id)}`;
            window.location.href = url;
        }
    })
}

function confirmSave() {
    const form = document.getElementById('main-form');
    const newNum = document.getElementById('inp-numero').value;
    const newDesc = document.getElementById('inp-desc').value;
    const selectEl = document.getElementById('inp-valeur');
    const newVal = selectEl ? selectEl.value : '';
    const currentType = document.getElementById('inp-type').value;

    // Validation stricte avant d'ouvrir la confirmation
    const errors = [];

    // Numéro: uniquement des chiffres et non vide
    if (!/^\d+$/.test(newNum)) {
        errors.push('Le champ "Numéro" doit contenir uniquement des chiffres (0-9) et ne peut pas être vide.');
    }

    // Description: non vide
    if (!newDesc || newDesc.trim().length === 0) {
        errors.push('Le champ "Description" est obligatoire.');
    }

    // Étape: obligatoire si type MDP
    if (currentType === 'mdp') {
        if (!newVal || newVal.trim().length === 0) {
            errors.push('Le champ "Étape" est obligatoire pour un mot de passe.');
        }
    }

    // Si erreurs -> afficher et stopper
    if (errors.length > 0) {
        Swal.fire({
            icon: 'error',
            title: 'Champs manquants ou invalides',
            html: `<ul style="text-align:left; margin:0; padding-left:18px;">${errors.map(e => `<li>${e}</li>`).join('')}</ul>`
        });
        return;
    }

    // Passer la validation HTML5 pour feedback natif si besoin
    if (form && !form.checkValidity()) {
        form.reportValidity();
        return;
    }

    let diffHtml = '';
    if (oldData.mode === 'edit') {
        diffHtml = `<div class="diff-container">`;
        if(oldData.num != newNum) diffHtml += `<div class="diff-old">N° : ${oldData.num}</div><div class="diff-new">N° : ${newNum}</div><hr>`;
        if(oldData.desc != newDesc) diffHtml += `<div class="diff-old">Texte : ${oldData.desc}</div><div class="diff-new">Texte : ${newDesc}</div><hr>`;
        if(oldData.val != newVal) diffHtml += `<div class="diff-old">Valeur : ${oldData.val}</div><div class="diff-new">Valeur : ${newVal}</div>`;
        diffHtml += `</div>`;
    } else {
        // Mode ajout
        diffHtml = `<div class="diff-container" style="border-left-color: #55efc4;">
            <b style="color:#55efc4">NOUVEL ÉLÉMENT :</b><br><br>
            <b>N° :</b> ${newNum}<br><b>Texte :</b> ${newDesc}`;
        // Afficher l’étape si on est sur MDP
        if (currentType === 'mdp' && newVal) {
            diffHtml += `<br><b>Étape :</b> ${newVal}`;
        }
        diffHtml += `</div>`;

        // Rappels spécifiques selon l’étape choisie pour MDP
        if (currentType === 'mdp') {
            let rappelHtml = '';
            if (newVal === 'Etape1a') {
                rappelHtml = `<div class="diff-container" style="border-left-color:#ffeaa7;">
                    <b style="color:#ffeaa7">RAPPEL :</b><br>
                    N'oubliez pas de modifier le champ <b>Explication</b> numéro <b>12</b>, <b>13</b>, <b>14</b>.
                </div>`;
            } else if (newVal === 'Etape2') {
                rappelHtml = `<div class="diff-container" style="border-left-color:#ffeaa7;">
                    <b style="color:#ffeaa7">RAPPEL :</b><br>
                    N'oubliez pas de modifier le champ <b>Mot de passe</b> numéro <b>25</b>, <b>26</b>, <b>27</b>, <b>28</b>.
                </div>`;
            }
            if (rappelHtml) {
                diffHtml += `<br>${rappelHtml}`;
            }
        }
    }

    Swal.fire({
        title: 'ENREGISTREMENT',
        html: diffHtml + '<br>Valider les modifications ?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#55efc4',
        cancelButtonColor: '#2d3436',
        confirmButtonText: 'OUI, ENREGISTRER',
        cancelButtonText: 'RETOUR'
    }).then((result) => {
        if (result.isConfirmed) {
            // Utiliser requestSubmit pour déclencher la validation HTML5
            if (form && typeof form.requestSubmit === 'function') {
                form.requestSubmit();
            } else if (form) {
                // Fallback
                form.submit();
            }
        }
    })
}

window.onload = function() {
    setupNumeroSanitizer();

    if(window.location.hash) {
        const section = window.location.hash.replace('#section-', '');
        if(document.getElementById('section-'+section)) {
            showSection(section);
        }
    }
}