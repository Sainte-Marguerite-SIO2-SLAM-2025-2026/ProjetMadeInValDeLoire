<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Post-It | Salle Mot de Passe</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/Etape5_Salle3.png') ?>">
    <link rel="stylesheet" href="<?= base_url('styles/salle_2/style_etape_S3.css') ?>?v=21">
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

    <div class="validate-container-left">
        <button id="btn-collecte" class="btn btn-primary">Valider le classement</button>
        <button id="btn-reset" class="btn btn--ghost" style="margin-left:8px;">Réinitialiser</button>
    </div>

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

    <div id="code-success-overlay" class="code-success-overlay" role="dialog" aria-modal="true" aria-labelledby="code-success-titre" style="display:none">
        <aside class="tip-panel code-success-panel" role="note" aria-live="polite">
            <p id="code-success-titre" class="tip-desc" style="margin-bottom:14px;">
                <?= esc($success_message ?? 'Bravo ! Le classement est correct. Vous avez fini la salle Mot de Passe.') ?>
            </p>
            <a href="<?= esc($next_url ?? site_url('Salle2/Etapeb')) ?>"
               class="tip-btn btn--xl"
               id="go-next"
               aria-label="Passer à la salle suivante">
                Etape Final
            </a>
        </aside>
    </div>

    <div class="mascotte-container">
        <img id="mascotte" src="<?= $mascotte['face'] ?>" alt="Mascotte">
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
</script>


<script src="<?= base_url('js/salle_2/mascotte.js') ?>"></script>

</div> <div class="scroll-flow">
    <div class="scroll-spacer"></div>
</div>


<script>const base_url = "<?= base_url() ?>";</script>
<script src="<?= base_url('/js/salle_2/postits_drag.js') ?>?v=21"></script>
</body>
</html>