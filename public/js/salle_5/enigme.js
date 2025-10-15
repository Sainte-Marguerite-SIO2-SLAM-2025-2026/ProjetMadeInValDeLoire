document.addEventListener("DOMContentLoaded", function () {
    const feedback = document.getElementById("feedback");
    const usbKeys = document.querySelectorAll(".usb");

    usbKeys.forEach(key => {
        key.addEventListener("click", () => {
            const cle = key.dataset.cle;
            if (cle === "B") {
                feedback.innerHTML = "<strong>Bonne réponse !</strong> Cette clé peut contenir un malware (attaque BadUSB).";
                feedback.classList.add("success");
            } else {
                feedback.innerHTML = "Mauvaise réponse. Cette clé appartient à l’entreprise.";
                feedback.classList.remove("success");
            }
        });
    });
});