<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Échec Détective !</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('styles/salle_2/style_fin_S3.css') ?>">
</head>
<body>

<img src="<?= base_url('/images/salle_2/accueil_salle3.webp') ?>" alt="Fond" class="accueil-bg">

<main class="final-screen-wrapper">
    <div class="particles-layer">
        <div class="flying-item item-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg></div>
        <div class="flying-item item-2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></div>
    </div>

    <div class="final-popup-container">
        <!-- Mascotte (version choquée) fournie par le backend -->
        <div class="mascot-final-wrapper">
            <?= img([
                    'src' => $mascotte['choquee'],
                    'alt' => 'Mascotte',
                    'class' => 'mascotte-popup'
            ]) ?>
        </div>

        <h1 class="final-title">Vous n'avez pas réussi !</h1>

        <!-- Message d’échec (texte central) -->
        <p class="final-text">
            Malheureusement, détective, vous n'avez pas réussi à compléter les <strong> étapes</strong>.
            <br><br>
            Le manoir garde encore ses secrets pour vous...
        </p>

        <!-- Action de reprise: routes différentes selon le mode (nuit/jour) -->
        <div class="final-actions">
            <?php if (session()->get('mode') === 'nuit'): ?>
                <a href="<?= base_url('reset') ?>" class="btn btn--xl btn-nuit trigger-popup" data-mode="Nuit">
                    Réessayer
                </a>
            <?php else: ?>
                <a href="<?= base_url('echouerJour/2') ?>" class="btn btn--xl btn-nuit trigger-popup" data-mode="Jour">
                    Réessayer
                </a>
            <?php endif; ?>
        </div>

    </div>
</main>

<!-- Variables exposées pour debug/logs éventuels -->
<script>
    const BASE_URL = '<?= base_url(); ?>';
    const MODE = '<?= session()->get('mode') ?? 'nuit'; ?>';
    console.log('Mode détecté:', MODE);
</script>

</body>
</html>