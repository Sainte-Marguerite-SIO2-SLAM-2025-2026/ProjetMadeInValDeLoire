document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll(".selection-buttons button");
    const tables = document.querySelectorAll(".table-section");

    function showTable(index) {
        tables.forEach(t => t.style.display = "none");
        tables[index].style.display = "block";
        buttons.forEach(b => b.classList.remove("active"));
        buttons[index].classList.add("active");
    }

    buttons.forEach((btn, index) => {
        btn.addEventListener("click", () => showTable(index));
    });

    // Ouvrir la section depuis le hash
    const hash = window.location.hash.substring(1);
    if (hash) {
        if (hash === 'enigmes') showTable(0);
        else if (hash === 'objet') showTable(1);
        else if (hash === 'objets_declencheurs') showTable(2);
    }

    const alert = document.querySelector('.alert-success');
    if (alert) {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-5px)';
            setTimeout(() => alert.remove(), 300);
        }, 2500);
    }


    if (!hash) {
        showTable(0); // Enigmes par défaut
    }

});
