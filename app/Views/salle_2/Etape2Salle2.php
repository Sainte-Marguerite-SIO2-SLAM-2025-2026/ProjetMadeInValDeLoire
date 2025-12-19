<?php helper('form'); ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= esc($title ?? 'Coffre Fort | Salle Mot de Passe') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/Etape2_Salle3.webp') ?>" type="image/jpeg">
    <link rel="stylesheet" href="<?= base_url('/styles/salle_2/style_etape_S3.css') ?>?v=7">
    <?php if (!empty($success)): ?>
        <link rel="stylesheet" href="<?= base_url('styles/salle_2/style_fin_S3.css') ?>">
    <?php endif; ?>
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

    <div class="accueil-bg" style="background-image:url('<?= base_url('/images/salle_2/Etape2_Salle3.webp') ?>');"></div>

    <div class="postit-1">
        <h1><?= esc($libelles[0]['libelle'] ?? '') ?></h1>
    </div>
    <div class="postit-2">
        <h1><?= esc($libelles[1]['libelle'] ?? '') ?></h1>
    </div>
    <div class="postit-3">
        <h1><?= esc($libelles[2]['libelle'] ?? '') ?></h1>
    </div>

    <form id="code-form" method="post" action="<?= esc(current_url()) ?>">
        <?= csrf_field() ?>

        <div class="code-label" style="position: absolute; overflow: visible;">
            <label for="code" class="sr-only">Entrez 6 chiffres</label>
            <input
                    id="code"
                    name="code"
                    type="text"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    minlength="6"
                    maxlength="6"
                    placeholder="Tape le Code"
                    value="<?= !empty($error) ? '' : esc($code ?? '') ?>"
                    required
                    aria-describedby="code-error"
                    aria-label="Mot de passe"
                    oninput="this.value = this.value.replace(/\D+/g, '').slice(0, 6);"
                    onpaste="setTimeout(() => { this.value = this.value.replace(/\D+/g, '').slice(0, 6); }, 0);"
                    style="all: unset; display: block; width: 100%; box-sizing: border-box; padding: 0.5em; text-align: center; font: inherit; font-size: 1em; font-weight: 600; color: inherit; background: transparent; cursor: text;"
                    <?= !empty($success) ? 'disabled' : '' ?>
            >

            <?php if (!empty($error)): ?>
                <div
                        id="code-error"
                        role="alert"
                        aria-live="assertive"
                        style="
                        position: absolute;
                        top: calc(95% + 2px);
                        left: 0;
                        width: 100%;
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
                    "
                >
                    <?= esc($error) ?>
                </div>
            <?php else: ?>
                <div
                        id="code-error"
                        aria-live="polite"
                        style="
                        display: none;
                        position: absolute;
                        top: calc(100% + 8px);
                        left: 0;
                        width: 100%;
                        padding: 0.25em 0;
                        margin: 0;
                        text-align: center;
                        font: inherit;
                        font-size: 1.2em;
                        font-weight: 700;
                        color: #ff3b30;
                        background: transparent;
                        pointer-events: none;
                        z-index: 2;
                    "
                ></div>
            <?php endif; ?>
        </div>

        <div class="reset-code" style="border:none;">
            <button type="reset" aria-label="Effacer" title="Effacer"
                    style="all: unset; display: block; width: 100%; height: 100%; cursor: pointer;"
                    <?= !empty($success) ? 'disabled' : '' ?>></button>
        </div>

        <div class="valide-code" style="border:none;">
            <button type="submit" aria-label="Valider" title="Valider"
                    style="all: unset; display: block; width: 100%; height: 100%; cursor: pointer;"
                    <?= !empty($success) ? 'disabled' : '' ?>></button>
        </div>
    </form>

    <?php /* MODIFICATION ICI : On cache l'indice si succès */ ?>
    <?php if (empty($success)): ?>
        <aside id="message-intro" class="tip-panel tip-panel--top tip-panel--autohide" role="status" aria-live="polite">
            <p class="tip-desc">
                <?php if (!empty($indices) && isset($indices->libelle)): ?>
                    <?= $indices->libelle ?>
                <?php else: ?>
                    Indice non disponible
                <?php endif; ?>
            </p>
        </aside>
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

    <?php
    $indices_for_js = is_array($mascotte_i) ? $mascotte_i : [$mascotte_i];
    $libelles_js = array_map(fn($item) => $item->libelle, $indices_for_js);
    ?>

        <script>
            const INDICES = <?= json_encode($libelles_js, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
        </script>
    <?php endif; ?>



    <?php if (!empty($success)): ?>
        <div class="final-popup-overlay" role="dialog" aria-modal="true" aria-labelledby="final-title">
            <img src="<?= base_url('/images/salle_2/accueil_salle3.webp') ?>" alt="Fond" class="accueil-bg">

            <div class="final-screen-wrapper">
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
                        <a href="<?= esc($next_url ?? base_url('/Salle2/Etape2a')) ?>" class="btn btn--xl btn-nuit trigger-popup" data-mode="Nuit">
                            Continuer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<div class="scroll-flow">
    <div class="scroll-spacer"></div>
    <footer>
        <?= $this->include('commun\footer') ?>
    </footer>
</div>

<script>
    document.getElementById('code-form')?.addEventListener('reset', function () {
        const input = document.getElementById('code');
        const err = document.getElementById('code-error');
        setTimeout(() => {
            if (input) input.value = '';
            if (err) { err.textContent = ''; err.style.display = 'none'; }
            input?.focus();
        }, 0);
    });
</script>

<?php if (empty($success)): ?>
    <script src="<?= base_url('/js/salle_2/mascotte.js') ?>" defer></script>
<?php endif; ?>

</body>
</html>