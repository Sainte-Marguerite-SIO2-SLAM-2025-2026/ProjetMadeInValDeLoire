
    <?= link_tag('styles/salle_5/enigme.css') ?>
    <title>La clé USB abandonnée</title>
</head>
<body>
<div class="scene-enigme">
    <h1 class="titre-enigme"><?=$enigme->libelle?></h1>
    <p class="consigne"><?=$mode_emploi->explication_2?></p>

        <?php $cles = [
        '<div class="usb" data-cle="A">
            ' . img(["src" => $usb_finance->image, "alt" => "Clé A"]) . '
        </div>',
        '<div class="usb" data-cle="B">
           
            ' . img(["src" => $usb_ano->image, "alt" => "Clé B"]) . '
        </div>',
        '<div class="usb" data-cle="C">
            ' . img(["src" => $usb_rh->image, "alt" => "Clé C"]) . '
        </div>'
        ];

        shuffle($cles);
        echo '<div class="usb-zone">';
foreach ($cles as $cle) {
    echo $cle;
}
echo '</div>';
?>

    <div class="feedback" id="feedback"></div>

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
</div>

<div id="transition-overlay"></div>

<?= script_tag('js/salle_5/enigme.js') ?>
