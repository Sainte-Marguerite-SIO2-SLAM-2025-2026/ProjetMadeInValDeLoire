<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= base_url('public/styles/salle2.css') ?>">
    <script src="public/js/salle2.js"></script>
    <!--<title>Salle 2 - Phishing</title> -->
</head>
<body>

<div id="home-screen" class="screen">

    <img src="<?= base_url('public/images_temp/bg_temporaire.jpg') ?>" id="bg" alt="background">
    <div class="content">
        <h1>Phishing</h1>
        <p class="subtitle">Cliquez sur le PC pour commencer.</p>

        <div class="pc-wrapper" aria-label="Allumer le PC.">
            <img src="<?= base_url('public/images_temp/pc_temp.png') ?>" id="pc" alt="PC">
            <div class="pc-shadow"></div>
        </div>
    </div>
</div>

<!-- <div id="game-screen" class="screen hidden">
    <div class="game-modal">
        <header class="game-header">
            <h2 id="game-title">Triez les messages</h2>
            <button id="close-game" class="close-btn" aria-label="Fermer">X</button>
        </header>

        <main class="game-body">
            <div id="message-container" class="message-card"></div>

            <div class="controls">
                <button id="legit" class="btn btn-yes">Légitime</button>
                <button id="phish" class="btn btn-no">Phishing</button>
            </div>

            <p id="feedback" class="feedback"></p>
        </main>

        <footer class="game-footer">
           <div id="progress">0 </div>
        </footer>
    </div>
</div> -->

    <?= anchor(base_url().'public/', '<button>Retour</button>'); ?>
</body>
</html>


