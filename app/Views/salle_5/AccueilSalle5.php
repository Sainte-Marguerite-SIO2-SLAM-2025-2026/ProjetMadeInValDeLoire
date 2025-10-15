    <?= link_tag('styles/salle_5/salle5.css') ?>
    <title>Salle 5</title>
</head>
<body>
<div class="fond-image">
    <h1 class="titre-salle"><?=$salle->libelle?></h1>

    <!-- Bouton retour -->
    <div class="retour">
        <?= anchor(base_url('/'), '<button>' . img([
                        "src" => $salle->bouton,
                        "alt" => "bouton de retour",
                        "class" => "retour-img",
                    "style" => "width:50px;height:50px;"
                ]) . '</button>'); ?>    </div>


    <!-- Mascotte -->
    <div class="mascotte" data-url="<?= base_url('mascotte') ?>">
       <?= img(["src" => $mascotte->image, "class" => "mascotte-img", "alt" => "Mascotte"]) ?>
    </div>
</div>
<div id="transition-overlay"></div>

<?= script_tag('js/salle_5/salle5.js') ?>