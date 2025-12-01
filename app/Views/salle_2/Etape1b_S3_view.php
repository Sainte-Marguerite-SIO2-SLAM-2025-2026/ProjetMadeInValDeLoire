<?php helper('form'); ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= esc($title ?? 'Code de la Porte | Salle Mot de Passe') ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/Etape1a_Salle3.webp') ?>">
    <link rel="stylesheet" href="<?= base_url('/styles/salle_2/style_etape_S3.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/styles/salle_2/mascotte.css') ?>">

    <style>
        .code-success-overlay {
            position: fixed;
            inset: 0;
            display: grid;
            place-items: center;
            padding: 24px;
            background: rgba(5,5,8,0.55);
            z-index: 10000;
        }
        /* Neutralise le positionnement bas/gauche hérité de .tip-panel */
        .code-success-overlay .tip-panel.code-success-panel {
            position: static;
            top: auto; right: auto; bottom: auto; left: auto;
            transform: none;
            max-width: min(92vw, 560px);
            text-align: center;
        }
    </style>
</head>
<body>

<aside id="intro-tip" class="tip-panel tip-panel--top tip-panel--autohide" role="status" aria-live="polite">
    <p class="tip-desc">
        Étape 1b : Tape un nouveau Code sécurisé pour réinitialiser le Digicode de la porte!
    </p>
</aside>

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

    <div class="accueil-bg" style="background-image:url('<?= base_url('/images/salle_2/Etape1a_Salle3.webp') ?>');"></div>

    <form id="code-form" method="post" action="<?= site_url('Etape1b') ?>" autocomplete="off" novalidate>
        <?= function_exists('csrf_field') ? csrf_field() : '' ?>

        <input type="hidden" name="etage" value="1">

        <div class="label-contour" style="border:none;">
            <label for="mot_de_passe" class="sr-only" id="aide-motdepasse">Entrez 6 chiffres</label>

            <input
                    id="mot_de_passe"
                    name="mot_de_passe"
                    type="text"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    minlength="6"
                    maxlength="6"
                    placeholder="Ecrire un nouveau Code"
                    value=""
                    required
                    aria-describedby="aide-motdepasse code-error"
                    aria-label="Mot de passe"
                    oninput="this.value = this.value.replace(/\D+/g, '').slice(0, 6);"
                    onpaste="setTimeout(() => { this.value = this.value.replace(/\D+/g, '').slice(0, 6); }, 0);"
                    style="all: unset; display: block; width: 100%; height: 100%; box-sizing: border-box; padding: 0.5em; text-align: center; font: inherit; font-size: 2em; font-weight: 600; color: inherit; background: transparent; cursor: text;"
                    <?= !empty($success) ? 'disabled' : '' ?>
            >

            <?php if (!empty($error)): ?>
                <div id="code-error"
                     style="all: unset; display: block; width: 100%; height: 100%; box-sizing: border-box; padding: 0.5em; text-align: center; font: inherit; font-size: 2.5em; font-weight: 600; color: yellow; background: transparent; cursor: text;"
                     aria-live="polite">
                    <?= esc($error) ?>
                </div>
            <?php else: ?>
                <div id="code-error" aria-live="polite" style="display:none;"></div>
            <?php endif; ?>
        </div>

        <div class="valide-contour" style="border:none;">
            <button type="submit" aria-label="Valider" title="Valider"
                    style="all: unset; display: block; width: 100%; height: 100%; cursor: pointer;"
                    <?= !empty($success) ? 'disabled' : '' ?>></button>
        </div>

        <div class="reset-contour" style="border:none;">
            <button type="reset" aria-label="Effacer" title="Effacer"
                    style="all: unset; display: block; width: 100%; height: 100%; cursor: pointer;"
                    <?= !empty($success) ? 'disabled' : '' ?>></button>
        </div>
    </form>

    <input type="checkbox" id="help-toggle" class="sr-only" aria-hidden="true">

    <label for="help-toggle" class="mascotte-backdrop" aria-hidden="true"></label>

    <label for="help-toggle" class="mascotte-btn" aria-label="Besoin d'aide ?" title="Aide">
        <img src="<?= base_url('/images/Lumi_En_Tricycle.jpeg') ?>" alt="" aria-hidden="true" loading="lazy">
    </label>

    <div class="mascotte-popover" role="dialog" aria-labelledby="help-title" aria-modal="false">
        <p id="help-title" class="help-title">Souhaitez-vous de l'aide ?</p>
        <div class="help-actions">
            <button type="button" class="btn btn-primary" id="help-yes">Oui</button>
            <label for="help-toggle" class="btn btn--ghost" role="button" tabindex="0">Non</label>
        </div>
    </div>

    <aside class="tip-panel" role="note" aria-live="polite">
        <p class="tip-desc">
            Information : Entrez un nouveau code pour remplacer l’ancien code du digicode !</p>
    </aside>

    <div id="help-tip" class="tip-panel" style="display:none;">
        <p class="tip-desc-mascotte">
            Indice: Saisissez un code à 6 chiffres. Il doit être 100% sécurisé et respecte certaines règles.
        </p>
        <div class="hero-buttons">
            <button type="button" class="btn" id="help-tip-close">Fermer</button>
        </div>
    </div>

    <?php if (!empty($success)): ?>
        <div class="code-success-overlay" role="dialog" aria-modal="true" aria-labelledby="code-success-titre">
            <aside class="tip-panel code-success-panel" role="note" aria-live="polite">
                <p id="code-success-titre" class="tip-desc" style="margin-bottom:14px;">
                    <?= esc($success_message ?? 'Bravo ! Le code est correct. Le code est maintenant mis en place.') ?>
                </p>
                <a href="<?= esc($next_url ?? site_url('Etape2')) ?>"
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
       <?= $this->include('commun\footer.php') ?>
    </footer>
</div>

<script>
    // JS Mascotte
    (function () {
        const yesBtn = document.getElementById('help-yes');
        const tip = document.getElementById('help-tip');
        const tipClose = document.getElementById('help-tip-close');
        const toggle = document.getElementById('help-toggle');

        if (yesBtn && tip && toggle) {
            yesBtn.addEventListener('click', function () {
                // Ferme le popover
                toggle.checked = false;
                // Affiche l'astuce (avec autohide via animation CSS)
                tip.style.display = 'block';
                tip.classList.add('tip-panel--autohide');

                // Masquer à la fin de l'animation (~30s)
                setTimeout(function () {
                    tip.style.display = 'none';
                    tip.classList.remove('tip-panel--autohide');
                }, 31000);
            });
        }

        if (tipClose && tip) {
            tipClose.addEventListener('click', function () {
                tip.style.display = 'none';
                tip.classList.remove('tip-panel--autohide');
            });
        }
    })();

    // Validation client
    (function () {
        const form = document.getElementById('code-form');
        const input = document.getElementById('mot_de_passe');
        const errorBox = document.getElementById('code-error');
        if (!form || !input || !errorBox) return;
        if (input.disabled) return; // si succès affiché

        function showError(msg) {
            if (!msg) {
                errorBox.textContent = '';
                errorBox.style.display = 'none';
                return;
            }
            errorBox.textContent = msg;
            if (errorBox.style.display === 'none') {
                errorBox.setAttribute('style',
                    'all: unset; display: block; width: 100%; height: 100%; box-sizing: border-box; padding: 0.5em; text-align: center; font: inherit; font-size: 2.5em; font-weight: 600; color: yellow; background: transparent; cursor: text;'
                );
            }
            errorBox.style.display = 'block';
        }

        form.addEventListener('submit', function (e) {
            const v = (input.value || '').replace(/\D+/g, '').slice(0, 6);
            input.value = v;
            showError('');

            if (v.length !== 6) {
                e.preventDefault();
                showError('Le code doit contenir exactement 6 chiffres.');
                input.value = ''; // MODIFICATION JS : Reset input
                return;
            }
            if (v === '111111') {
                e.preventDefault();
                showError("Interdit : vous ne pouvez pas réutiliser l'ancien code.");
                input.value = ''; // MODIFICATION JS : Reset input
                return;
            }
            if ((new Set(v)).size !== 6) {
                e.preventDefault();
                showError('Chaque chiffre doit être différent (pas de doublons).');
                input.value = ''; // MODIFICATION JS : Reset input
                return;
            }
        });

        input.addEventListener('input', () => { if (errorBox.textContent) showError(''); });
    })();
</script>
</body>
</html>