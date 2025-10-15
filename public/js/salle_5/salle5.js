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