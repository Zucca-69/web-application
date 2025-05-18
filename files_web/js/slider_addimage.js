// Quando il DOM è completamente caricato
document.addEventListener("DOMContentLoaded", async function () {
    const sliderContainer = document.querySelector(".image-slider"); // Contenitore dello slider
    const dotsContainer = document.querySelector(".dots-container"); // Contenitore dei pallini

    let immagini = []; // Array di oggetti { src: ..., productId: ... }
    let indiceCorrente = 0; // Indice dell'immagine attuale

    try {
        // Richiede le immagini da PHP
        const response = await fetch("../php_files/get_slider_img.php");
        immagini = await response.json();

        if (immagini.length > 0) {
            mostraImmagine();      // Mostra la prima immagine
            creaPallini(immagini.length);  // Crea i pallini
            aggiornaPallini();     // Evidenzia quello attivo
        }
    } catch (error) {
        console.error("Errore nel caricamento delle immagini:", error);
    }

    // Funzione globale chiamata dai pulsanti freccia
    window.cambiaImmagine = function (direzione) {
        if (immagini.length === 0) return;

        // Effetto dissolvenza
        const linkCorrente = document.querySelector(".slider-link a img");
        if (linkCorrente) linkCorrente.style.opacity = 0;

        setTimeout(() => {
            // Aggiorna l’indice
            indiceCorrente = (indiceCorrente + direzione + immagini.length) % immagini.length;

            // Mostra nuova immagine
            mostraImmagine();

            aggiornaPallini();
        }, 300);
    }

    // Funzione per creare i pallini in base al numero di immagini
    function creaPallini(n) {
        dotsContainer.innerHTML = ""; // Pulisce i vecchi pallini
        for (let i = 0; i < n; i++) {
            const dot = document.createElement("span");
            dot.classList.add("dot");

            // Cambia immagine quando si clicca su un pallino
            dot.addEventListener("click", () => {
                indiceCorrente = i;
                mostraImmagine();
                aggiornaPallini();
            });

            dotsContainer.appendChild(dot);
        }
    }

    // Evidenzia il pallino attivo
    function aggiornaPallini() {
        const dots = document.querySelectorAll(".dot");
        dots.forEach((dot, index) => {
            dot.classList.toggle("active", index === indiceCorrente);
        });
    }

    // Mostra l’immagine attuale nello slider, con link al prodotto
    function mostraImmagine() {
        const immagine = immagini[indiceCorrente];

        // Rimuove immagine precedente, se esiste
        const vecchioLink = document.querySelector(".slider-link");
        if (vecchioLink) vecchioLink.remove();

        // Crea nuovo link
        const a = document.createElement("a");
        a.href = `mostra-prodotti.php?productId=${immagine.productId}&piattaforma=${immagine.piattaforma}`;
        a.classList.add("slider-link");

        // Crea immagine dentro al link
        const img = document.createElement("img");
        img.src = immagine.src;
        img.className = "slider-image";
        img.alt = "Immagine prodotto";
        img.style.opacity = 0;

        // Fade-in dopo un breve delay
        setTimeout(() => {
            img.style.opacity = 1;
        }, 10);

        // Inserisce immagine nel DOM
        a.appendChild(img);

        // Inserisce prima della freccia destra
        const frecciaDestra = document.querySelector(".arrow-right");
        sliderContainer.insertBefore(a, frecciaDestra);
    }
});
