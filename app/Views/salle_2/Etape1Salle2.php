<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Couloir du Bureau | Salle Mot de Passe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/Etape1_Salle3.jpg') ?>">
    <link rel="stylesheet" href="<?= base_url('/styles/salle_2/Salle2Etapes.css') ?>?v=8">

    <?php if (empty($success)): ?>
        <!-- Éléments d’aide visuelle (mascotte et bulle) affichés si l’étape n’est pas réussie -->
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
    <!-- Bouton d’accueil : renvoie vers la racine (mode nuit/valeur par défaut) -->
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

<!-- Panneau d’aide introductif (texte dynamique depuis $libelles->libelle) -->
<aside id="intro-tip" class="tip-panel tip-panel--top tip-panel--autohide" role="status" aria-live="polite">
    <p class="tip-desc">
        <?= $libelles->libelle ?>
    </p>
</aside>

<div class="game-fixed-wrapper">

    <!-- Arrière-plan principal de la scène -->
    <div class="accueil-bg" style="background-image:url('<?= base_url('/images/salle_2/Etape1_Salle3.jpg') ?>');"></div>

    <!-- Zone centrale avec hotspots interactifs -->
    <div class="center-container">
        <label for="poignier-toggle" class="poignier-contour" aria-controls="poignier-overlay" aria-haspopup="dialog"></label>
        <a class="code-contour" href="<?= base_url('/Salle2/Etape1a') ?>"></a>
        <a class="livre-contour" href="<?= base_url('/Salle2/Aide') ?>"></a>
    </div>

    <!-- Bulle d’aide associée à la mascotte  -->
    <div id="mascotte-bulle">
        <div id="bulle-texte"></div>
        <div id="bulle-actions"></div>
        <div class="bulle-fleche"></div>
    </div>

    <?php
    // Préparation des indices pour le JS
    $indices_for_js = is_array($mascotte_i) ? $mascotte_i : [$mascotte_i];
    $libelles_js = array_map(fn($item) => $item->libelle, $indices_for_js);
    ?>

    <!-- Injection côté client des indices  -->
    <script>
        const INDICES = <?= json_encode($libelles_js, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    </script>


    <!-- Overlay d’indication de la poignée  -->
    <!-- Div poignet permet d'indique a l'utilisateur d'aller clique sur le digicode -->
    <input type="checkbox" id="poignier-toggle" class="sr-only" aria-hidden="true" />
    <div id="poignier-overlay" class="poignier-overlay" role="dialog" aria-modal="true" aria-labelledby="poignier-texte">
        <aside class="poignier-panel">
            <p id="poignier-texte" class="tip-desc">
                Bizarre la porte est fermé, je pense je devrais tape le code.
            </p>
            <label for="poignier-toggle" class="tip-btn" aria-label="Fermer ce message et continuer">Continuer</label>
        </aside>
    </div>

    <!-- Scroll footer -->
</div>
<!-- Éléments de flux/scroll pour gestion de mise en page -->
<div class="scroll-flow">
    <div class="scroll-spacer"></div>
</div>
<!-- Script de la mascotte , chargé en différé -->
<script src="<?= base_url('/js/salle_2/Salle2Mascotte.js') ?>" defer></script>

</body>
</html>