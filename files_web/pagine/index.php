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
    <!-- collegamento dei file CSS globali + specifici -->
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/slider.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/darkmode.css">
    <link rel="stylesheet" href="../css/galleria.css">
    <link rel="stylesheet" href="../css/barra-navigazione.css">

    <style>
    .titolo {
        text-align: center;
        font-size: 130%;   /* Aumenta la dimensione del testo, maggiore di un h1 */
        margin-top: 7%;   /* Lascia uno spazio sopra */
    }
    .titolo {
        text-align: center;
        font-size: 130%;
        margin-top: 7%;
    }

    .immagine-banner img {
        width: 18%;
        height: auto;
        display: block;
        margin: 0 auto 0 auto; /* Centra l'immagine e aggiunge margine in basso */
    }
    
    </style>

</head>

<body>
    <?php include '../php_files/header_check.php'; ?>
    <!-- Immagine banner -->
    <div class="immagine-banner">
        <img src="../MEDIA/immagini/Logonohomo.png" alt="Banner decorativo">
    </div>

    <!-- Slider -->
    <div class="image-slider">
        <div class="slider-arrow arrow-left" onclick="cambiaImmagine(-1)">&#8592;</div>
        <img id="mainImage" class="slider-image" src="../MEDIA/immagini/12c39f5c-bf65-4943-866a-5c585d075038.jpeg" alt="Immagine">
        <div class="slider-arrow arrow-right" onclick="cambiaImmagine(1)">&#8594;</div>
    </div>

    <!-- Dots -->
    <div class="dots-container">
        <span class="dot" onclick="cambiaImmagine(0)"></span>
        <span class="dot" onclick="cambiaImmagine(1)"></span>
        <span class="dot" onclick="cambiaImmagine(2)"></span>
    </div>

    <!-- Script -->
    <script>
        const immagini = [
            "../MEDIA/immagini/gow-ragnarok-finalmente-scontato-del-36.jpg",
            "../MEDIA/immagini/lastchanceplay_4432243b.jpg",
            "../MEDIA/immagini/GOWR_Review_Screenshot_13.jpg"
        ];

        let indiceCorrente = 0;

        function cambiaImmagine(direzione) {
            const imgElement = document.getElementById('mainImage');
            imgElement.style.opacity = 0;

            setTimeout(() => {
                indiceCorrente = (indiceCorrente + direzione + immagini.length) % immagini.length;
                imgElement.src = immagini[indiceCorrente];
                imgElement.style.opacity = 1;
                aggiornaPallini();
            }, 300);
        }

        function aggiornaPallini() {
            const dots = document.querySelectorAll('.dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === indiceCorrente);
            });
        }

        aggiornaPallini();
    </script>

    <!-- Titolo categorie -->
    <div class="titolo">
        <h1>CATEGORIE:</h1>
    </div>

    <!-- Galleria -->
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

    <!-- Footer -->
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