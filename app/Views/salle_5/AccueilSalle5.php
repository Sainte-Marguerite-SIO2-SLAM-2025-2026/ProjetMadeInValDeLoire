    <?= link_tag('styles/salle_5/salle5.css') ?>
    <title>Salle 5</title>
</head>
<body>
<div class="fond-image">
    <h1 class="titre-salle"><?=$salle['nom_salle']?></h1>

    <!-- Bouton retour -->
    <div class="retour">
        <?= anchor(base_url('public/'), '<button>Retour</button>'); ?>
    </div>

    <!-- Mascotte -->
    <div class="mascotte">
        <?= img(["src" => $mascotte['image'], "class" => "mascotte-img", "alt" => "Mascotte"]) ?>
    </div>
</div>
<div id="transition-overlay"></div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const mascotte = document.querySelector(".mascotte");
        const overlay = document.getElementById("transition-overlay");

        mascotte.addEventListener("click", function () {
            overlay.style.opacity = "1";
            overlay.style.pointerEvents = "auto";

            setTimeout(() => {
                window.location.href = "<?= base_url('mascotte') ?>";
            }, 800); // durée identique à la transition CSS
        });
    });
</script>