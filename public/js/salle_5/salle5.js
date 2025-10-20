document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById("popup-explication");

    setTimeout(() => {
        popup.style.display = "flex";
    }, 1000);

    window.onclick = function (event) {
        if (event.target === popup) {
            popup.style.display = "none";
        }
    };
});

function closePopup() {
    document.getElementById("popup-explication").style.display = "none";
}

document.addEventListener("DOMContentLoaded", function () {
    const mascotte = document.querySelector(".mascotte");
    const overlay = document.getElementById("transition-overlay");

    mascotte.addEventListener("click", function () {
        overlay.style.opacity = "1";
        overlay.style.pointerEvents = "auto";

        const redirectUrl = mascotte.dataset.url;

        setTimeout(() => {
            window.location.href = redirectUrl;
        }, 800);
    });
});

