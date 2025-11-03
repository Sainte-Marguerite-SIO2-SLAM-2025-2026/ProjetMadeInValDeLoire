<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manoir Hanté | Salle N°3</title>

    <!-- Chargement des polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Police  -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">

    <link rel="preload" as="image" href="<?= base_url('assets/images/accueil_salle3.jpeg') ?>">

    <link rel="stylesheet" href="<?= base_url('assets/css/style_accueil_S3.css') ?>">
</head>
<body>
<!-- Fond d'accueil -->
<div class="accueil-bg" style="background-image:url('<?= base_url('assets/images/accueil_salle3.jpeg') ?>');"></div>

<!-- Titre centré en haut -->
<header class="site-header">
    <h1 class="site-title">Bureau Du Détective</h1>
</header>

<main class="hero hero--lower">
    <aside class="hero-panel">
        <p class="hero-desc">
            Bienvenue dans la salle n°3…
            Ici, les mots ont un pouvoir, mais seuls les plus sûrs te permettront d’avancer.

            Sauras-tu trouver les 6 mots de passe cachés parmi ceux que l’ordinateur te propose ?
            Chaque choix compte… et chaque erreur pourrait te faire perdre du temps.

            Le manoir observe. À toi de prouver que tu connais les secrets des mots bien gardés.
        </p>
        <div class="hero-buttons">
            <a class="btn btn--accent btn--xl" href="<?= base_url('introduction') ?>">Commencer</a>
            <a class="btn btn--ghost btn--xl" href="<?= base_url() ?>">Quitter</a>
        </div>
    </aside>
</main>

<!-- JS  -->
<script src="<?= base_url('assets/js/accueil.js') ?>" defer></script>
</body>
</html>