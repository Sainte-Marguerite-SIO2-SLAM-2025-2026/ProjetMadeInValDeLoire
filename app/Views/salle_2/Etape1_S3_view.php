<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Couloir du Bureau | Salle Mot de Passe</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/Etape1_Salle3.jpg') ?>">

    <script>
        (function () {
            try {
                var SHOW_KEY = 'etape1_show_intro_once';
                var SUP_KEY  = 'etape1_suppress_intro';
                var shouldShow = sessionStorage.getItem(SHOW_KEY) === '1';
                var suppress   = sessionStorage.getItem(SUP_KEY) === '1';
                var ref = document.referrer || '';
                var fromHelper = /\/(aide|etape1a)(\/|$)/.test(ref);
                if (!shouldShow || suppress || fromHelper) {
                    document.documentElement.classList.add('hide-intro');
                }
            } catch (e) {}
        })();
    </script>

    <link rel="stylesheet" href="<?= base_url('/styles/salle_2/style_etape_S3.css') ?>?v=8">
</head>
<body>

    <?php if (session()->get('mode') === 'jour'): ?>
        <div class="bouton-accueil-cluedo">
            <?= anchor('/manoirJour',
                    img([
                            'src' => base_url('images/commun/btn_retour/home_icone_7.webp'),
                            'alt' => 'Mascotte',
                            'class' => 'bouton-accueil-cluedo'
                    ])
            ) ?>
        </div>
    <?php else: ?>
        <div class="bouton-accueil-cluedo">
            <?= anchor('/',
                    img([
                            'src' => base_url('images/commun/btn_retour/home_icone_7.webp'),
                            'alt' => 'Mascotte',
                            'class' => 'bouton-accueil-cluedo'

                    ])
            ) ?>
        </div>
    <?php endif?>


    <div class="bouton-accueil-cluedo-container">
        <img src="<?= base_url('images/salle_2/maison/home_icone_7.png') ?>" alt="Mascotte">
    </div>
</a>


<div class="game-fixed-wrapper">

    <div class="accueil-bg" style="background-image:url('<?= base_url('/images/salle_2/Etape1_Salle3.jpg') ?>');"></div>

    <div class="center-container">
        <label for="poignier-toggle" class="poignier-contour" aria-controls="poignier-overlay" aria-haspopup="dialog"></label>
        <a class="code-contour" href="<?= base_url('Etape1a') ?>"></a>
        <a class="livre-contour" href="<?= base_url('Salle2-Aide') ?>"></a>
    </div>

    <aside class="tip-panel" role="note" aria-live="polite">
        <p class="tip-desc">Astuce : Vous pouvez cliquer sur le livre pour pouvoir revoir les informations !</p>
    </aside>

    <aside id="intro-tip" class="tip-panel tip-panel--top tip-panel--autohide" role="status" aria-live="polite">
        <p class="tip-desc">
            Étape 1 : Ouvrir cette porte avec le code fourni par le détective Fox. Attention : si tu réussis, tu devras par la suite choisir un nouveau code pour la porte !
        </p>
    </aside>

    <input type="checkbox" id="poignier-toggle" class="sr-only" aria-hidden="true" />
    <div id="poignier-overlay" class="poignier-overlay" role="dialog" aria-modal="true" aria-labelledby="poignier-texte">
        <aside class="poignier-panel">
            <p id="poignier-texte" class="tip-desc">
                Mhh Bizarre la porte est fermé, je pense je devrais tape le code.
            </p>
            <label for="poignier-toggle" class="tip-btn" aria-label="Fermer ce message et continuer">Continuer</label>
        </aside>
    </div>

</div>
<div class="scroll-flow">
    <div class="scroll-spacer"></div>
</div>


<script src="<?= base_url('/assets/js/etape1.js') ?>" defer></script>
</body>
</html>