
// Mostra/nasconde la barra delle richieste
document.addEventListener("DOMContentLoaded", function () {
    const riquadro = document.getElementById('riquadro');
    const barraRichieste = document.getElementById('barra-richieste');
    riquadro.addEventListener('click', function () {
        barraRichieste.style.display = (barraRichieste.style.display === "block") ? "none" : "block";
    });

    // click immagini
    const miniature = document.querySelectorAll('.mini');
    const imgGrande = document.getElementById('imgGrande');
    miniature.forEach(mini => {
        mini.addEventListener('click', () => {
            imgGrande.src = mini.src;
            imgGrande.alt = mini.alt;
        });
    });
});
