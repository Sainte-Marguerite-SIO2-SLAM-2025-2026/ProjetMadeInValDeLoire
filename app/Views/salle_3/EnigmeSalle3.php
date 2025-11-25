<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= link_tag('styles/salle_3/salle3_enigme.css') ?>
    <title>Salle 3 - Énigme</title>
</head>
<header>

</header>
<body>

<?php $mode = session()->get("mode") ?>
<div class="background-container">

    <img id="bg-img" src="<?= base_url('images/salle_3/dessus_bureau/dessus_bureau.webp') ?>" alt="Fond" style="width:1920px; height:1080px; display:block;">


    <div class="map-container" style="position:absolute; top:0; left:0; width:100%; height:100%;">
        <!-- Enveloppes générées dynamiquement via JS -->

    </div>

</div>

<?= anchor(base_url(), ' ', ['class' => 'accueil-btn']) ?>


<div class="mascotte-container">
    <?php $img = ['id' => 'mascotte', 'src' => 'images/commun/mascotte/mascotte_face.svg',  'alt' => 'Mascotte'];
    echo img($img);
    ?>

    <div id="mascotte-tooltip" class="tooltip">
        Voici un indice ! <br>
        Pense toujours à vérifier l'adresse d'expéditeur.
    </div>
</div>

<div id="modalOverlay">
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
            <h2>Résultat :</h2>
            <p id="score-text"></p>

            <div id="resultButtons" class="buttons-zone" style="margin-top:20px;">
                <?php if ($mode === "jour") : ?>
                    <?= form_open(base_url('/echouerJour/2')) ?>
                    <?= form_button([
                        'content' => 'Retour à l\'accueil',
                        'type' => 'submit',
                        'class' => 'btn-echoue',
                    ]) ?>
                    <?= form_close() ?>
                    <?= form_open(base_url('/validerJour/2')) ?>
                    <?= form_button([
                        'content' => 'Valider la salle',
                        'type' => 'submit',
                        'class' => 'btn-reussie',
                    ]) ?>
                    <?= form_close() ?>
                <?php else : ?>
                    <?= form_open(base_url('/reset')) ?>
                    <?= form_button([
                        'content' => 'Recommencer le parcours',
                        'type' => 'submit',
                        'class' => 'btn-echoue',
                    ]) ?>
                    <?= form_close() ?>
                    <?= form_open(base_url('/valider/2')) ?>
                    <?= form_button([
                        'content' => 'Valider la salle',
                        'type' => 'submit',
                        'class' => 'btn-reussie',
                    ]) ?>
                    <?= form_close() ?>
                <?php endif; ?>
            </div>
        </div>
        <img id="score-mascotte" src="" alt="Mascotte score" style="width:400px; position:absolute; right:-550px; bottom:250px;">
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
        const overlay = document.getElementById('modalOverlay');
        const btnEchoue = document.querySelector('.btn-echoue');
        const btnReussie = document.querySelector('.btn-reussie');
        const numeroActivite = <?= $idActivite ?>;
        const indices =  <?= json_encode($indices) ?>;

        let currentEnvelope = null;

        const triEnveloppes = new Map();

        closeBtn.addEventListener('click', () => {
            modal.classList.remove('active');
            overlay.classList.remove('active');
            document.querySelector('.background-container').classList.remove('blur-active');
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.remove('active');
                overlay.classList.remove('active');
                document.querySelector('.background-container').classList.remove('blur-active');
            }
        });

        const mascotte = document.getElementById('mascotte');
        const tooltip = document.getElementById('mascotte-tooltip');
        let tooltipTimeout = null;
        let indiceIndex = 0;

        // Image au survol
        mascotte.addEventListener('mouseenter', () => {
            mascotte.src = "<?= base_url('images/commun/mascotte/mascotte_exclamee.svg') ?>";
        });

        mascotte.addEventListener('mouseleave', () => {
            mascotte.src = "<?= base_url('images/commun/mascotte/mascotte_face.svg') ?>";
        });

        // Affichage / masquage du tooltip au clic
        mascotte.addEventListener('click', () => {

            tooltip.innerText = indices[indiceIndex].libelle;
            tooltip.classList.add('active');

            indiceIndex = (indiceIndex + 1) % indices.length;

            if (tooltipTimeout) {
                clearTimeout(tooltipTimeout);
            }

            tooltipTimeout = setTimeout(() => {
                tooltip.classList.remove('active');
            }, 5000);
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
                img.src = "<?= base_url('/images/salle_3/enveloppes/enveloppe_sepia.webp') ?>";
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
                    document.querySelector(".modal-text p").innerHTML = `<strong>Contenu</strong> : <br>` + mail.contenu;
                    modal.classList.add('active');
                    overlay.classList.add('active');
                    document.querySelector('.background-container').classList.add('blur-active');
                    document.getElementById("modal-image").src = "<?= base_url('/images/salle_3/mails/mail_ouvert.webp') ?>";
                });

                el.dataset.zone = a.zone;
            });
        }

        btnLegitime.addEventListener('click', () => {
            if(currentEnvelope){
                currentEnvelope.querySelector('img').src = "<?= base_url('/images/salle_3/enveloppes/enveloppe_bleue.webp')?>";
                triEnveloppes.set(currentEnvelope.dataset.zone, 'legitime');
                modal.classList.remove('active');
                overlay.classList.remove('active');
                document.querySelector('.background-container').classList.remove('blur-active');
                currentEnvelope = null;
                checkAllTries();
            }
        });

        btnFrauduleux.addEventListener('click', () => {
            if(currentEnvelope){
                currentEnvelope.querySelector('img').src = "<?= base_url('/images/salle_3/enveloppes/enveloppe_jaune.webp')?>";
                triEnveloppes.set(currentEnvelope.dataset.zone, 'frauduleux');
                modal.classList.remove('active');
                overlay.classList.remove('active');
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

            btnValider.style.display = 'none';
            mascotte.style.display = 'none'
            triEnveloppes.forEach((choix, zone) => {
                const mail = mails[zone-1]; // correspondance mail
                const userValue = choix === 'frauduleux' ? 1 : 0;
                const correctValue = mail.phishing == 1 ? 1 : 0;
                if(userValue === correctValue) score++;
            });

            // Afficher le score dans la modale
            const scoreText = document.getElementById('score-text');
            const scoreMascotte = document.getElementById('score-mascotte');

            if (score <= 4) {
                scoreText.innerText = `Votre score : ${score} / ${mails.length}\n\nAïe... Beaucoup de mails frauduleux t'ont piégé. Ce n'est pas grave, l'important c'est d'apprendre !`;
                scoreMascotte.src = "<?= base_url('images/commun/mascotte/mascotte_interrogee.svg') ?>";
                btnEchoue.style.display = "block";
            }
            else if (score <= 6) {
                scoreText.innerText = `Votre score : ${score} / ${mails.length}\n\nPas mal ! Tu repères la majorité des arnaques, mais ce n'est pas suffisant..`;
                scoreMascotte.src = "<?= base_url('images/commun/mascotte/mascotte_choquee.svg') ?>";
                btnEchoue.style.display = "block";
            }
            else {
                scoreText.innerText = `Votre score : ${score} / ${mails.length}\n\nExcellent ! Tu es un véritable expert anti-phishing !`;
                scoreMascotte.src = "<?= base_url('images/commun/mascotte/mascotte_contente.svg') ?>";
                btnReussie.style.display = "block";
            }

            // Ouvrir la modale score
            document.getElementById('scoreModal').classList.add('active');
            overlay.classList.add('active');
            document.querySelector('.background-container').classList.add('blur-active');
        });

        if(bg.complete){
            placeEnvelopes();
        } else {
            bg.onload = placeEnvelopes;
        }

        window.addEventListener('resize', placeEnvelopes);
    });

</script>

</body>
</html>
