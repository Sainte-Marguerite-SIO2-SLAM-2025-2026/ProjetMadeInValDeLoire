/* Énigme de la salle 3 */
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
    const popup = document.getElementById('popup-explications');
    const data = document.getElementById("data");
    const indices = JSON.parse(data.dataset.indices);
    const mails = JSON.parse(data.dataset.mails);

    let currentEnvelope = null;

    const triEnveloppes = new Map();

    popup.classList.add("show");

    setTimeout(() => {
        popup.style.transition = "opacity 1s ease";
        popup.style.opacity = "0";
        setTimeout(() => {
            popup.style.display = "none";
        }, 10000);
    }, 10000);

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
        mascotte.src = "../images/commun/mascotte/mascotte_exclamee.svg";
    });

    mascotte.addEventListener('mouseleave', () => {
        mascotte.src = "../images/commun/mascotte/mascotte_face.svg";
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
        {zone:3, coords:[1243,279,1318,454]},
        {zone:4, coords:[721,276,996,451]},
        {zone:5, coords:[1349,506,1136,681]},
        {zone:6, coords:[332,745,607,920]},
        {zone:7, coords:[1241,670,1216,845]},
        {zone:8, coords:[399,458,674,633]},
        {zone:9, coords:[730,523,1005,698]},
        {zone:10, coords:[839,691,1114,866]}
    ];
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
            img.src = "../images/salle_3/enveloppes/enveloppe_sepia.webp";
            img.alt = 'Zone ' + a.zone;
            img.style.width = '275px';
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
                document.getElementById("modal-image").src = "../images/salle_3/mails/mail_ouvert.webp";
            });

            el.dataset.zone = a.zone;
        });
    }

    btnLegitime.addEventListener('click', () => {
        if(currentEnvelope){
            currentEnvelope.querySelector('img').src = "../images/salle_3/enveloppes/enveloppe_bleue.webp";
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
            currentEnvelope.querySelector('img').src = "../images/salle_3/enveloppes/enveloppe_jaune.webp";
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
            scoreMascotte.src = "../images/commun/mascotte/mascotte_interrogee.svg";
            btnEchoue.style.display = "block";
        }
        else if (score <= 6) {
            scoreText.innerText = `Votre score : ${score} / ${mails.length}\n\nPas mal ! Tu repères la majorité des arnaques, mais ce n'est pas suffisant..`;
            scoreMascotte.src = "../images/commun/mascotte/mascotte_choquee.svg";
            btnEchoue.style.display = "block";
        }
        else {
            scoreText.innerText = `Votre score : ${score} / ${mails.length}\n\nExcellent ! Tu es un véritable expert anti-phishing !`;
            scoreMascotte.src = "../images/commun/mascotte/mascotte_contente.svg";
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

});