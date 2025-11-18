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
