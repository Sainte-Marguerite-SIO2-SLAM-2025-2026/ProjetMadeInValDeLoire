    <?= link_tag('styles/salle_5/salle5.css') ?>
    <title>Salle 5</title>
</head>
<body>
<div class="fond-image">

    <h1 class="titre-salle"><?=$salle->libelle?></h1>
    <?= img(["src" => $salle->image, "class" => "salle-img", "alt" => "Salle 5"])?>

    <div id="popup-explication" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <h2>Explication</h2>
            <p><?= $explication->libelle ?></p>
        </div>
    </div>


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