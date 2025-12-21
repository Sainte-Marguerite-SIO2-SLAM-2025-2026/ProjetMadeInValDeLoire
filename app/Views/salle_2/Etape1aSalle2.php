<?php helper('form'); ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= esc($title ?? 'Code de la Porte | Salle Mot de Passe') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/Etape1a_Salle3.webp') ?>">
    <!-- Styles principaux de l'étape -->
    <link rel="stylesheet" href="<?= base_url('/styles/salle_2/Salle2Etapes.css') ?>">

    <?php if (!empty($success)): ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="<?= base_url('styles/salle_2/Salle2Fin.css') ?>">
    <?php endif; ?>
</head>
<body>

<?php if (session()->get('mode') === 'jour'): ?>
    <!-- Bouton d’accueil : renvoie vers le manoir de jour si le mode = "jour" -->
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
    <!-- Bouton d’accueil -->
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

    <!-- Arrière-plan principal de l’étape  -->
    <div class="accueil-bg" style="background-image:url('<?= base_url('/images/salle_2/Etape1a_Salle3.webp') ?>');"></div>

    <!-- Formulaire de saisie du code avec protection CSRF et validation côté client -->
    <form id="code-form" method="post" action="<?= base_url('/Salle2/Etape1a') ?>" autocomplete="off" novalidate>
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
                    placeholder="Ecrire un Code"
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



    <?php if (empty($success)): ?>
        <!-- Panneau d’aide introductif  -->
        <aside id="intro-tip" class="tip-panel tip-panel--top tip-panel--autohide" role="status" aria-live="polite">
            <p class="tip-desc">
                <?= $libelles->libelle ?>
            </p>
        </aside>

        <!-- Affichage de la mascotte  -->
        <div class="mascotte-container">
            <img id="mascotte"
                 src="<?= base_url('images/salle_2/mascotte/mascotte_face.svg'); ?>"
                 alt="Mascotte">
        </div>

        <!-- Bulle d’aide associée à la mascotte -->
        <div id="mascotte-bulle">
            <div id="bulle-texte"></div>
            <div id="bulle-actions"></div>
            <div class="bulle-fleche"></div>
        </div>

        <!-- Lien de navigation retour vers l’étape 1 -->
        <div class="btn-retour-code">
            <!-- le lien va directement à Etape1, plus besoin de popup -->
            <a href="<?= base_url('/Salle2/Etape1') ?>" class="btn btn--xl btn-nuit">
                Retour
            </a>
        </div>

    <?php
    // Préparation des indices pour le JS : extraction des libellés et encodage des caractères spéciaux
    $indices_for_js = is_array($mascotte_i) ? $mascotte_i : [$mascotte_i];
    $libelles_js = array_map(fn($item) => $item->libelle, $indices_for_js);
    ?>

        <!-- Injection côté client des indices  -->
        <script>
            const INDICES = <?= json_encode($libelles_js, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
        </script>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <!-- Écran final en overlay : feedback de réussite et action suivante -->
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

                    <!-- Bouton pour passer à la salle suivante -->
                    <div class="final-actions">
                        <a href="<?= esc($next_url ?? base_url('/Salle2/Etape2')) ?>" class="btn btn--xl btn-nuit trigger-popup" data-mode="Nuit">
                            Passer a la salle Suivante
                        </a>
                    </div>
                </div>
            </main>
        </div>
    <?php endif; ?>

</div>

<!-- Éléments de flux/scroll pour gestion de mise en page -->
<div class="scroll-flow">
    <div class="scroll-spacer"></div>
</div>

<?php if (empty($success)): ?>
    <!-- Script d’aide/mascotte chargé uniquement si succès non atteint -->
    <script src="<?= base_url('/js/salle_2/Salle2Mascotte.js') ?>" defer></script>
<?php endif; ?>

</body>
</html>