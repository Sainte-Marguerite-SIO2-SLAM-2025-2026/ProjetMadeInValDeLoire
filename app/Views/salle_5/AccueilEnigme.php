<?= link_tag("styles/salle_5/accueil.css")?>
<title>Accueil eniggme</title>
</head>
<body>
<div class="fond-image">
<?php foreach ($objet as $objets){
    echo img(["src" => $objets->image]);
}?>
</div>
    <!-- Bouton retour -->
    <div class="retour">
        <?= anchor(base_url('/enigmeRetour'), '<button>' . img([
                "src" => $salle->bouton,
                "alt" => "bouton de retour",
                "class" => "retour-img",
                "style" => "width:50px;height:50px;"
            ]) . '</button>'); ?>    </div>

    <div class="mascotte">
        <?= img(["src" => $mascotte->image, "class" => "mascotte-img", "alt" => "Mascotte"]) ?>
    </div>


<div id="transition-overlay"></div>

