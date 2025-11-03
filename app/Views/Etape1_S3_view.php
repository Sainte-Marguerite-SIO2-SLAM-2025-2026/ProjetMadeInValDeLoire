<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Couloir du Bureau | Salle N°3</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preload" as="image" href="<?= base_url('/assets/images/Etape1_Salle3.jpeg') ?>">

    <script>
        (function () {
            // Masquage anti-flash décidé le plus tôt possible
            try {
                var SHOW_KEY = 'etape1_show_intro_once';   // posé par le bouton "Commencer"
                var SUP_KEY  = 'etape1_suppress_intro';    // posé quand on part vers aide/etape1a
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
    </script>

    <link rel="stylesheet" href="<?= base_url('/assets/css/style_etape_S3.css') ?>?v=7">
</head>
<body>
<div class="accueil-bg" style="background-image:url('<?= base_url('/assets/images/Etape1_Salle3.jpeg') ?>');"></div>

<div class="center-container">
    <label for="poignier-toggle" class="poignier-contour" aria-controls="poignier-overlay" aria-haspopup="dialog"></label>
    <a class="code-contour" href="<?= base_url('etape1a') ?>"></a>
    <a class="livre-contour" href="<?= base_url('aide') ?>"></a>
</div>

<aside class="tip-panel" role="note" aria-live="polite">
    <p class="tip-desc">Astuce : Vous pouvez cliquer sur le livre pour pouvoir revoir le code.</p>
</aside>

<aside id="intro-tip" class="tip-panel tip-panel--top tip-panel--autohide" role="status" aria-live="polite">
    <p class="tip-desc">
        Etape 1 : Essaye d'ouvrir cette porte avec le code fournis pour le Detective Renard , Attention si tu réussi tu devra par la suite choisir un nouveau code pour la porte !
    </p>
</aside>

<input type="checkbox" id="poignier-toggle" class="sr-only" aria-hidden="true" />
<div id="poignier-overlay" class="poignier-overlay" role="dialog" aria-modal="true" aria-labelledby="poignier-texte">
    <aside class="poignier-panel">
        <p id="poignier-texte" class="tip-desc">
            Mhh Bizarre la porte est fermé, je pense je devrait tape le code.
        </p>
        <label for="poignier-toggle" class="tip-btn" aria-label="Fermer ce message et continuer">Continuer</label>
    </aside>
</div>
    <script src="<?= base_url('/assets/js/etape1.js') ?>" defer></script>
</body>
</html>