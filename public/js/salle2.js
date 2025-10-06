document.addEventListener("DOMContentLoaded", () => {
    const mails = [
        { id: 1, img: "mail_temp.png", type: "phishing", userChoice: null },
        { id: 2, img: "mail_temp.png", type: "legit", userChoice: null },
        { id: 3, img: "mail_temp.png", type: "phishing", userChoice: null },
        { id: 4, img: "mail_temp.png", type: "phishing", userChoice: null },
        { id: 5, img: "mail_temp.png", type: "legit", userChoice: null },
        { id: 6, img: "mail_temp.png", type: "phishing", userChoice: null },
        { id: 7, img: "mail_temp.png", type: "phishing", userChoice: null },
        { id: 8, img: "mail_temp.png", type: "legit", userChoice: null },
        { id: 9, img: "mail_temp.png", type: "phishing", userChoice: null },
        { id: 10, img: "mail_temp.png", type: "phishing", userChoice: null },
    ];

    const container = document.querySelector(".envelopes");
    const modal = document.getElementById("mail-modal");
    const mailImg = document.getElementById("mail-image");
    const closeModal = document.getElementById("close-modal");
    const btnLegit = document.getElementById("btn-legit");
    const btnPhish = document.getElementById("btn-phish");
    const validateBtn = document.getElementById("validate-btn");

    let currentMail = null;

    // Générer les enveloppes
    mails.forEach(mail => {
        const env = document.createElement("div");
        env.classList.add("envelope");
        env.dataset.id = mail.id;
        env.innerHTML = `<img class="env-closed" src="/public/images_temp/enveloppe_temp.jpg" alt="Enveloppe"/>`
        env.addEventListener("click", () => openMail(mail));
        container.appendChild(env);
    });

    function openMail(mail) {
        currentMail = mail;
        mailImg.src = `/public/images_temp/${mail.img}`;
        modal.classList.remove("hidden");
    }

    closeModal.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    btnLegit.addEventListener("click", () => classify("legit"));
    btnPhish.addEventListener("click", () => classify("phishing"));

    function classify(choice) {
        if (!currentMail) return;
        currentMail.userChoice = choice;
        modal.classList.add("hidden");

        const env = document.querySelector(`.envelope[data-id="${currentMail.id}"]`);
        env.classList.remove("legit", "phish");
        env.classList.add(choice === "legit" ? "legit" : "phish");

        // Activer le bouton si tout est choisi
        if (mails.every(m => m.userChoice !== null)) {
            validateBtn.classList.add("active");
            validateBtn.disabled = false;
        }
    }

    validateBtn.addEventListener("click", () => {
        if (!mails.every(m => m.userChoice !== null)) return;

        let correct = 0;
        mails.forEach(m => {
            if (m.type === m.userChoice || (m.type === "smishing" && m.userChoice === "phishing")) {
                correct++;
            }
        });

        const score = `${correct} / ${mails.length}`;
        alert(`Énigme terminée !\nTon score : ${score}`);
    });
});