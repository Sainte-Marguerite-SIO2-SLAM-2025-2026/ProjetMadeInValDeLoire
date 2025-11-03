(function () {
    var SHOW_KEY = 'etape1_show_intro_once';
    var SUP_KEY  = 'etape1_suppress_intro';

    try {
        // Si on est venu de "Commencer", consommer le flag "one-shot"
        if (sessionStorage.getItem(SHOW_KEY) === '1') {
            sessionStorage.removeItem(SHOW_KEY);
        }

        // Si un flag de suppression existe (retour d’aide/etape1a), s'assurer que l’intro est masquée et consommer le flag
        if (sessionStorage.getItem(SUP_KEY) === '1') {
            document.documentElement.classList.add('hide-intro');
            sessionStorage.removeItem(SUP_KEY);
        }

        // Avant de partir vers aide/etape1a, poser un flag pour que l’intro soit masquée au retour
        var toAide = document.querySelector('a.livre-contour');
        var toCode = document.querySelector('a.code-contour');
        var setSuppress = function () { try { sessionStorage.setItem(SUP_KEY, '1'); } catch (e) {} };

        ['click','mousedown','touchstart'].forEach(function(ev){
            if (toAide) toAide.addEventListener(ev, setSuppress, {capture:true});
            if (toCode) toCode.addEventListener(ev, setSuppress, {capture:true});
        });

        // Si on revient via le bouton "précédent" (bfcache), forcer le masquage
        window.addEventListener('pageshow', function (ev) {
            var navType = (performance.getEntriesByType && performance.getEntriesByType('navigation')[0]?.type) || (ev.persisted ? 'back_forward' : '');
            var ref = document.referrer || '';
            if (sessionStorage.getItem(SUP_KEY) === '1' || navType === 'back_forward' || /\/(aide|etape1a)(\/|$)/.test(ref)) {
                document.documentElement.classList.add('hide-intro');
            }
        });
    } catch (e) {}
})();