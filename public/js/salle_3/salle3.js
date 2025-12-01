/* Accueil de la salle 3 */
document.addEventListener('DOMContentLoaded', () => {
    const table = document.querySelector('.bureau-wrapper');
    const modal = document.getElementById("modal-accueil");
    const closeBtn = document.getElementById("modal-close");
    const mascotte = document.getElementById("mascotte");
    const toolTip = document.getElementById("mascotte-tooltip");
    const commencerBtn = document.getElementById("commencer");

    modal.classList.remove("hidden");

    commencerBtn.addEventListener('click', () => {
        modal.classList.add("hidden");
    })
    closeBtn.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.classList.add("hidden");
        }
    });

    if (table) {
        table.addEventListener('click', () => {
            window.location.href = BASE_URL + "/Salle3/Enigme";
        });
    }

    mascotte.addEventListener('mouseenter', () => {
        mascotte.src = BASE_URL + "/images/commun/mascotte/mascotte_exclamee.svg";
    });

    mascotte.addEventListener('mouseleave', () => {
        mascotte.src = BASE_URL + "/images/commun/mascotte/mascotte_face.svg";
    });
    let toolTipTimeout = null;

    mascotte.addEventListener('click', () => {

        toolTip.classList.add('active');

        if (toolTipTimeout) {
            clearTimeout(toolTipTimeout);
        }

        toolTipTimeout = setTimeout(() => {
            toolTip.classList.remove('active');
        }, 5000);
    });

});
