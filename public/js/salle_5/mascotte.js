document.addEventListener('DOMContentLoaded', function() {
    const mascotteImg = document.querySelector('.lumi-image.hover');
    const lumiZone = document.querySelector('.lumi-zone');

    if (!mascotteImg || !lumiZone) return;

    const baseUrl = document.body.dataset.baseurl || '';

    const mascotteImages = {
        face: baseUrl + '/images/commun/mascotte/mascotte_face.svg',
        interrogee: baseUrl + '/images/commun/mascotte/mascotte_interrogee.svg',
        exclamee: baseUrl + '/images/commun/mascotte/mascotte_exclamee.svg',
        choquee: baseUrl + '/images/commun/mascotte/mascotte_choquee.svg',
        contente: baseUrl + '/images/commun/mascotte/mascotte_contente.svg',
        saoulee: baseUrl + '/images/commun/mascotte/mascotte_saoulee.svg'
    };

    // Fonction pour changer l'état de la mascotte
    window.changerMascotte = function(etat, duree = 0) {
        if (mascotteImages[etat]) {
            mascotteImg.classList.add('locked');
            mascotteImg.setAttribute('xlink:href', mascotteImages[etat]);

            if (duree > 0) {
                setTimeout(() => {
                    mascotteImg.classList.remove('locked');
                    mascotteImg.setAttribute('xlink:href', mascotteImages.interrogee);
                }, duree);
            }
        }
    };

    // Fonction pour revenir à l'état de base de la mascotte
    window.deverrouillerMascotte = function() {
        mascotteImg.classList.remove('locked');
        mascotteImg.setAttribute('xlink:href', mascotteImages.interrogee);
    };

    // Ajouter un événement pour le clic sur la zone lumi
    lumiZone.addEventListener('click', () => {
        // Au clic, changer l'image en "contente"
        changerMascotte('contente', 8000); // L'image "contente" pendant 2 secondes
    });
});