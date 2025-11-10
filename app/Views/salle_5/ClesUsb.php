<?= link_tag('styles/salle_5/enigme.css') ?>
<title><?= esc($enigme->libelle) ?></title>
</head>
<body>
<div class="scene-enigme">
    <!-- Bouton retour -->
    <div class="retour-top">
        <?= anchor('Salle5',
                form_button([
                        'content' => 'RETOUR',
                        'type' => 'button',
                        'class' => 'btn-retour'
                ])
        ) ?>
    </div>

    <!-- Question -->
    <div class="question-box">
        <h2 class="question-titre">
            <?php if ($mode_emploi): ?>
                <?= esc($mode_emploi->explication_2) ?>
            <?php else: ?>
                Quelle clé ne doit surtout pas être branchée ?
            <?php endif; ?>
        </h2>
    </div>

    <!-- Fond de bureau avec SVG -->
    <div class="bureau-fond">
        <?= img([
                "src" => "images/salle_5/bureau.svg",
                "alt" => "Bureau",
                "class" => "bureau-bg"
        ]) ?>
    </div>

    <!-- Conteneur des clés USB -->
    <div class="usb-container">
        <?php
        $cles = [
                [
                        'id' => 'A',
                        'image' => 'images/salle_5/usb_finance.svg',
                        'label' => 'Finance',
                        'position' => 'left'
                ],
                [
                        'id' => 'B',
                        'image' => 'images/salle_5/usb_anonyme.svg',
                        'label' => '',
                        'position' => 'bottom'
                ],
                [
                        'id' => 'C',
                        'image' => 'images/salle_5/usb_rh.svg',
                        'label' => 'Service RH',
                        'position' => 'right'
                ]
        ];

        shuffle($cles);

        foreach ($cles as $cle):
            ?>
            <div class="usb-item usb-<?= $cle['position'] ?>" data-cle="<?= $cle['id'] ?>">
                <?= img([
                        "src" => $cle['image'],
                        "alt" => "Clé USB " . esc($cle['label']),
                        "class" => "usb-img"
                ]) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Feedback -->
    <div class="feedback" id="feedback"></div>

    <!-- Mascotte -->
    <div class="mascotte">
        <?= img([
                "src" => $mascotte->image,
                "class" => "mascotte-img",
                "alt" => "Mascotte"
        ]) ?>
    </div>
</div>

<div id="transition-overlay"></div>

<script>
    const activite_numero = <?= $enigme->numero ?>;
    const base_url = '<?= base_url() ?>';
</script>
<?= script_tag('js/salle_5/enigme.js') ?>
