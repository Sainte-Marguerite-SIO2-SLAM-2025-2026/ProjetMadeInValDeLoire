<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Post-It | Salle Mot de Passe</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">

    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/Etape5_Salle3.png') ?>">
    <link rel="stylesheet" href="<?= base_url('styles/salle_2/style_etape_S3.css') ?>?v=21">

    <link rel="stylesheet" href="<?= base_url('styles/salle_2/style_fin_S3.css') ?>">
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

<div class="game-fixed-wrapper">

    <div class="accueil-bg" style="background-image:url('<?= base_url('/images/salle_2/Etape5_Salle3.png') ?>');"></div>

    <div class="zone-drop zone-drop-valid" id="drop-valid" aria-label="Feuille (valide)">
        <div class="zone-valid" id="zone-feuille"></div>
    </div>
    <div class="zone-drop zone-drop-invalid" id="drop-invalid" aria-label="Poubelle (invalide)">
        <div class="zone-invalid" id="zone-poubelle"></div>
    </div>

    <div class="draggable-postit postit-ep5-11" data-id="p11" data-password="Electroque10@a">
        <img src="<?= base_url('/images/salle_2/post_it/post_it_11_S3.svg') ?>" alt="Soleil">
        <span class="postit-label">Electroque10@a</span>
    </div>
    <div class="draggable-postit postit-ep5-10" data-id="p10" data-password="Soleil2025">
        <img src="<?= base_url('/images/salle_2/post_it/post_it_10_S3.svg') ?>" alt="Soleil2025">
        <span class="postit-label">Soleil2025</span>
    </div>
    <div class="draggable-postit postit-ep5-9" data-id="p9" data-password="@zertye2_3!">
        <img src="<?= base_url('/images/salle_2/post_it/post_it_9_S3.svg') ?>" alt="@zertye2_3!">
        <span class="postit-label">@zertye2_3!</span>
    </div>
    <div class="draggable-postit postit-ep5-8" data-id="p8" data-password="Clued@565!">
        <img src="<?= base_url('/images/salle_2/post_it/post_it_8_S3.svg') ?>" alt="Clued@565!">
        <span class="postit-label">Clued@565!</span>
    </div>
    <div class="draggable-postit postit-ep5-7" data-id="p7" data-password="Root2025_07">
        <img src="<?= base_url('/images/salle_2/post_it/post_it_7_S3.svg') ?>" alt="Root2025_07">
        <span class="postit-label">Root2025_07</span>
    </div>
    <div class="draggable-postit postit-ep5-6" data-id="p6" data-password="AdmIn2025@root">
        <img src="<?= base_url('/images/salle_2/post_it/post_it_6_S3.svg') ?>" alt="AdmIn2025@root">
        <span class="postit-label">AdmIn2025@root</span>
    </div>
    <div class="draggable-postit postit-ep5-5" data-id="p5" data-password="Sunshine#">
        <img src="<?= base_url('/images/salle_2/post_it/post_it_5_S3.svg') ?>" alt="Sunshine#">
        <span class="postit-label">Sunshine#</span>
    </div>
    <div class="draggable-postit postit-ep5-4" data-id="p4" data-password="Qwerty!9">
        <img src="<?= base_url('/images/salle_2/post_it/post_it_4_S3.svg') ?>" alt="Qwerty!9">
        <span class="postit-label">Qwerty!9</span>
    </div>
    <div class="draggable-postit postit-ep5-3" data-id="p3" data-password="V@lise258!">
        <img src="<?= base_url('/images/salle_2/post_it/post_it_3_S3.svg') ?>" alt="V@lise258!">
        <span class="postit-label">V@lise258!</span>
    </div>
    <div class="draggable-postit postit-ep5-2" data-id="p2" data-password="T0t0#">
        <img src="<?= base_url('/images/salle_2/post_it/post_it_2_S3.svg') ?>" alt="T0t0#">
        <span class="postit-label">T0t0#</span>
    </div>
    <div class="draggable-postit postit-ep5-1" data-id="p1" data-password="Secur3P@sse2004!">
        <img src="<?= base_url('/images/salle_2/post_it/post_it_1_S3.svg') ?>" alt="Secur3P@sse2004!">
        <span class="postit-label">Secur3P@sse2004!</span>
    </div>

    <div id="feedback-global" class="feedback-global" aria-live="polite"></div>

    <aside id="message-intro" class="tip-panel tip-panel--top tip-panel--autohide" role="status" aria-live="polite">
        <p class="tip-desc">
            <?= $libelles->libelle ?>
        </p>
    </aside>

    <form action="<?= current_url() ?>" method="post" id="form-jeu-validation">
        <input type="hidden" name="resultat_jeu" id="input-resultat-jeu" value="0">

        <div class="validate-container-left">
            <button type="button" id="btn-collecte" class="btn btn-primary">Valider le classement</button>
            <button type="button" id="btn-reset" class="btn btn--ghost" style="margin-left:8px;">Réinitialiser</button>
        </div>
    </form>

    <div id="result-overlay" class="result-overlay is-hidden" aria-live="polite">
        <div class="result-panel">
            <h2>Classement des Post-it</h2>
            <p class="classement-note" id="note-texte">NOTE: —</p>
            <div class="resume-global" id="resume-global"></div>
            <div class="result-content">
                <div class="bloc">
                    <h3>✅ Valides</h3>
                    <ul id="liste-valides"></ul>
                </div>
                <div class="bloc">
                    <h3>❌ Invalides</h3>
                    <ul id="liste-invalides"></ul>
                </div>
                <div class="bloc">
                    <h3>⚠️ Non classés</h3>
                    <ul id="liste-neutres"></ul>
                </div>
            </div>
            <div class="result-footer">
                <button id="fermer-resultats" class="btn tip-btn">Fermer</button>
            </div>
        </div>
    </div>

    <div id="code-success-overlay" class="final-popup-overlay" role="dialog" aria-modal="true" aria-labelledby="final-title" style="display:none">

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
                    Bravo, détective. Le classement est correct.
                    <br><br>
                    Le manoir vous ouvre désormais ses secrets les plus profonds...
                </p>

                <div class="final-actions">
                    <button type="button"
                            class="btn btn--xl btn-nuit trigger-popup"
                            data-mode="Nuit"
                            onclick="document.getElementById('input-resultat-jeu').value='1'; document.getElementById('form-jeu-validation').submit();">
                        Continuer
                    </button>
                </div>
            </div>
        </main>
    </div>

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

    <?php
    $indices_for_js = is_array($mascotte_i) ? $mascotte_i : [$mascotte_i];
    $libelles_js = array_map(fn($item) => $item->libelle, $indices_for_js);
    ?>

    <script>
        const INDICES = <?= json_encode($libelles_js, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
        const base_url = "<?= base_url() ?>";
    </script>

    <script src="<?= base_url('js/salle_2/mascotte.js') ?>"></script>

</div> <div class="scroll-flow">
    <div class="scroll-spacer"></div>
</div>

<script src="<?= base_url('/js/salle_2/postits_drag.js') ?>?v=21"></script>

</body>
</html>