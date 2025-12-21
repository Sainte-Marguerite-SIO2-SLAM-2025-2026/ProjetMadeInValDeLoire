<!doctype html>
<html lang="fr">
<?php session()->get('mode') ?>
<!-- Utilisation du mode (jour/nuit) stocké en session pour adapter le comportement de la page -->
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Accueil | Salle Mot de Passe </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
    <link rel="preload" as="image" href="<?= base_url('/images/salle_2/accueil_salle3.webp') ?>">

    <!-- Styles spécifiques à cette page/salle -->
    <link rel="stylesheet" href="<?= base_url('styles/salle_2/Salle2Accueil.css') ?>">
</head>
<body>

<?php if (session()->get('mode') === 'jour'): ?>
    <!-- Bouton d’accueil : redirection vers le manoir de jour si mode = "jour" -->
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
    <!-- Bouton d’accueil : redirection vers la racine (mode nuit ou autre) -->
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

<!-- Image de fond principale (peut être stylée via CSS plutôt que le style inline selon besoins) -->
<img src="<?= base_url('/images/salle_2/accueil_salle3.webp') ?>"
     alt="Fond"
     class="accueil-bg"
     style="width:1920px; height:1080px; display:block;">

<!-- Calque d’overlay pour assombrir/teinter le fond via CSS -->
<div class="bg-overlay"></div>

<header class="site-header">
    <h1 class="site-title"> Salle des Mots de Passe </h1>
</header>

<main class="hero hero--lower">
    <aside class="hero-panel">
        <br class="hero-desc">
        Bienvenue dans la salle des mots de passe…<br></br>

        Sauras-tu trouver les mots de passe dans les différentes étapes ?
        <!-- Appel à l’action : démarrer le parcours (Introduction de la Salle 2) -->
        <div class="hero-buttons">
            <a class="btn btn--accent btn--xl" href="<?= base_url('/Salle2/Introduction') ?>">Commencer</a>
        </div>
    </aside>
</main>

<!-- Script de la page chargé en différé pour ne pas bloquer le rendu -->
<script src="<?= base_url('/js/salle_2/Salle2Accueil.js') ?>" defer></script>
</body>
</html>