/* Étape 5 v23 — Gestion du drag & drop des Post-it, reset conditionnel, classement et navigation */
(function() {
    const USE_LOCAL_STORAGE = true;

    // Identifiants des Post-it (pour restauration/réinitialisation)
    const POSTIT_IDS = ['p11','p10','p9','p8','p7','p6','p5','p4','p3','p2','p1'];

    // Type de navigation (navigate, reload, back_forward)
    let navType = 'unknown';
    try {
        const navEntry = performance.getEntriesByType('navigation')[0];
        if (navEntry) navType = navEntry.type;
    } catch(e){}

    // Paramètres URL pouvant forcer le reset
    const qs = location.search;
    const urlForcesReset = /(?:\?|&)(?:reset|actu|forceReset)=1/i.test(qs);

    // Arrivée externe (autre origine) => reset autorisé
    const externalArrival = document.referrer && !document.referrer.startsWith(location.origin);

    // Condition de reset automatique
    const SHOULD_AUTO_RESET =
        urlForcesReset ||
        navType === 'navigate' ||
        externalArrival;

    if (SHOULD_AUTO_RESET && USE_LOCAL_STORAGE) {
        POSTIT_IDS.forEach(id => localStorage.removeItem('postit_' + id));
        console.info('[Post-it Drag] Reset auto (navType=' + navType + ', params=' + qs + ', external=' + externalArrival + ')');
    } else {
        console.info('[Post-it Drag] Restauration conservée (navType=' + navType + ', params=' + qs + ', external=' + externalArrival + ')');
    }

    // Barème: mots de passe attendus comme valides
    const VALID_PASSWORDS = new Set(['@zertye2_3!','V@lise258!', 'Secur3P@sse2004!','Electroque10@a','Clued@565!']);
    function expectedFor(pw) { return VALID_PASSWORDS.has(pw) ? 'valid' : 'invalid'; }

    const postits = Array.from(document.querySelectorAll('.draggable-postit'));

    // Zones de drop
    const zoneValidWrapper   = document.getElementById('drop-valid');
    const zoneInvalidWrapper = document.getElementById('drop-invalid');
    const zoneValid          = document.getElementById('zone-feuille');
    const zoneInvalid        = document.getElementById('zone-poubelle');

    // UI
    const feedbackGlobal = document.getElementById('feedback-global');
    const btnCollecte    = document.getElementById('btn-collecte');
    const btnReset       = document.getElementById('btn-reset');

    const overlay        = document.getElementById('result-overlay');
    const listeValides   = document.getElementById('liste-valides');
    const listeInvalides = document.getElementById('liste-invalides');
    const listeNeutres   = document.getElementById('liste-neutres');
    const resumeGlobal   = document.getElementById('resume-global');
    const noteTexte      = document.getElementById('note-texte');
    const btnFermer      = document.getElementById('fermer-resultats');

    const successOverlay = document.getElementById('code-success-overlay');

    // Formulaire serveur (contrôleur Étape 5)
    const form = document.getElementById('form-jeu-validation');
    const inputResult = document.getElementById('input-resultat-jeu');
    function submitResult(isSuccess) {
        if (!form || !inputResult) {
            console.warn('[Post-it Drag] Formulaire introuvable, soumission impossible.');
            return;
        }
        inputResult.value = isSuccess ? '1' : '0';
        form.submit();
    }

    if (!zoneValidWrapper || !zoneInvalidWrapper || !zoneValid || !zoneInvalid || postits.length === 0) {
        console.warn('[Post-it Drag] Éléments manquants.');
        return;
    }

    // Cache le succès au chargement
    if (successOverlay) successOverlay.style.display = 'none';

    // Flag pour déclencher l’overlay de succès après fermeture
    let readyForSuccess = false;

    // Grille pour reset visuel
    const resetGrid = new Map();

    // Positionnement initial depuis grille CSS, ou restauration LS
    function initFromCssPositions() {
        const cols = 6, startX = 170, startY = 120, spacingX = 155, spacingY = 150;
        postits.forEach((p, i) => {
            if (USE_LOCAL_STORAGE && !SHOULD_AUTO_RESET && restorePostit(p)) {
                if (!resetGrid.has(p.dataset.id)) {
                    const row = Math.floor(i/cols), col = i%cols;
                    resetGrid.set(p.dataset.id, {
                        left: (startX + col*spacingX) + 'px',
                        top:  (startY + row*spacingY) + 'px'
                    });
                }
                return;
            }
            const row = Math.floor(i/cols), col = i%cols;
            const left = (startX + col*spacingX) + 'px';
            const top  = (startY + row*spacingY) + 'px';
            p.style.left = left;
            p.style.top  = top;
            p.style.bottom = 'auto';
            p.style.right  = 'auto';
            p.style.transform = 'none';
            p.classList.remove('is-valid','is-invalid');
            resetGrid.set(p.dataset.id, { left, top });
        });
    }

    function savePostit(p) {
        if (!USE_LOCAL_STORAGE) return;
        const data = {
            left: p.style.left,
            top:  p.style.top,
            state: p.classList.contains('is-invalid') ? 'invalid'
                : p.classList.contains('is-valid')   ? 'valid'
                    : 'neutral'
        };
        localStorage.setItem('postit_' + p.dataset.id, JSON.stringify(data));
    }
    function restorePostit(p) {
        const raw = localStorage.getItem('postit_' + p.dataset.id);
        if (!raw) return false;
        try {
            const data = JSON.parse(raw);
            p.style.left = data.left;
            p.style.top  = data.top;
            p.classList.remove('is-valid','is-invalid');
            if (data.state === 'valid')   p.classList.add('is-valid');
            if (data.state === 'invalid') p.classList.add('is-invalid');
            p.style.bottom = 'auto';
            p.style.right  = 'auto';
            p.style.transform = 'none';
            return true;
        } catch(e){ return false; }
    }

    initFromCssPositions();

    // Détection flexible (centre + ratio d’intersection)
    function inZoneFlexible(el, wrapper) {
        const zr = wrapper.getBoundingClientRect();
        const pr = el.getBoundingClientRect();
        const overlap = !(pr.right < zr.left || pr.left > zr.right || pr.bottom < zr.top || pr.top > zr.bottom);
        if (!overlap) return false;
        const cx = pr.left + pr.width/2;
        const cy = pr.top  + pr.height/2;
        if (cx >= zr.left && cx <= zr.right && cy >= zr.top && cy <= zr.bottom) return true;
        const il = Math.max(pr.left, zr.left);
        const ir = Math.min(pr.right, zr.right);
        const it = Math.max(pr.top,  zr.top);
        const ib = Math.min(pr.bottom,zr.bottom);
        const iw = Math.max(0, ir - il);
        const ih = Math.max(0, ib - it);
        const inter = iw * ih;
        const area  = pr.width * pr.height;
        return (inter / area) > 0.15;
    }

    function highlightValid(on){ zoneValidWrapper.classList.toggle('highlight', !!on); }
    function highlightInvalid(on){ zoneInvalidWrapper.classList.toggle('highlight', !!on); }

    function showFeedback(msg, type) {
        if (!feedbackGlobal) return;
        feedbackGlobal.textContent = msg;
        feedbackGlobal.className = 'feedback-global show';
        feedbackGlobal.style.border = '2px solid ' + (type==='valid' ? '#4caf50' : type==='invalid' ? '#e53935' : '#b08a43');
        clearTimeout(feedbackGlobal._t);
        feedbackGlobal._t = setTimeout(() => feedbackGlobal.classList.remove('show'), 2000);
    }

    // Drag & Drop pointeur
    let current=null, originX=0, originY=0, startLeft=0, startTop=0;

    function pointerDown(e){
        current = e.currentTarget;
        current.classList.add('dragging');
        const rect = current.getBoundingClientRect();
        originX = e.clientX; originY = e.clientY;
        startLeft = rect.left + window.scrollX; startTop = rect.top + window.scrollY;
        current.setPointerCapture(e.pointerId);
    }
    function pointerMove(e){
        if(!current) return;
        const dx = e.clientX - originX, dy = e.clientY - originY;
        current.style.left = (startLeft + dx) + 'px';
        current.style.top  = (startTop  + dy) + 'px';
        highlightValid(inZoneFlexible(current, zoneValidWrapper));
        highlightInvalid(inZoneFlexible(current, zoneInvalidWrapper));
    }
    function finalizeDrop(el, overValid, overInvalid){
        el.classList.remove('is-valid','is-invalid');
        if (overValid)   { el.classList.add('is-valid');   showFeedback('Classé VALIDE : '   + el.dataset.password, 'valid');   }
        else if(overInvalid){ el.classList.add('is-invalid'); showFeedback('Classé INVALIDE : ' + el.dataset.password, 'invalid'); }
        else             { showFeedback('Déplacement libre : ' + el.dataset.password, 'neutral'); }
        savePostit(el);
    }
    function pointerUp(e){
        if(!current) return;
        const overValid   = inZoneFlexible(current, zoneValidWrapper);
        const overInvalid = inZoneFlexible(current, zoneInvalidWrapper);
        current.classList.remove('dragging');
        highlightValid(false);
        highlightInvalid(false);
        finalizeDrop(current, overValid, overInvalid);
        current.releasePointerCapture(e.pointerId);
        current = null;
    }

    postits.forEach(p=>{
        p.addEventListener('pointerdown', pointerDown);
        p.addEventListener('pointermove', pointerMove);
        p.addEventListener('pointerup', pointerUp);
        p.addEventListener('pointercancel', pointerUp);
        p.setAttribute('tabindex','0');
    });

    // Contrôles clavier (grab avec Enter/Espace, déplacement au pas)
    let keyboardGrabbed=null;
    function keyHandler(e){
        const el = e.currentTarget;
        const step = e.shiftKey ? 24 : 10;
        if(['Enter',' '].includes(e.key)){
            e.preventDefault();
            if(keyboardGrabbed===el){
                const overValid   = inZoneFlexible(el, zoneValidWrapper);
                const overInvalid = inZoneFlexible(el, zoneInvalidWrapper);
                el.classList.remove('dragging');
                highlightValid(false); highlightInvalid(false);
                finalizeDrop(el, overValid, overInvalid);
                keyboardGrabbed=null;
            } else {
                keyboardGrabbed=el;
                el.classList.add('dragging');
            }
        }
        if(keyboardGrabbed===el){
            let left=parseInt(el.style.left||'0',10);
            let top =parseInt(el.style.top ||'0',10);
            if(e.key==='ArrowLeft'){ left-=step; e.preventDefault(); }
            if(e.key==='ArrowRight'){ left+=step; e.preventDefault(); }
            if(e.key==='ArrowUp'){ top-=step; e.preventDefault(); }
            if(e.key==='ArrowDown'){ top+=step; e.preventDefault(); }
            el.style.left = left+'px';
            el.style.top  = top +'px';
            highlightValid(inZoneFlexible(el, zoneValidWrapper));
            highlightInvalid(inZoneFlexible(el, zoneInvalidWrapper));
        }
    }
    postits.forEach(p=>p.addEventListener('keydown', keyHandler));

    // Collecte et affichage du classement + note
    function collectResultats(){
        return postits.map(p=>({
            id: p.dataset.id,
            password: p.dataset.password,
            state: p.classList.contains('is-invalid') ? 'invalid'
                : p.classList.contains('is-valid')   ? 'valid'
                    : 'neutral'
        }));
    }

    function afficherClassement(){
        if (successOverlay) successOverlay.style.display = 'none';
        readyForSuccess = false;

        const data = collectResultats();
        const valides   = data.filter(d=>d.state==='valid');
        const invalides = data.filter(d=>d.state==='invalid');
        const neutres   = data.filter(d=>d.state==='neutral');

        let correct = 0, wrong = 0;
        data.forEach(d => {
            const exp = expectedFor(d.password);
            if (d.state === 'neutral') { wrong++; return; }
            if (d.state === exp) correct++; else wrong++;
        });
        const total = data.length;
        const pct = total ? ((correct/total)*100).toFixed(1)+'%' : '0%';
        noteTexte.textContent = `NOTE: ${correct}/${total} (${pct}) — Mauvaises réponses: ${wrong}`;
        resumeGlobal.innerHTML = `Objectif: 7/11. ${correct >= 7 ? '✅ Tu peux fermer pour valider définitivement.' : '❌ Essaie encore.'}`;

        listeValides.innerHTML   = valides.length   ? valides.map(v=>`<li><span>${v.password}</span><span class="badge-valid">✅</span></li>`).join('') : '<li>Aucun</li>';
        listeInvalides.innerHTML = invalides.length ? invalides.map(v=>`<li><span>${v.password}</span><span class="badge-invalid">❌</span></li>`).join('') : '<li>Aucun</li>';
        listeNeutres.innerHTML   = neutres.length   ? neutres.map(v=>`<li><span>${v.password}</span><span class="badge-neutral">⚠️</span></li>`).join('') : '<li>Aucun</li>';

        overlay.classList.remove('is-hidden');

        // Autorise l’overlay de succès si objectif atteint
        if (correct >= 7) {
            readyForSuccess = true;
        }
    }

    btnCollecte?.addEventListener('click', ()=>{
        afficherClassement();
        showFeedback('Classement généré', 'neutral');
        console.table(collectResultats());
    });

    btnFermer?.addEventListener('click', ()=>{
        overlay.classList.add('is-hidden');
        if (readyForSuccess && successOverlay) {
            // Affiche l’overlay de succès avec bouton Continuer (fourni par la vue)
            successOverlay.style.display = 'grid';
            const continueBtn = successOverlay.querySelector('button');
            continueBtn?.focus();
            // Pour auto-clic éventuel:
            // setTimeout(()=> continueBtn?.click(), 800);
        } else {
            // Soumet échec pour comptabilisation côté serveur (mode nuit)
            submitResult(false);
        }
    });

    // Reset manuel via bouton
    function resetPositions(){
        POSTIT_IDS.forEach(id => localStorage.removeItem('postit_' + id));
        const cols = 6, startX = 170, startY = 120, spacingX = 155, spacingY = 150;
        postits.forEach((p,i)=>{
            const row = Math.floor(i/cols), col = i%cols;
            p.style.left = (startX + col*spacingX) + 'px';
            p.style.top  = (startY + row*spacingY) + 'px';
            p.classList.remove('is-valid','is-invalid','dragging');
        });
        if (overlay) overlay.classList.add('is-hidden');
        if (successOverlay) successOverlay.style.display = 'none';
        readyForSuccess = false;
        showFeedback('Positions réinitialisées', 'neutral');
    }
    btnReset?.addEventListener('click', resetPositions);

})();

// Masque les éléments de jeu quand l’overlay de succès est affiché
document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('code-success-overlay');

    if (!overlay) return;

    const elementsToHideSelectors = [
        '.mascotte-container',
        '#mascotte-bulle',
        '#message-intro',
        '.validate-container-left'
    ];

    const hideGameElements = () => {
        elementsToHideSelectors.forEach(selector => {
            const el = document.querySelector(selector);
            if (el) {
                el.style.setProperty('display', 'none', 'important');
            }
        });
    };

    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                const display = window.getComputedStyle(overlay).display;
                if (display !== 'none') {
                    hideGameElements();
                }
            }
        });
    });

    observer.observe(overlay, { attributes: true, attributeFilter: ['style'] });
});

// Navigation explicite en mode nuit via bouton "Continuer"
document.addEventListener('DOMContentLoaded', function() {
    const btnNight = document.getElementById('btn-continuer-nuit');
    if (btnNight) {
        btnNight.addEventListener('click', function() {
            const next = btnNight.getAttribute('data-next-url') || '#';
            if (next && next !== '#') {
                window.location.href = next;
            }
        });
    }
});