<title>VPN</title>
<?= link_tag(base_url() . "styles/salle_6/Vpn.css") ?>
</head>
<body>
<div class="container">
    <h1 class="titre-temp">Sélectionnez l'affirmation vraie sur les VPN</h1>

    <!-- Bouton retour -->
    <?= anchor(base_url() . '/', "Projet Made in Val de Loire", [
            'class' => 'retour'
    ]); ?>

    <!-- Zone cliquable -->
    <div class="zone-cliquable" id="zoneCliquable"></div>

    <!-- Formulaire pour envoyer le choix -->
    <?= form_open(base_url() . 'vpn/validerCarte', ['id' => 'formVpn']) ?>
    <?= csrf_field() ?>
    <?= form_input(["type" => "hidden",
            "name" => "vpn_numero",
            "id" => "vpnIdInput",
            "value" => ""]) ?>
    <?= form_input(["type" => "hidden",
            "name" => "activite_numero",
            "value" => "2"]) ?>

    <!-- Conteneur des cartes VPN (caché par défaut) -->
    <div class="cartes-container" id="cartesContainer">
        <div class="cartes-wrapper">
            <?php if (isset($vpns) && !empty($vpns)): ?>
                <?php foreach ($vpns as $vpn): ?>
                    <div class="CarteVpn"
                         data-vpn-numero="<?= esc($vpn['vpn_numero']) ?>"
                         data-est-correct="<?= esc($vpn['bonne_reponse']) ?>">
                        <div class="carte-contenu">
                            <div class="texte-overlay">
                                <p class="vpn-libelle">
                                    <?= esc($vpn['libelle']) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Version statique si pas de données -->
                <div class="CarteVpn" data-vpn-numero="1" data-est-correct="1">
                    <div class="carte-contenu">
                        <div class="texte-overlay">
                            <p class="vpn-libelle">Un VPN chiffre votre connexion internet</p>
                        </div>
                    </div>
                </div>
                <div class="CarteVpn" data-vpn-numero="2" data-est-correct="0">
                    <div class="carte-contenu">
                        <div class="texte-overlay">
                            <p class="vpn-libelle">Un VPN ralentit toujours votre connexion de 80%</p>
                        </div>
                    </div>
                </div>
                <div class="CarteVpn" data-vpn-numero="3" data-est-correct="0">
                    <div class="carte-contenu">
                        <div class="texte-overlay">
                            <p class="vpn-libelle">Les VPN sont illégaux en France</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Div de résultat (cachée par défaut) -->
        <div class="resultat-container" id="resultatContainer" style="display: none;">
            <p id="messageResultat"></p>
        </div>

        <!-- Bouton suivant (caché par défaut) -->
        <?= form_submit("btnSuivant", "Suivant", [
                'id' => 'btnSuivant',
                'class' => 'btn-suivant',
                'style' => 'display: none;',
                "content" => "Suivant"
        ]) ?>
    </div>

    <!-- Bouton valider -->
    <?= form_button([
            "content" => "Valider",
            "id" => "btnValider",
            "class" => "btn-valider",
            "style" => "display: none;"
    ]) ?>

    <?= form_close() ?>
</div>

<!-- Bouton d'accueil (caché par défaut, affiché en cas d'échec) -->
<?= anchor(base_url() . "/", "Revenir à l'accueil", [
        "id" => "btnAccueil",
        "class" => "btn-valider",
        "style" => "display: none;"
]) ?>

<?= script_tag('js/salle_6/Vpn.js') ?>