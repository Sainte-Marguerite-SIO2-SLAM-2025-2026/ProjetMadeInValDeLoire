    <title>Wifi</title>
    <?= link_tag(base_url()."styles/salle6/Wifi.css") ?>
</head>
<body>
    <div class="container">
        <h1 class="titre-temp">Wifi</h1>
        <div class="wifi-container">
            <!-- Carte 1 -->
            <div class="wifi-card">
                <div class="wifi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z"/>
                    </svg>
                </div>
                <h2 class="wifi-name">WiFi-Entreprise</h2>
                <div class="wifi-info">
                    <div class="info-row">
                        <span class="info-label">Type :</span>
                        <span class="badge badge-private">Privé</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Chiffrement :</span>
                        <span class="info-value encryption">WPA3</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nom :</span>
                        <span class="info-value">corp_network</span>
                    </div>
                </div>
            </div>

            <!-- Carte 2 -->
            <div class="wifi-card">
                <div class="wifi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z"/>
                    </svg>
                </div>
                <h2 class="wifi-name">WiFi-Public</h2>
                <div class="wifi-info">
                    <div class="info-row">
                        <span class="info-label">Type :</span>
                        <span class="badge badge-public">Public</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Chiffrement :</span>
                        <span class="info-value encryption">Aucun</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nom :</span>
                        <span class="info-value">free_wifi</span>
                    </div>
                </div>
            </div>

            <!-- Carte 3 -->
            <div class="wifi-card">
                <div class="wifi-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z"/>
                    </svg>
                </div>
                <h2 class="wifi-name">WiFi-Invités</h2>
                <div class="wifi-info">
                    <div class="info-row">
                        <span class="info-label">Type :</span>
                        <span class="badge badge-public">Public</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Chiffrement :</span>
                        <span class="info-value encryption">WPA2</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nom :</span>
                        <span class="info-value">guest_access</span>
                    </div>
                </div>
            </div>
        </div>
        <?= anchor(base_url() . '/Salle6', img([
                    'src'   => 'images/commun/retour.png',
                    'alt'   => 'FlecheRetour',
                    'class' => 'retour'
            ]));?>
    </div>