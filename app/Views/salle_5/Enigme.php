<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= link_tag('styles/salle_5/enigme.css') ?>
    <title>La clé USB abandonnée</title>
</head>
<body>
<div class="scene-enigme">
    <h1 class="titre-enigme"><?=$enigme['nom']?></h1>
    <p class="consigne"><?=$enigme['instruction']?></p>

    <div class="usb-zone">
        <div class="usb" data-cle="A">
            <span class="etiquette">Finance</span>
            <?= img(["src" => $enigme['image_cle'], "alt" => "Clé A"]) ?>
        </div>
        <div class="usb" data-cle="B">
            <span class="etiquette">??</span>
            <?= img(["src" => $enigme['image_cle'], "alt" => "Clé B"]) ?>
        </div>
        <div class="usb" data-cle="C">
            <span class="etiquette">Service RH</span>
            <?= img(["src" => $enigme['image_cle'], "alt" => "Clé C"]) ?>
        </div>
    </div>

    <div class="feedback" id="feedback"></div>

    <div class="retour">
        <?= anchor(base_url('salle5'), '<button>Retour</button>'); ?>
    </div>

    <div class="mascotte">
        <?= img(["src" => $mascotte['image'], "class" => "mascotte-img", "alt" => "Mascotte"]) ?>
    </div>
</div>

<div id="transition-overlay"></div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const feedback = document.getElementById("feedback");
        const usbKeys = document.querySelectorAll(".usb");

        usbKeys.forEach(key => {
            key.addEventListener("click", () => {
                const cle = key.dataset.cle;
                if (cle === "B") {
                    feedback.innerHTML = "<strong>Bonne réponse !</strong> Cette clé peut contenir un malware (attaque BadUSB).";
                    feedback.classList.add("success");
                } else {
                    feedback.innerHTML = "Mauvaise réponse. Cette clé appartient à l’entreprise.";
                    feedback.classList.remove("success");
                }
            });
        });
    });
</script>
</body>
</html>
