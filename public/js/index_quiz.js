document.addEventListener("DOMContentLoaded",  ()  =>{

    const gauche = document.querySelector("#porte-gauche .porte-gauche-zone");
    if (gauche) {
        gauche.addEventListener("click", () => {
            window.location.href = `${baseUrl}quiz/choix/gauche`;
        });
    }

    const droite = document.querySelector("#porte-droite .porte-droite-zone");
    if (droite) {
        droite.addEventListener("click", () => {
            window.location.href = `${baseUrl}quiz/choix/droite`;
        });
    }

    const retour = document.querySelector("#retour .retour-zone");
    if (retour) {
        retour.addEventListener("click", () => {
            window.location.href = `${baseUrl}manoirJour` ;
        });
    }

});