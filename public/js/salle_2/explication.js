// Contrôle d'affichage des intros par étape (anti-flash + one-shot)
// Règle: on masque l'intro par défaut, sauf si un flag "show once" a été posé
// et qu'on ne vient pas d'une page d'aide/sous-étape.

// Étape 1
(function () {
    try {
        var isCurrent = /\/etape1(\/|$)/.test(location.pathname);
        if (!isCurrent) return;

        var SHOW_KEY = 'etape1_show_intro_once';  // posé par le bouton "Commencer" (one-shot)
        var SUP_KEY  = 'etape1_suppress_intro';   // posé quand on part vers aide/etape1a (pour ne pas re-montrer)
        var shouldShow = sessionStorage.getItem(SHOW_KEY) === '1';
        var suppress   = sessionStorage.getItem(SUP_KEY) === '1';
        var ref = document.referrer || '';
        var fromHelper = /\/(aide|etape1a)(\/|$)/.test(ref);

        // Par défaut on masque, sauf cas "je viens d'Accueil avec le flag one-shot"
        if (!shouldShow || suppress || fromHelper) {
            document.documentElement.classList.add('hide-intro');
        }
    } catch (e) {}
})();

// Étape 1a
(function () {
    try {
        var isCurrent = /\/etape1a(\/|$)/.test(location.pathname);
        if (!isCurrent) return;

        var SHOW_KEY = 'etape1a_show_intro_once';
        var SUP_KEY  = 'etape1a_suppress_intro';
        var shouldShow = sessionStorage.getItem(SHOW_KEY) === '1';
        var suppress   = sessionStorage.getItem(SUP_KEY) === '1';
        var ref = document.referrer || '';
        // Considère l'aide, l'étape parente et la sous-étape sœur comme "helper"
        var fromHelper = /\/(aide|etape1|etape1b)(\/|$)/.test(ref);

        if (!shouldShow || suppress || fromHelper) {
            document.documentElement.classList.add('hide-intro');
        }
    } catch (e) {}
})();

// Intro visibility control with reliable "reload shows intro" behavior

function isReload() {
    try {
        // Modern Navigation Timing
        const nav = performance.getEntriesByType?.('navigation')?.[0];
        if (nav && typeof nav.type === 'string') return nav.type === 'reload';
        // Legacy API fallback
        if (performance?.navigation) return performance.navigation.type === 1; // 1 = TYPE_RELOAD
    } catch (e) {}
    return false;
}

// Étape 1b
(function () {
    try {
        if (!/\/etape1b(\/|$)/.test(location.pathname)) return;

        const SHOW_KEY = 'etape1b_show_intro_once';
        const SUP_KEY  = 'etape1b_suppress_intro';

        const shouldShow = sessionStorage.getItem(SHOW_KEY) === '1';
        const suppress   = sessionStorage.getItem(SUP_KEY) === '1';
        const ref        = document.referrer || '';
        const fromHelper = /\/(aide|etape1|etape1a)(\/|$)/.test(ref);
        const reload     = isReload();


        if ((!shouldShow && !reload) || suppress || fromHelper) {
            document.documentElement.classList.add('hide-intro');
        } else {
            document.documentElement.classList.remove('hide-intro');
        }
    } catch (e) {}
})();

// Étape 2
(function () {
    try {
        if (!/\/etape2(\/|$)/.test(location.pathname)) return;

        const SHOW_KEY = 'etape2_show_intro_once';
        const SUP_KEY  = 'etape2_suppress_intro';

        const shouldShow = sessionStorage.getItem(SHOW_KEY) === '1';
        const suppress   = sessionStorage.getItem(SUP_KEY) === '1';
        const ref        = document.referrer || '';
        const fromHelper = /\/(aide|etape2)(\/|$)/.test(ref);
        const reload     = isReload();

        if ((!shouldShow && !reload) || suppress || fromHelper) {
            document.documentElement.classList.add('hide-intro');
        } else {
            document.documentElement.classList.remove('hide-intro');
        }
    } catch (e) {}
})();