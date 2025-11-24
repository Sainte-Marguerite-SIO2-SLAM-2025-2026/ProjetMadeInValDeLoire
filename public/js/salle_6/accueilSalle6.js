// Gestion de la modal
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modal-mascotte');
    const openModal = document.getElementById('open-modal');
    const boutonCommencer = document.getElementById('bouton-commencer');
    const mascotteImg = openModal.querySelector('.mascotte');

    // Changement d'image au survol de la mascotte avec transition
    openModal.addEventListener('mouseenter', function() {
        mascotteImg.classList.add('fade');
        setTimeout(function() {
            mascotteImg.src = mascotteImg.getAttribute('data-hover');
            mascotteImg.classList.remove('fade');
        }, 130); // Correspond au temps de la transition CSS
    });

    openModal.addEventListener('mouseleave', function() {
        mascotteImg.classList.add('fade');
        setTimeout(function() {
            mascotteImg.src = mascotteImg.getAttribute('data-default');
            mascotteImg.classList.remove('fade');
        }, 130); // Correspond au temps de la transition CSS
    });

    // Ouvrir la modal
    openModal.addEventListener('click', function(e) {
        e.preventDefault();
        modal.style.display = 'flex';
    });

    // Fermer la modal avec le bouton
    boutonCommencer.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Fermer la modal en cliquant en dehors
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});