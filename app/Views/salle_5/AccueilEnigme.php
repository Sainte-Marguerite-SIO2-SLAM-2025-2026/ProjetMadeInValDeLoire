<?= link_tag("styles/salle_5/accueil.css") ?>
<title>Accueil énigme</title>
</head>
<body>
<div class="fond-image">
    <div class="objets-decor">
        <?php if (isset($objet) && !empty($objet)): ?>
            <?php
            $index = 1;
            foreach ($objet as $objets):
                $clickable = false;
                $activite_id = null;

                foreach ($activites as $activite) {
                    if ($objets->image === $activite->image && !in_array($activite->numero, $activites_reussies)) {
                        $clickable = true;
                        $activite_id = $activite->numero;
                        break;
                    }
                }

                // Ajout d'une classe unique par index
                $classe_objet = "objet-$index";
                ?>
                <?php if ($clickable): ?>
                <a href="<?= base_url('enigme/' . $activite_id) ?>" class="objet-clickable <?= $classe_objet ?>">
                    <?= img(["src" => base_url($objets->image), "class" => "objet-img objet-actif"]) ?>
                </a>
            <?php else: ?>
                <?= img(["src" => base_url($objets->image), "class" => "objet-img $classe_objet"]) ?>
            <?php endif; ?>
                <?php
                $index++;
            endforeach;
            ?>
        <?php endif; ?>
    </div>
</div>

<!-- Bouton retour -->
<div class="retour">
    <?= anchor(base_url('Salle5'), '<button>' . img([
                    "src" => $salle->bouton,
                    "alt" => "bouton de retour",
                    "class" => "retour-img",
                    "style" => "width:50px;height:50px;"
            ]) . '</button>'); ?>
</div>

<div class="mascotte">
    <?= img(["src" => base_url($mascotte->image), "class" => "mascotte-img", "alt" => "Mascotte"]) ?>
</div>

<div id="transition-overlay"></div>
</body>
</html>
