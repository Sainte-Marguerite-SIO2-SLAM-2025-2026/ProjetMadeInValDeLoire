<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Salle 1 - Ingénierie sociale</title>

    <?= link_tag('css/salle1.css'); ?>
    <script>
        // On exporte les mots suspects vers le JS
        const motsSuspects = <?= json_encode($suspects ?? []); ?>;
    </script>
    <script src="<?= base_url('public/js/salle1.js') ?>" defer></script>
    <?= script_tag('js/salle1.js'); ?>
</head>
<body>
<div class="background-container">
    <div class="content">
        <?= img([
                'src'   => base_url("public/images/mario.png"),
                'alt'   => "Mario",
                'class' => "perso-img"
        ]); ?>

        <div class="text-zone">
            <?php foreach ($message as $ligne): ?>
                <p>
                    <?php
                    // Découpe chaque mot et l’entoure d’un span cliquable
                    $mots = explode(' ', $ligne);
                    foreach ($mots as $mot) {
                        echo '<span class="mot-cliquable">' . esc($mot) . '</span> ';
                    }
                    ?>
                </p>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="buttons">
        <?= anchor(base_url().'public/', '<button>Retour au menu</button>'); ?>
    </div>
</div>
</body>
</html>