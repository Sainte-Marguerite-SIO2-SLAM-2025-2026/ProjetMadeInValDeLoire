<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= esc($title ?? 'Coffre Fort | Salle Mot de Passe') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/Etape2_Salle3.webp') ?>" type="image/jpeg">
    <link rel="stylesheet" href="<?= base_url('/styles/salle_2/style_etape_S3.css') ?>?v=7">
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

    <aside id="message-intro" class="tip-panel tip-panel--top tip-panel--autohide" role="status" aria-live="polite">
        <p class="tip-desc">
            Étape 2 : Essaie d'ouvrir ce coffre avec un code à 6 chiffres. Attention, sois attentif aux éléments dans la pièce !
        </p>
    </aside>
    <div class="mascotte-container">
        <img id="mascotte" src="<?= base_url('/images/salle_2/mascotte/mascotte_face.svg') ?>" alt="Mascotte">
    </div>

    <div id="mascotte-bulle">
        <div id="bulle-texte"></div>
        <div id="bulle-actions"></div>
        <div class="bulle-fleche"></div>
    </div>

    <?php if (!empty($success)): ?>
        <div class="code-success-overlay" role="dialog" aria-modal="true" aria-labelledby="code-success-titre" style="position: fixed;">
            <aside class="tip-panel code-success-panel" role="note" aria-live="polite">
                <p id="code-success-titre" class="tip-desc" style="margin-bottom:14px;">
                    <?= esc($success_message ?? 'Bravo ! Le code est correct. Le coffre est maintenant déverrouillée.') ?>
                </p>
                <a href="<?= esc($next_url ?? site_url('etape2a')) ?>"
                   class="tip-btn btn--xl"
                   id="go-next"
                   aria-label="Passer à la salle suivante">
                    Passer à la salle suivante
                </a>
            </aside>
        </div>
        <script>
            (function(){ try { document.getElementById('go-next')?.focus(); } catch(e){} })();
        </script>
    <?php endif; ?>



</div> <div class="scroll-flow">
    <div class="scroll-spacer"></div>
    <footer>
        <?= $this->include('commun\footer') ?>
    </footer>
</div>

<script>
    (function() {
        // 1. Détection du rechargement (F5)
        const isReload = performance.getEntriesByType("navigation")[0]?.type === 'reload';

        // 2. Détection de la validation (Si une erreur est affichée, c'est qu'on a validé)
        const errorDiv = document.getElementById('code-error');
        // Si la div d'erreur contient du texte et est visible, c'est une validation échouée
        const isValidation = errorDiv && errorDiv.innerText.trim().length > 0 && errorDiv.style.display !== 'none';

        // Si c'est un F5 OU une tentative de validation, on cache le message
        if (isReload || isValidation) {
            const msg = document.getElementById('message-intro');
            if(msg) msg.style.display = 'none';
        }
    })();
</script>

</body>
</html>