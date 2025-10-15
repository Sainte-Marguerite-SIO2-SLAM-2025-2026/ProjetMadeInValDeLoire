
    <?= link_tag('styles/salle_5/enigme.css') ?>
    <title>La clé USB abandonnée</title>
</head>
<body>
<div class="scene-enigme">
    <h1 class="titre-enigme"><?=$enigme['nom']?></h1>
    <p class="consigne"><?=$enigme['instruction']?></p>

    <div class="usb-zone">
        <?php $cles = [
        '<div class="usb" data-cle="A">
            <span class="etiquette">Finance</span>
            ' . img(["src" => $enigme['image_cle'], "alt" => "Clé A"]) . '
        </div>',
        '<div class="usb" data-cle="B">
            <span class="etiquette">??</span>
            ' . img(["src" => $enigme['image_cle'], "alt" => "Clé B"]) . '
        </div>',
        '<div class="usb" data-cle="C">
            <span class="etiquette">Service RH</span>
            ' . img(["src" => $enigme['image_cle'], "alt" => "Clé C"]) . '
        </div>'
        ];

        shuffle($cles);
        echo '<div class="usb-zone">';
foreach ($cles as $cle) {
    echo $cle;
}
echo '</div>';
?>
    </div>

    <div class="feedback" id="feedback"></div>

    <div class="retour">
        <?= anchor(base_url('Salle5'), '<button>Retour</button>'); ?>
    </div>

    <div class="mascotte">
        <?= img(["src" => $mascotte['image'], "class" => "mascotte-img", "alt" => "Mascotte"]) ?>
    </div>
</div>

<div id="transition-overlay"></div>

<?= script_tag('js/salle_5/enigme.js') ?>
