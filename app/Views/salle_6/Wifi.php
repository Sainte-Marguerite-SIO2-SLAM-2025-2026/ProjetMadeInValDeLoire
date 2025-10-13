    <title>Wifi</title>
    <?= link_tag(base_url()."styles/salle6/Wifi.css") ?>
</head>
<body>
    <div class="container">
        <h1 class="titre-temp">Wifi</h1>
        <?= anchor(base_url() . '/Salle6', img([
                    'src'   => 'images/commun/retour.png',
                    'alt'   => 'FlecheRetour',
                    'class' => 'retour'
            ]));?>
    </div>
</body>
</html>
