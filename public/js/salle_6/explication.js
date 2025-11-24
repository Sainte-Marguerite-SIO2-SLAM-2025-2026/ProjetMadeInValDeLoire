/**
 * Script pour la page d'explication/félicitations de la Salle 6
 * Gère les animations et effets visuels
 */

document.addEventListener('DOMContentLoaded', function() {
    // Éléments du DOM
    const btnValider = document.querySelector('.btn-valider-link');
    const mascotte = document.getElementById('mascotte-explication');
    const titre = document.querySelector('.titre-felicitation');

    // Créer un effet de confettis
    function createConfetti() {
        const colors = ['#f39c12', '#e74c3c', '#3498db', '#2ecc71', '#9b59b6', '#f1c40f'];
        const confettiCount = 50;

        for (let i = 0; i < confettiCount; i++) {
            setTimeout(() => {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.animationDuration = (Math.random() * 2 + 2) + 's';
                confetti.style.animationDelay = Math.random() * 0.5 + 's';

                document.body.appendChild(confetti);

                // Supprimer après l'animation
                setTimeout(() => {
                    confetti.remove();
                }, 3000);
            }, i * 50);
        }
    }

    // Lancer les confettis au chargement
    setTimeout(createConfetti, 500);

    // Animation du bouton au survol
    if (btnValider) {
        btnValider.addEventListener('mouseenter', function() {
            const path = this.querySelector('.btn-valider-path');
            if (path) {
                path.style.fill = 'rgba(46, 204, 113, 0.5)';
            }
        });

        btnValider.addEventListener('mouseleave', function() {
            const path = this.querySelector('.btn-valider-path');
            if (path) {
                path.style.fill = 'rgba(46, 204, 113, 0.2)';
            }
        });

        // Effet de clic
        btnValider.addEventListener('click', function(e) {
            const path = this.querySelector('.btn-valider-path');
            if (path) {
                path.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    path.style.transform = 'scale(1)';
                }, 100);
            }
        });
    }

    // Animation de la mascotte au clic
    if (mascotte) {
        mascotte.style.cursor = 'pointer';
        mascotte.addEventListener('click', function() {
            this.style.animation = 'none';
            setTimeout(() => {
                this.style.animation = 'floatMascotte 3s ease-in-out infinite';
            }, 10);

            // Créer quelques confettis supplémentaires
            createConfetti();
        });
    }

    // Effet de pulsation sur le titre
    if (titre) {
        setInterval(() => {
            titre.style.transform = 'scale(1.05)';
            setTimeout(() => {
                titre.style.transform = 'scale(1)';
            }, 200);
        }, 3000);
    }

    // Ajuster le viewBox du SVG pour le responsive
    function adjustSVGViewBox() {
        const svg = document.getElementById('explication-svg');
        if (!svg) return;

        const width = window.innerWidth;

        if (width < 768) {
            svg.setAttribute('viewBox', '0 0 768 1024');
        } else if (width < 1200) {
            svg.setAttribute('viewBox', '0 0 1200 900');
        } else {
            svg.setAttribute('viewBox', '0 0 1920 1080');
        }
    }

    adjustSVGViewBox();
    window.addEventListener('resize', adjustSVGViewBox);

    // Effet sonore (optionnel - nécessite un fichier audio)
    function playSuccessSound() {
        // Si vous avez un fichier audio de succès
        const audio = new Audio('/sounds/success.mp3');
        audio.volume = 0.3;
        audio.play().catch(err => {
            console.log('Lecture audio impossible:', err);
        });
    }

    // Décommenter si vous voulez ajouter un son
    // setTimeout(playSuccessSound, 500);

    // Fonction pour créer des étoiles scintillantes
    function createStars() {
        const starCount = 20;
        for (let i = 0; i < starCount; i++) {
            const star = document.createElement('div');
            star.innerHTML = '⭐';
            star.style.position = 'fixed';
            star.style.left = Math.random() * 100 + 'vw';
            star.style.top = Math.random() * 100 + 'vh';
            star.style.fontSize = (Math.random() * 20 + 10) + 'px';
            star.style.animation = `twinkle ${Math.random() * 2 + 1}s ease-in-out infinite`;
            star.style.pointerEvents = 'none';
            star.style.zIndex = '1';

            document.body.appendChild(star);

            setTimeout(() => {
                star.remove();
            }, 5000);
        }
    }

    // Ajouter l'animation twinkle au CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes twinkle {
            0%, 100% { opacity: 0; transform: scale(0.5); }
            50% { opacity: 1; transform: scale(1); }
        }
    `;
    document.head.appendChild(style);

    // Lancer les étoiles après les confettis
    setTimeout(createStars, 2000);

    // Message dans la console
    console.log('🎉 Félicitations ! Script d\'explication initialisé avec succès ! 🎉');

    // Easter egg : triple-clic sur le titre pour plus de confettis
    let clickCount = 0;
    let clickTimer = null;

    if (titre) {
        titre.addEventListener('click', function() {
            clickCount++;

            if (clickTimer) {
                clearTimeout(clickTimer);
            }

            clickTimer = setTimeout(() => {
                if (clickCount >= 3) {
                    createConfetti();
                    createConfetti();
                    createStars();
                    console.log('🎊 Easter egg activé ! 🎊');
                }
                clickCount = 0;
            }, 500);
        });
    }
});

