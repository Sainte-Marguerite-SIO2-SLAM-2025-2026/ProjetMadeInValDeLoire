<title>Wifi</title>
<?= link_tag(base_url()."styles/salle_6/Wifi.css") ?>
</head>
<body>
<div class="container">
    <h1 class="titre-temp">Wifi</h1>

    <!-- Bouton retour -->
    <?= anchor(base_url() . '/',"Projet Made in Val de Loire", [
            'class' => 'retour'
    ]);?>

    <!-- Zone cliquable -->
    <div class="zone-cliquable" id="zoneCliquable"></div>
</div>