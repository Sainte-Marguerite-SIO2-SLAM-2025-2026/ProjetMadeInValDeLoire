// Configuration des messages et images selon les pages
const mascotteConfig = {
    accueil: {
        messages: [
            "Bienvenue dans la salle de l'ingénierie sociale !",
            "Clique sur le fantôme pour commencer l'aventure !",
            "Fais attention aux pièges de manipulation...",
            "Es-tu prêt à déjouer les tentatives de tromperie ?"
        ],
        imageHover: 'images/commun/mascotte/mascotte_contente.svg'
    },
    discussion: {
        messages: [
            "Analyse bien chaque mot du message !",
            "Cherche les indices de manipulation dans le texte.",
            "Les mots suspects sont là pour t'aider !",
            "La serrure s'ouvrira quand tu auras tout trouvé.",
            "Prends ton temps pour bien lire le message."
        ],
        imageHover: 'images/commun/mascotte/mascotte_contente.svg'
    },
    code: {

        messages: [
            "Tu as trouvé tous les indices ? Parfait !",
            "Entre le code à 4 chiffres que tu as découvert.",
            "Attention au timer, ne perds pas de temps !",
            "Le code est caché dans les mots suspects..."
        ],
        imageHover: 'images/commun/mascotte/mascotte_contente.svg'
    }
};

// Détecter la page actuelle
function getPageType() {
    const path = window.location.pathname.toLowerCase();

    if (path.includes('accueil')) return 'accueil';
    if (path.includes('discussion')) return 'discussion';
    if (path.includes('code')) return 'code';

    return 'accueil';
}

// Initialisation de la mascotte
function initMascotte() {
    const mascotteImage = document.querySelector('.mascotte-image');
    if (!mascotteImage) return;

    const pageType = getPageType();
    const config = mascotteConfig[pageType];

    let baseUrl = '';
    if (typeof BASE_URL !== 'undefined') baseUrl = BASE_URL;

    const imageDefault = mascotteImage.getAttribute('src');
    const imageHover = baseUrl + config.imageHover;

    // Effet au survol
    mascotteImage.addEventListener('mouseenter', function() {
        this.src = imageHover;
        this.style.transform = 'scale(1.1)';
        this.style.transition = 'all 0.3s ease';
    });

    mascotteImage.addEventListener('mouseleave', function() {
        this.src = imageDefault;
        this.style.transform = 'scale(1)';
    });

    // Gestion du clic -> message
    mascotteImage.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        showMascotteMessage(config.messages, baseUrl);
    });

    mascotteImage.style.cursor = 'pointer';
}

// Afficher un message aléatoire dans une popup
function showMascotteMessage(messages, baseUrl) {
    const randomMessage = messages[Math.floor(Math.random() * messages.length)];

    let popup = document.getElementById('popup-mascotte');
    if (!popup) popup = createMascottePopup(baseUrl);

    const messageElement = popup.querySelector('#popup-mascotte-message');
    if (messageElement) messageElement.textContent = randomMessage;

    popup.style.display = 'flex';

    const closeBtn = popup.querySelector('#popup-mascotte-fermer');
    if (closeBtn) {
        closeBtn.onclick = function() {
            popup.style.display = 'none';
        };
    }

    popup.onclick = function(e) {
        if (e.target === popup) {
            popup.style.display = 'none';
        }
    };
}

// Créer la popup si elle n'existe pas
function createMascottePopup(baseUrl) {
    const popup = document.createElement('div');
    popup.id = 'popup-mascotte';
    popup.className = 'popup';

    popup.style.cssText = `
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        justify-content: center;
        align-items: center;
    `;

    popup.innerHTML = `
        <div class="popup-content" style="
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            border-radius: 20px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            animation: slideIn 0.3s ease;
        ">
            <img src="${baseUrl}images/commun/mascotte/mascotte_contente.svg"
                 alt="Mascotte"
                 style="width: 120px; height: 120px; margin-bottom: 20px;">
            <p id="popup-mascotte-message" style="
                color: white;
                font-size: 1.2em;
                margin: 20px 0;
                line-height: 1.6;
            "></p>
            <button id="popup-mascotte-fermer" style="
                background: white;
                color: #667eea;
                border: none;
                padding: 12px 30px;
                border-radius: 25px;
                font-size: 1em;
                font-weight: bold;
                cursor: pointer;
                transition: all 0.3s ease;
            ">OK, compris !</button>
        </div>
    `;

    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        #popup-mascotte-fermer:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
    `;
    style.id = 'mascotte-popup-style';

    if (!document.getElementById('mascotte-popup-style')) {
        document.head.appendChild(style);
    }

    document.body.appendChild(popup);
    return popup;
}

// Initialiser au chargement
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMascotte);
} else {
    initMascotte();
}
