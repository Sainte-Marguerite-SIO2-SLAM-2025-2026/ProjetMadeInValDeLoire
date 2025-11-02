<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salle 1 - Code</title>

    <!-- CSS -->
    <?= link_tag(base_url('styles/salle1Code.css')) ?>

    <!-- JS -->
    <?= script_tag(base_url('js/salle1Code.js')) ?>
</head>
<body>
<div class="background-container">

    <div class="content-container">
        <h1 class="titre">Entrez le code pour ouvrir la porte</h1>

        <div class="code-container">
            <input type="text" id="codeInput" maxlength="4" placeholder="----" />
            <button id="validerCode">Valider</button>
        </div>

        <p id="message"></p>
    </div>

    <!-- Boutons de navigation -->
    <div class="buttons">
        <?= anchor(
            base_url('Salle1/accesMessage'),
            '<div class="retour-wrapper">'
            .img([
                'src' => base_url('salle_1/images/boutons/retour-et-indice_blanc.webp'),
                'alt' => 'Retour',
                'class' => 'button-image'
            ])
            .'<span class="retour-texte">Page précédente</span>'
            .'</div>'
        ); ?>

        <?= anchor(
            base_url('/'),
            '<div class="retour-wrapper">'
            .img([
                'src' => base_url('salle_1/images/boutons/retour-et-indice_blanc.webp'),
                'alt' => 'Menu',
                'class' => 'button-image'
            ])
            .'<span class="retour-texte">Retour au menu</span>'
            .'</div>'
        ); ?>
    </div>

</div>

<!-- POPUP de réussite -->
<div id="popup" class="popup" style="display:none;">
    <div class="popup-content">
        <h2>Bravo ! 🎉</h2>
        <p>Tu as trouvé le bon code !</p>
        <button id="popup-fermer">Fermer</button>
    </div>
</div>

</body>
</html>
