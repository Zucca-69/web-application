<?php 
// Avvia la sessione per gestire login/logout
session_start(); 
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RunGame - home</title>
    <!-- Colleghiamo i file CSS esterni per lo stile -->
    <link rel="stylesheet" href="../css/STILE.css">
    <link rel="stylesheet" href="../css/barra-navigazione.css">
    <link rel="stylesheet" href="../css/global.css">
</head>
<?php include '../php_files/header_check.php'; ?>

<body>

    <!-- Contenitore dello slider -->
    <div class="image-slider">
        <!-- Freccia a sinistra -->
        <div class="slider-arrow arrow-left" onclick="cambiaImmagine(-1)">&#8592;</div>
        
        <!-- Immagine principale dello slider -->
        <img id="mainImage" class="slider-image" src="../MEDIA/immagini/12c39f5c-bf65-4943-866a-5c585d075038.jpeg" alt="Immagine">
        
        <!-- Freccia a destra -->
        <div class="slider-arrow arrow-right" onclick="cambiaImmagine(1)">&#8594;</div>
    </div>

    <!-- Contenitore dei pallini di navigazione -->
    <div class="dots-container">
        <span class="dot" onclick="cambiaImmagine(0)"></span> <!-- Pallino 1 -->
        <span class="dot" onclick="cambiaImmagine(1)"></span> <!-- Pallino 2 -->
        <span class="dot" onclick="cambiaImmagine(2)"></span> <!-- Pallino 3 -->
    </div>

    <script>
        // Array di immagini per lo slider
        const immagini = [
          "../MEDIA/immagini/12c39f5c-bf65-4943-866a-5c585d075038.jpeg",
          "../MEDIA/immagini/lastchanceplay_4432243b.jpg",
          "../MEDIA/immagini/GOWR_Review_Screenshot_13.jpg"
        ];

        let indiceCorrente = 0;  // Indice per la posizione dell'immagine corrente

        // Funzione per cambiare immagine quando si clicca sulle frecce
        function cambiaImmagine(direzione) {
            const imgElement = document.getElementById('mainImage');  // Riferimento all'immagine corrente
            const dots = document.querySelectorAll('.dot');  // Riferimento ai pallini

            // Fase di dissolvenza dell'immagine
            imgElement.style.opacity = 0;

            // Dopo la dissolvenza, cambia immagine e riapri l'immagine con dissolvenza
            setTimeout(() => {
                indiceCorrente = (indiceCorrente + direzione + immagini.length) % immagini.length;  // Cambia l'indice dell'immagine
                imgElement.src = immagini[indiceCorrente];  // Imposta la nuova immagine

                // Fase di riapertura (fade-in)
                imgElement.style.opacity = 1;

                // Aggiorna i pallini di navigazione
                aggiornaPallini();
            }, 300); // Tempo della dissolvenza
        }

        // Funzione per aggiornare lo stato dei pallini (attivo o inattivo)
        function aggiornaPallini() {
            const dots = document.querySelectorAll('.dot');  // Ottieni tutti i pallini
            dots.forEach((dot, index) => {
                if (index === indiceCorrente) {  // Se il pallino è quello attivo
                    dot.classList.add('active');  // Aggiungi la classe 'active'
                } else {
                    dot.classList.remove('active');  // Rimuovi la classe 'active' per gli altri
                }
            });
        }

        // Inizializza il pallino attivo al primo caricamento della pagina
        aggiornaPallini();
    </script>

    <!-- Galleria di immagini -->
    <div class="galleria">
        <div class="galleria-item">
            <img src="../MEDIA/immagini/sparatutto2021.jpg.800x400_q70_crop-smart_upscale-True.jpg" alt="Immagine 1">
            <div class="testo">Sparatutto</div>
        </div>
        <div class="galleria-item">
            <img src="../MEDIA/immagini/FIFA-12.jpg" alt="Immagine 2">
            <div class="testo">Sport</div>
        </div>
        <div class="galleria-item">
            <img src="../MEDIA/immagini/uncharted-golden-abyss-leap-of-faith-1080p-wallpaper_bbgm.1280.webp" alt="Immagine 3">
            <div class="testo">Avventura</div>
        </div>
        <div class="galleria-item">
            <img src="../MEDIA/immagini/tekken-8-anteprima-06.webp" alt="Immagine 4">
            <div class="testo">Picchiaduro</div>
        </div>

        <!-- Seconda riga di immagini -->
        <div class="galleria-item">
            <img src="../MEDIA/immagini/12c39f5c-bf65-4943-866a-5c585d075038.jpeg" alt="Immagine 5">
            <div class="testo">Corse</div>
        </div>
        <div class="galleria-item">
            <img src="../MEDIA/immagini/lastchanceplay_4432243b.jpg" alt="Immagine 6">
            <div class="testo">Horror</div>
        </div>
        <div class="galleria-item">
            <img src="../MEDIA/immagini/preview_screenshot2_119802-1750517926.jpg" alt="Immagine 7">
            <div class="testo">RPG</div>
        </div>
        <div class="galleria-item">
            <img src="../MEDIA/immagini/GOWR_Review_Screenshot_13.jpg" alt="Immagine 8">
            <div class="testo">Azione</div>
        </div>
    </div>

    <!-- Footer con informazioni sull'azienda -->
    <footer class="footer">
        <div class="footer-content">
            <h2>Chi Siamo</h2>
            <p>Siamo un team appassionato d'arte che si dedica a portare quadri unici e originali nelle case di tutto il mondo.
            La nostra missione è offrire opere di alta qualità, curate con amore e attenzione, per arricchire ogni spazio
            con bellezza ed emozione.</p>
    
            <p>Contattaci per qualsiasi informazione o curiosità! Siamo sempre felici di aiutarti.</p>
    
            <p>Email: info@tuaazienda.it | Telefono: +39 123 456 789</p>
        </div>
    </footer>

</body>
</html>
