document.addEventListener('DOMContentLoaded', function() {
    const mascotteImg = document.querySelector('.mascotte-img');

    if (!mascotteImg) return;

    const baseUrl = document.body.dataset.baseurl || '';

    const mascotteImages = {
        face: baseUrl + '/images/commun/mascotte/mascotte_face.svg',
        interrogee: baseUrl + '/images/commun/mascotte/mascotte_interrogee.svg',
        exclamee: baseUrl + '/images/commun/mascotte/mascotte_exclamee.svg',
        choquee: baseUrl + '/images/commun/mascotte/mascotte_choquee.svg',
        contente: baseUrl + '/images/commun/mascotte/mascotte_contente.svg',
        saoulee: baseUrl + '/images/commun/mascotte/mascotte_saoulee.svg'
    };

    mascotteImg.src = mascotteImages.face;

    mascotteImg.addEventListener('mouseenter', () => {
        if (!mascotteImg.classList.contains('locked')) {
            mascotteImg.src = mascotteImages.interrogee;
        }
    });

    mascotteImg.addEventListener('mouseleave', () => {
        if (!mascotteImg.classList.contains('locked')) {
            mascotteImg.src = mascotteImages.face;
        }
    });

    window.changerMascotte = function(etat, duree = 0) {
        if (mascotteImages[etat]) {
            mascotteImg.classList.add('locked');
            mascotteImg.src = mascotteImages[etat];

            if (duree > 0) {
                setTimeout(() => {
                    mascotteImg.classList.remove('locked');
                    mascotteImg.src = mascotteImages.face;
                }, duree);
            }
        }
    };

    window.deverrouillerMascotte = function() {
        mascotteImg.classList.remove('locked');
        mascotteImg.src = mascotteImages.face;
    };
});