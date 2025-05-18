
// parte js per fare in modo che l'immagine piccola mostri il dropdown cliccando e non con hover
document.addEventListener("DOMContentLoaded", function () {
    const dropBtn = document.querySelector(".dropbtn");
    const dropdownContent = document.querySelector(".dropdown-content");

    dropBtn.addEventListener("click", function (event) {
        event.stopPropagation(); // evita chiusura immediata se clicchi sul bottone
        dropdownContent.style.display = (dropdownContent.style.display === "block") ? "none" : "block";
    });

    // Chiudi il dropdown se clicchi fuori
    window.addEventListener("click", function () {
        dropdownContent.style.display = "none";
    });
});
