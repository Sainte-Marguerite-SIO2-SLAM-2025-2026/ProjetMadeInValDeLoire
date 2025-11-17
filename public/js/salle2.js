/*document.addEventListener("DOMContentLoaded", () => {

    const envelopesContainer = document.querySelector(".envelopes");
    const modal = document.getElementById("mail-modal");
    const mailContent = document.getElementById("mail-content");
    const closeModal = document.getElementById("close-modal");
    const btnLegit = document.getElementById("btn-legit");
    const btnPhish = document.getElementById("btn-phish");
    const btnValider = document.getElementById("validate-btn");

    const mails = window.MAILS || [];
    const choices = Array(mails.length).fill(null);
    let currentIndex = null;

    function creerEnveloppe(index) {
        const env = document.createElement('div');
        env.className = 'enveloppe';
        env.dataset.index = index;
        env.innerHTML = `<div class="env-front"><span class="env-number">${index + 1}</span></div>`;
        env.addEventListener('click', () => openModal(index));
        return env;
    }

    function initEnveloppes() {
        envelopesContainer.innerHTML = '';
        if (mails.length === 0) {
            envelopesContainer.innerHTML = '<p>Aucun mail à trier.</p>';
            return;
        }
        mails.forEach((_, i) => envelopesContainer.appendChild(creerEnveloppe(i)));
        updateValiderButton();
    }

    function openModal(index) {
        currentIndex = index;
        const m = mails[index];

        mailContent.innerHTML = `
            <p><strong>Expéditeur :</strong> ${escapeHtml(m.expediteur ?? '')}</p>
            <p><strong>Objet :</strong> ${escapeHtml(m.objet ?? '')}</p>
            <p>${escapeHtml(m.contenu1 ?? "")}<br>${escapeHtml(m.contenu2 ?? '')}</p>
        `;

        btnLegit.classList.toggle('selected', choices[index] === 'legit');
        btnPhish.classList.toggle('selected', choices[index] === 'phish');

        modal.classList.remove('hidden');
    }

    closeModal.addEventListener('click', () => {
        modal.classList.add('hidden');
        currentIndex = null;
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            currentIndex = null;
        }
    });

    btnLegit.addEventListener('click', () => {
        markCurrent('legit');
        modal.classList.add('hidden');
        currentIndex = null;
    });

    btnPhish.addEventListener('click', () => {
        markCurrent('phish');
        modal.classList.add('hidden');
        currentIndex = null;
    });

    function markCurrent(choice) {
        if (currentIndex === null) return;
        choices[currentIndex] = choice;

        const env = document.querySelector(`.enveloppe[data-index="${currentIndex}"]`);
        if (env) {
            env.classList.remove('mark-legit', 'mark-phish');
            if (choice === 'legit') env.classList.add('mark-legit');
            if (choice === 'phish') env.classList.add('mark-phish');
        }

        btnLegit.classList.toggle('selected', choice === 'legit');
        btnPhish.classList.toggle('selected', choice === 'phish');

        updateValiderButton();
    }

    function updateValiderButton() {
        const allMarked = choices.every(c => c === 'legit' || c === 'phish');
        btnValider.disabled = !allMarked;
        btnValider.classList.toggle('ready', allMarked);
    }

    btnValider.addEventListener('click', async () => {
        const payload = mails.map((m, i) => ({
            id: m.id ?? i,
            choix: choices[i]
        }));

        try {
            btnValider.disabled = true;
            btnValider.textContent = 'Envoi...';

            const res = await fetch(window.BASE_URL + '/salle2/submit', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ resultat: payload })
            });

            if (!res.ok) throw new Error(`Erreur serveur: ${res.status}`);

            const json = await res.json();
            alert(json.message || 'Résultats enregistrés. Bravo !');
        } catch (err) {
            console.error(err);
            alert('Erreur lors de l\'envoi — réessaie plus tard.');
        } finally {
            btnValider.textContent = 'Valider mes choix';
            btnValider.disabled = false;
        }
    });

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    initEnveloppes();
});*/

/* Accueil de la salle 2 */
document.addEventListener('DOMContentLoaded', () => {
    const table = document.querySelector('.bureau-wrapper');
    if (table) {
        table.addEventListener('click', () => {
            window.location.href = BASE_URL + "public/Salle2/Enigme";
        });
    }
});

/* Partie énigme de la salle 2 */

document.addEventListener('DOMContentLoaded', () => {
    const envelopes = document.querySelectorAll('.enveloppe');
    const container = document.querySelector('.table-container');
    const modal = document.getElementById('enveloppe-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalText = document.getElementById('modal-text');
    const btnClose = document.getElementById('modal-close');
    const btnLegit = document.getElementById('btn-legit');
    const btnFraude = document.getElementById('btn-fraude');

    let currentId = null;

    // charge état depuis localStorage (si existant)
    let states = JSON.parse(localStorage.getItem('enigme_states') || '{}');

    const mapAreas = document.querySelectorAll('area[data-zone]');

    mapAreas.forEach(area => {
        area.addEventListener('click', (e) => {
            e.preventDefault();
            const zoneId = area.dataset.zone;
            openZoneModal(zoneId);
        });
    });

    function openZoneModal(zoneId) {
        const zoneContent = {
            '1': {title: 'Enveloppe 1', text: 'Contenu enveloppe 1'},
            '2': {title: 'Enveloppe 2', text: 'Contenu enveloppe 2'},
            '3': {title: 'Enveloppe 3', text: 'Contenu enveloppe 3'},
            '4': {title: 'Enveloppe 4', text: 'Contenu enveloppe 4'},
            '5': {title: 'Enveloppe 5', text: 'Contenu enveloppe 5'},
            '6': {title: 'Enveloppe 6', text: 'Contenu enveloppe 6'},
            '7': {title: 'Enveloppe 7', text: 'Contenu enveloppe 7'},
            '8': {title: 'Enveloppe 8', text: 'Contenu enveloppe 8'},
            '9': {title: 'Enveloppe 9', text: 'Contenu enveloppe 9'},
            '10': {title: 'Enveloppe 10', text: 'Contenu enveloppe 10'},
        };

        const content = zoneContent[zoneId] || {title: 'Zone', text: 'Contenu par défaut'};

        modalTitle.textContent = content.title;
        modalText.textContent = content.text;
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
    }


    function openModal(el) {
        currentId = el.dataset.id;
        const content = el.dataset.content || "Aucun contenu.";
        modalTitle.textContent = `Enveloppe ${currentId}`;
        modalText.textContent = content;
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
        currentId = null;
    }

    envelopes.forEach(envelope => {
        envelope.addEventListener('click', (e) => {
            // si tu veux empêcher l'ouverture après tri, commente la ligne suivante
            // if (envelope.classList.contains('state-legit') || envelope.classList.contains('state-phish')) return;
            openModal(envelope);
        });
    });

    btnClose.addEventListener('click', closeModal);

    // clic en dehors du modal pour fermer
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // actions des boutons
    btnLegit.addEventListener('click', () => {
        if (!currentId) return;
        setState(currentId, 'state-legit');
        closeModal();
    });

    btnFraude.addEventListener('click', () => {
        if (!currentId) return;
        setState(currentId, 'state-phish');
        closeModal();
    });

    function setState(id, stateClass) {
        const el = document.querySelector(`.enveloppe[data-id="${id}"]`);
        if (!el) return;

        // retire classes d'état précédentes
        el.classList.remove('state-legit', 'state-phish', 'state-opened');
        // applique la nouvelle
        el.classList.add(stateClass);

        // marque ouvert si tu veux garder une marque
        el.classList.add('state-opened');

        // change l'image si tu préfères (optionnel)
        // ex: remplacer closed.svg par open.svg
        const img = el.querySelector('.enveloppe-img');
        if (img) {
            // si tu as plusieurs images selon l'état, adapte les chemins
            if (stateClass === 'state-legit') {
                img.src = BASE_URL + 'public/images/enveloppes/enveloppe_bleue.webp'; // crée cette image
            } else if (stateClass === 'state-phish') {
                img.src = BASE_URL + 'public/images/enveloppes/enveloppe_jaune.webp';
            }
        }

        // sauvegarde dans localStorage
        states[id] = stateClass;
        localStorage.setItem('enigme_states', JSON.stringify(states));
    }

    // Option : reset (décommenter et créer un bouton si besoin)
    // document.getElementById('reset-btn').addEventListener('click', () => {
    //     localStorage.removeItem('enigme_states');
    //     location.reload();
    // });
});


