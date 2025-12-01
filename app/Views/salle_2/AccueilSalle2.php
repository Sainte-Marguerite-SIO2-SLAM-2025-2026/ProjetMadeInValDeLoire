<!doctype html>
<html lang="fr">
<?php session()->get('mode') ?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Accueil | Salle Mot de Passe </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">

    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/accueil_salle3.webp') ?>">

    <link rel="stylesheet" href="<?= base_url('styles/salle_2/style_accueil_S3.css') ?>">
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
<img src="<?= base_url('/images/salle_2/accueil_salle3.webp') ?>"
     alt="Fond"
     class="accueil-bg"
     style="width:1920px; height:1080px; display:block;">

<div class="bg-overlay"></div>

<header class="site-header">
    <h1 class="site-title"> Salle des Mots de Passe </h1>
</header>

<main class="hero hero--lower">
    <aside class="hero-panel">
        <br class="hero-desc">
                Bienvenue dans la salle des mots de passe…<br></br>

            Sauras-tu trouver les mots de passe dans les différentes étapes ?

        </p>
        <div class="hero-buttons">
            <a class="btn btn--accent btn--xl" href="<?= base_url('Salle2-introduction') ?>">Commencer</a>
        </div>
    </aside>
</main>


<script src="<?= base_url('/js/salle_2/accueil.js') ?>" defer></script>
</body>
</html>