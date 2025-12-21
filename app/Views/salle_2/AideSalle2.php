<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Introduction | Salle Mot de Passe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('styles/salle_2/Salle2Fin.css') ?>">
</head>
<body>

<!-- Image de fond principale de la page (stylée via .accueil-bg dans le CSS) -->
<img src="<?= base_url('/images/salle_2/accueil_salle3.webp') ?>" alt="Fond" class="accueil-bg">

<!-- Conteneur principal de l'écran d'introduction -->
<main class="final-screen-wrapper">
    <!-- Couche décorative : effets/particules (SVG) animés -->
    <div class="particles-layer">
        <div class="flying-item item-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg></div>
        <div class="flying-item item-2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg></div>
    </div>

    <!-- Fenêtre centrale contenant la mascotte, le titre, le texte et les actions -->
    <div class="final-popup-container">
        <!-- Image de la mascotte : source dynamique via $mascotte['face'] -->
        <div class="mascot-final-wrapper">
            <?= img([
                    'src' => $mascotte['face'],
                    'alt' => 'Mascotte',
                    'class' => 'mascotte-popup'
            ]) ?>        </div>

        <!-- Titre principal de la section -->
        <h1 class="final-title">Explication !</h1>

        <!-- Texte d'introduction injecté dynamiquement via $introduction->libelle -->
        <p class="final-text">
            <?= $introduction->libelle; ?>
            <br><br>
            <!-- Indication d'aide : l'interface suggère de cliquer sur la mascotte -->
            Si vous avez <strong>besoin d'aide</strong> cliquez sur la <strong> mascotte </strong>!

        </p>

        <!-- Zone d'actions : lien de navigation vers la première étape de la salle -->
        <div class="final-actions">
            <!-- Le lien mène directement à /Salle2/Etape1 (label "Retour") -->
            <a href="<?= base_url('/Salle2/Etape1') ?>" class="btn btn--xl btn-nuit">
                Retour
            </a>
        </div>
    </div>
</main>

</body>
</html>