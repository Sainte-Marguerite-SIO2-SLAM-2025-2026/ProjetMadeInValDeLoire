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

    <div class="accueil-bg" style="background-image:url('<?= base_url('/images/salle_2/Etape1a_Salle3.webp') ?>');"></div>

    <form id="code-form" method="post" action="<?= base_url('/Etape1a') ?>" autocomplete="off" novalidate>
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
                    placeholder="Ecrire un mot de passe"
                    value="<?= esc($mot_de_passe ?? old('mot_de_passe') ?? '') ?>"
                    required
                    aria-describedby="aide-motdepasse"
                    aria-label="Mot de passe"
                    oninput="this.value = this.value.replace(/\D+/g, '').slice(0, 6);"
                    onpaste="setTimeout(() => { this.value = this.value.replace(/\D+/g, '').slice(0, 6); }, 0);"
                    style="all: unset; display: block; width: 100%; height: 100%; box-sizing: border-box; padding: 0.5em; text-align: center; font: inherit; font-size: 2.5em; font-weight: 600; color: inherit; background: transparent; cursor: text;"
            >

            <?php if (!empty($error)): ?>
                <div style="all: unset; display: block; width: 100%; height: 100%; box-sizing: border-box; padding: 0.5em; text-align: center; font: inherit; font-size: 2.5em; font-weight: 600; color: yellow; background: transparent; cursor: text;">
                    <?= esc($error) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="valide-contour" style="border:none;">
            <button type="submit" aria-label="Valider" title="Valider"
                    style="all: unset; display: block; width: 100%; height: 100%; cursor: pointer;"></button>
        </div>

        <div class="reset-contour" style="border:none;">
            <button type="reset" aria-label="Effacer" title="Effacer"
                    style="all: unset; display: block; width: 100%; height: 100%; cursor: pointer;"></button>
        </div>
    </form>

    <aside class="tip-panel" role="note" aria-live="polite">
        <p class="tip-desc">
            Information : Entrez le code du digicode pour ouvrir la porte du manoir !</p>
    </aside>

    <div class="retour-buttons">
        <a class="btn btn--ghost btn--xl btn-retour-code" href="<?= base_url('/Etape1') ?>">Retour</a>
    </div>

    <?php if (!empty($success)): ?>
        <div class="code-success-overlay" role="dialog" aria-modal="true" aria-labelledby="code-success-titre">
            <aside class="tip-panel code-success-panel" role="note" aria-live="polite">
                <p id="code-success-titre" class="tip-desc" style="margin-bottom:14px;">
                    <?= esc($success_message ?? 'Bravo ! Le code est correct. La porte est maintenant déverrouillée.') ?>
                </p>
                <a href="<?= esc($next_url ?? base_url('/Etape1b')) ?>"
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

</div>
</body>
</html>