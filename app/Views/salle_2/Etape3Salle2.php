<?php helper('form'); ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= esc($title ?? 'Mallette | Salle Mot de Passe') ?></title>

    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/Etape3_Salle3.webp') ?>" type="image/jpeg">
    <link rel="stylesheet" href="<?= base_url('/styles/salle_2/style_etape_S3.css') ?>?v=4">
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

    <div class="accueil-bg" style="background-image:url('<?= base_url('/images/salle_2/Etape3_Salle3.webp') ?>');"></div>

    <form id="complex-form" method="post" action="<?= esc(current_url()) ?>" autocomplete="off">
        <?= csrf_field() ?>

        <div class="ecran-malette">
            <label for="code" class="sr-only">Entrez le mot de passe de la mallette</label>

            <textarea
                    id="code"
                    name="code"
                    autocomplete="off"
                    autocapitalize="off"
                    spellcheck="false"
                    placeholder="Saisissez le mot de passe"
                    data-default-placeholder="Saisissez le mot de passe"
                    aria-label="Mot de passe de la mallette"
                    aria-invalid="<?= !empty($error) ? 'true' : 'false' ?>"
                    maxlength="64"
                    rows="3"
                <?= !empty($success) ? 'disabled' : '' ?>
            ></textarea>

            <div id="label-message"
                 class="label-message <?= empty($error) ? 'is-hidden' : '' ?>">
                <?= esc($error) ?>
            </div>
        </div>

        <div class="reset-malette" style="border:none;">
            <button type="reset" aria-label="Effacer" title="Effacer"
                    style="all: unset; display: block; width: 100%; height: 100%; cursor: pointer;"
                    <?= !empty($success) ? 'disabled' : '' ?>></button>
        </div>

        <div class="valide-malette" style="border:none;">
            <button type="submit" aria-label="Valider" title="Valider"
                    style="all: unset; display: block; width: 100%; height: 100%; cursor: pointer;"
                    <?= !empty($success) ? 'disabled' : '' ?>></button>
        </div>
    </form>

    <?php if (!empty($success)): ?>
        <!-- Nouveau popup de fin (remplace l'ancien message de succès) -->
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
                        <img src="<?= $mascotte['exclamee'] ?>" alt="Monsieur Fox">
                    </div>

                    <h1 class="final-title" id="final-title">Félicitations !</h1>

                    <p class="final-text">
                        Bravo, détective. Le mot de passe de la mallette est <strong>correct</strong>.
                        <br><br>
                        La voie vers la prochaine étape s’ouvre…
                    </p>

                    <div class="final-actions">
                        <a href="<?= esc($next_url ?? site_url('/Salle2/etape4')) ?>" class="btn btn--xl btn-nuit trigger-popup" data-mode="Nuit">
                            Passer à la salle suivante
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <aside id="message-intro" class="tip-panel tip-panel--top tip-panel--autohide" role="status" aria-live="polite">
        <p class="tip-desc">
            <?= $libelles->libelle ?>
        </p>
    </aside>

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

</div> <div class="scroll-flow">
    <div class="scroll-spacer"></div>
    <footer>
        <?= $this->include('commun\footer') ?>
    </footer>
</div>


<script>
    // Au chargement: champ vide et focus (si pas en succès)
    (function () {
        try {
            if (!<?= json_encode(!empty($success)) ?>) {
                const input = document.getElementById('code');
                input.value = '';
                input.defaultValue = '';
                input.focus();
            }
        } catch (e) {}
    })();

    // Reset: vide le champ, cache le message centré et remet le placeholder par défaut
    document.getElementById('complex-form')?.addEventListener('reset', function () {
        const input = document.getElementById('code');
        const labelMsg = document.getElementById('label-message');
        setTimeout(() => {
            if (input) {
                input.value = '';
                input.defaultValue = '';
                input.setAttribute('placeholder', input.dataset.defaultPlaceholder || 'Saisissez le mot de passe');
                input.setAttribute('aria-invalid', 'false');
                input.focus();
            }
            if (labelMsg) {
                labelMsg.textContent = '';
                labelMsg.classList.add('is-hidden');
            }
        }, 0);
    });
</script>

<?php if (empty($success)): ?>
    <script src="<?= base_url('/js/salle_2/mascotte.js') ?>" defer></script>
<?php endif; ?>

</body>
</html>