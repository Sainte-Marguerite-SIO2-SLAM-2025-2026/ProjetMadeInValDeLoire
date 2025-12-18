<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Téléphone | Salle Mot de Passe</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/Etape4_Salle3.webp') ?>">
    <link rel="stylesheet" href="<?= base_url('/styles/salle_2/style_etape_S3.css') ?>?v=4">

    <?php if (!empty($success)): ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="<?= base_url('styles/salle_2/style_fin_S3.css') ?>">
    <?php endif; ?>
</head>
<body>

<?php if (session()->get('mode') === 'jour'): ?>
    <div class="bouton-accueil-cluedo">
        <?= anchor('/manoirJour',
                img([
                        'src' => base_url('images/commun/btn_retour/home_icone_7.webp'),
                        'alt' => 'Accueil',
                        'class' => 'bouton-accueil-cluedo'
                ])
        ) ?>
    </div>
<?php else: ?>
    <div class="bouton-accueil-cluedo">
        <?= anchor('/',
                img([
                        'src' => base_url('images/commun/btn_retour/home_icone_7.webp'),
                        'alt' => 'Accueil',
                        'class' => 'bouton-accueil-cluedo'
                ])
        ) ?>
    </div>
<?php endif?>

<div class="game-fixed-wrapper">

    <div class="accueil-bg" style="background-image:url('<?= base_url('/images/salle_2/Etape4_Salle3.webp') ?>');"></div>

    <form method="post" action="<?= site_url('Salle2/Etape4') ?>">
        <?= csrf_field() ?>

        <div class="genere-telephone"
             id="genere-telephone"
             data-url="<?= base_url('Salle2/Etape4/password-random') ?>"
             style="cursor:pointer;"
             aria-label="Générer un nouveau mot de passe">
        </div>

        <div class="ecran-telephone" aria-live="polite">
            <span id="password-display" class="password-display"></span>
        </div>

        <input type="hidden" name="code" id="code-hidden" value="">

        <div class="validate-container">
            <button type="submit" id="btn-validate" class="btn btn--ghost btn--xl btn-passe">
                Valider
            </button>
        </div>

    </form>

    <aside id="message-intro"
           class="tip-panel tip-panel--top tip-panel--autohide"
           role="status"
           aria-live="polite"
           style="<?= (!empty($error) || !empty($success)) ? 'display:none !important;' : '' ?>">
        <p class="tip-desc">
            <?= $libelles->libelle ?? '' ?>
        </p>
    </aside>

    <script>
        (function() {
            if (performance.getEntriesByType("navigation")[0]?.type === 'reload') {
                const msg = document.getElementById('message-intro');
                if(msg) msg.style.display = 'none';
            }
        })();
    </script>

    <article class="aide-telephone">
        <p><strong>Information importante à retenir !</strong></p>
        <p>Pour trouver le code, vous devez appuyer sur le bouton en orange. Cette action permet de générer automatiquement un mot de passe sécurisé et unique.</p>
        <p>Attention, le mot de passe peut être plus ou moins complexe!</p>
    </article>

    <?php if (!empty($success)): ?>
        <div class="final-popup-overlay" role="dialog" aria-modal="true" aria-labelledby="final-title">
            <img src="<?= base_url('/images/salle_2/accueil_salle3.webp') ?>" alt="Fond" class="accueil-bg">

            <main class="final-screen-wrapper">
                <div class="particles-layer">
                    <div class="flying-item item-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                    </div>
                    <div class="flying-item item-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                </div>

                <div class="final-popup-container">
                    <div class="mascot-final-wrapper">
                        <img src="<?= base_url('/images/salle_2/mascotte/mascotte_contente.svg') ?>" alt="Monsieur Fox">
                    </div>

                    <h1 class="final-title" id="final-title">Félicitations !</h1>

                    <p class="final-text">
                        Bravo, détective. Vous avez terminé <strong> étapes</strong>.
                        <br><br>
                        Le manoir vous ouvre désormais ses secrets les plus profonds...
                    </p>

                    <div class="final-actions">
                        <a href="<?= base_url('Salle2/Etape5') ?>" class="btn btn--xl btn-nuit trigger-popup" data-mode="Nuit">
                            Passer à la salle Suivante
                        </a>
                    </div>
                </div>
            </main>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div id="code-error"
             role="alert"
             aria-live="assertive"
             style="
                position: absolute;
                top: calc(43% + 0px);
                left: 0;
                width: 133%;
                padding: 0.25em 0;
                margin: 0;
                text-align: center;
                font: inherit;
                font-size: 1em;
                font-weight: 700;
                color: #ff3b30;
                background: transparent;
                pointer-events: none;
                z-index: 2;
            ">
            <?= esc($error) ?>
        </div>
    <?php else: ?>
        <div id="code-error" style="display:none;" aria-live="polite"></div>
    <?php endif; ?>

    <?php if (empty($success)): ?>
        <div class="mascotte-container">
            <img id="mascotte"
                 src="<?= base_url('images/salle_2/mascotte/mascotte_face.svg'); ?>"
                 alt="Mascotte">
        </div>

        <div id="mascotte-bulle">
            <div id="bulle-texte"></div>
            <div id="bulle-actions"></div>
            <div class="bulle-fleche"></div>
        </div>
    <?php endif; ?>
    <?php
    // Préparation des données pour JS
    $indices_for_js = is_array($mascotte_i) ? $mascotte_i : [$mascotte_i];
    $libelles_js = array_map(fn($item) => $item->libelle, $indices_for_js);
    ?>

    <script>
        const INDICES = <?= json_encode($libelles_js, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    </script>

</div>

<div class="scroll-flow">
    <div class="scroll-spacer"></div>
    <footer>
        <?= $this->include('commun\footer') ?>
    </footer>
</div>

<script src="<?= base_url('/js/salle_2/mascotte.js') ?>" defer></script>
<script src="<?= base_url('/js/salle_2/telephone.js') ?>" defer></script>

</body>
</html>