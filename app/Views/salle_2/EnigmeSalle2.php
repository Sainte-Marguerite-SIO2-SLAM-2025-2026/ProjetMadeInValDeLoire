<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= link_tag('public/styles/salle2_enigme.css') ?>
    <title>Salle 2 - Énigme</title>
</head>
<body>

<div class="background-container">

    <img id="bg-img" src="<?= base_url('public/images/salle_2/dessus_bureau/dessus_bureau.webp') ?>" alt="Fond" style="width:1920px; height:950px; display:block;">

    <div class="map-container" style="position:absolute; top:0; left:0; width:100%; height:100%;">
        <!-- Enveloppes générées dynamiquement via JS -->

    </div>
    <?= anchor(base_url(). '/public', 'Accueil', ['class' => 'accueil-btn']) ?>
</div>

    <div id="envelopeModal" class="modal">

        <div class="modal-content">

            <div class="modal-body">
                <img id="modal-image" src="" alt="Image modale">
                <div class="modal-text">
                    <h2>Expéditeur : </h2>
                    <h3>Objet : </h3>
                    <p>Contenu : </p>
                </div>
            </div>

            <div class="modal-buttons">
                <button id="btn-legitime">Légitime</button>
                <button id="btn-frauduleux">Frauduleux</button>
            </div>

            <span class="close-btn">&times;</span>
        </div>
    </div>

    <div id="scoreModal" class="modal">
        <div class="modal-content score-content">
            <span class="close-btn">&times;</span>
            <h2>Résultat :</h2>
            <p id="score-text"></p>
        </div>
</div>

    <button id="btn-valider" style="display:none; position:fixed; bottom:20px; left:50%; transform:translateX(-50%); padding:10px 20px; font-size:16px; z-index:1000;">Valider</button>
    <script>

        document.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('.map-container');
            const bg = document.getElementById('bg-img');
            const modal = document.getElementById('envelopeModal');
            const closeBtn = document.querySelector('.close-btn');
            const btnLegitime = document.getElementById('btn-legitime');
            const btnFrauduleux = document.getElementById('btn-frauduleux');
            const btnValider = document.getElementById('btn-valider');

            let currentEnvelope = null;

            const triEnveloppes = new Map();

            closeBtn.addEventListener('click', () => {
                modal.classList.remove('active');
                document.querySelector('.background-container').classList.remove('blur-active');
            });

            window.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('active');
                    document.querySelector('.background-container').classList.remove('blur-active');
                }
            });

            const areas = [
                {zone:1, coords:[406.5,157.5,681.5,332.5]},
                {zone:2, coords:[953,144,1228,319]},
                {zone:3, coords:[1243,279,1518,454]},
                {zone:4, coords:[721,276,996,451]},
                {zone:5, coords:[1349,506,1624,681]},
                {zone:6, coords:[332,745,607,920]},
                {zone:7, coords:[1241,670,1516,845]},
                {zone:8, coords:[399,458,674,633]},
                {zone:9, coords:[730,523,1005,698]},
                {zone:10, coords:[839,691,1114,866]}
            ];

            const mails = <?= json_encode($mails); ?>;
            function placeEnvelopes() {
                container.innerHTML = '';

                areas.forEach((a, index) => {
                    const [x1, y1, x2, y2] = a.coords;

                    const mail = mails[index]

                    const el = document.createElement('a');
                    el.href = "#";
                    el.className = 'envelope';

                    el.dataset.mail = JSON.stringify(mail);

                    // Position aléatoire à l'intérieur de la zone
                    const maxTop = 800;
                    const randX = x1 + Math.random() * (x2 - x1);
                    const randY = y1 + Math.random() * Math.min(y2 - y1, maxTop - y1);
                    el.style.position = 'absolute';
                    el.style.left = randX + 'px';
                    el.style.top = randY + 'px';

                    // Rotation aléatoire entre -30° et 30°
                    el.style.transform = `translate(-50%, -50%) rotate(${Math.random()*60-30}deg)`;

                    // Profondeur aléatoire
                    el.style.zIndex = Math.floor(Math.random() * 10 + 1);

                    const img = document.createElement('img');
                    img.src = "<?= base_url('/public/images/salle_2/enveloppes/enveloppe_sepia.webp') ?>";
                    img.alt = 'Zone ' + a.zone;
                    img.style.width = '275px';   // taille fixe ou variable
                    img.style.height = '175px';
                    el.appendChild(img);
                    container.appendChild(el);

                    el.addEventListener('click', e => {
                        e.preventDefault();
                        currentEnvelope = el;

                        const mail = JSON.parse(el.dataset.mail);

                        document.querySelector(".modal-text h2").innerText = "Expéditeur : " + mail.expediteur;
                        document.querySelector(".modal-text h3").innerText = "Objet : " + mail.objet;
                        document.querySelector(".modal-text p").innerText = "Contenu : " + mail.contenu;
                        modal.classList.add('active');
                        document.querySelector('.background-container').classList.add('blur-active');
                        document.getElementById("modal-image").src = "<?= base_url('/public/images/salle_2/mails/mail_ouvert.webp') ?>";
                    });

                    el.dataset.zone = a.zone;
                });
            }

            btnLegitime.addEventListener('click', () => {
                if(currentEnvelope){
                    currentEnvelope.querySelector('img').src = "<?= base_url('/public/images/salle_2/enveloppes/enveloppe_bleue.webp')?>";
                    triEnveloppes.set(currentEnvelope.dataset.zone, 'legitime');
                    modal.classList.remove('active');
                    document.querySelector('.background-container').classList.remove('blur-active');
                    currentEnvelope = null;
                    checkAllTries();
                }
            });

            btnFrauduleux.addEventListener('click', () => {
                if(currentEnvelope){
                    currentEnvelope.querySelector('img').src = "<?= base_url('/public/images/salle_2/enveloppes/enveloppe_jaune.webp')?>";
                    triEnveloppes.set(currentEnvelope.dataset.zone, 'frauduleux');
                    modal.classList.remove('active');
                    document.querySelector('.background-container').classList.remove('blur-active');
                    currentEnvelope = null;
                    checkAllTries();
                }
            });

            function checkAllTries(){
                if(triEnveloppes.size === areas.length){
                    btnValider.style.display = 'block';
                }
            }

            btnValider.addEventListener('click', () => {
                let score = 0;

                triEnveloppes.forEach((choix, zone) => {
                    const mail = mails[zone-1]; // correspondance mail
                    const userValue = choix === 'frauduleux' ? 1 : 0;
                    const correctValue = mail.phishing == 1 ? 1 : 0;
                    if(userValue === correctValue) score++;
                });

                // Afficher le score dans la modale
                document.getElementById('score-text').innerText = `Votre score : ${score} / ${mails.length}`;

                // Ouvrir la modale score
                document.getElementById('scoreModal').classList.add('active');
                document.querySelector('.background-container').classList.add('blur-active');
            });

            const scoreModal = document.getElementById('scoreModal');
            scoreModal.querySelector('.close-btn').addEventListener('click', () => {
                scoreModal.classList.remove('active');
                document.querySelector('.background-container').classList.remove('blur-active');
            });

            if(bg.complete){
                placeEnvelopes();
            } else {
                bg.onload = placeEnvelopes;
            }

            window.addEventListener('resize', placeEnvelopes);
        });

    </script>

</div>
</body>
</html>
