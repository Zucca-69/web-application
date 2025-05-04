<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendita Quadri</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/slider.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/darkmode.css">
    <link rel="stylesheet" href="../css/galleria.css">
    <link rel="stylesheet" href="../css/barra-navigazione.css">
    <style>
        body {
            background-color: #d3f9d8;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            margin: 0 auto;
            max-width: 1200px;
        }

        .galleria-sinistra {
            width: 70%;
            padding-left: 20px;
            padding-top: 20px;
        }

        .immagine-principale img {
            width: 100%;
            height: auto;
            border: 2px solid #ccc;
            margin-bottom: 10px;
        }

        .miniature {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px;
        }

        .miniature img {
            width: 30%;
            cursor: pointer;
            border: 1px solid #999;
            transition: transform 0.3s, border 0.3s;
        }

        .miniature img:hover {
            transform: scale(1.1);
            border: 2px solid #333;
        }

        .galleria-destra {
            width: 40%;
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding-top: 20px;
        }

        .riquadro {
            width: 100%;
            height: 100px;
            background-color: #01cd01;
            border-radius: 15px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 32px;
            color: #333;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-left: 10%;
            cursor: pointer;
        }

        .riquadro:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .barra-richieste {
            display: none;
            margin-top: 10px;
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-left: 20%;
            width: auto;
        }

        .barra-richieste ul {
            list-style: none;
            padding: 10px;
        }

        .barra-richieste ul li {
            margin: 10px 0;
        }

        .barra-richieste ul li a {
            text-decoration: none;
            color: #333;
            font-size: 12px;
            transition: color 0.3s;
        }

        .barra-richieste ul li a:hover {
            color: #01cd01;
        }

        .sezioni-contenitore {
            display: flex;
            flex-direction: column;
            gap: 30px;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .sezione {
            width: 100%;
            background-color: #01cd01;
            border-radius: 15px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .sezione:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .etichetta-sezione {
            font-size: 20px;
            font-weight: bold;
            color: #222;
            margin-bottom: 15px;
        }

        .testo-descrizione {
            font-size: 14px;
            color: #333;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .sezione-img-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .sezione-img-container img {
            width: 16%;
            height: auto;
            border-radius: 8px;
            border: 2px solid #ccc;
            transition: transform 0.3s ease-in-out;
        }

        .sezione-img-container img:hover {
            transform: scale(1.1);
        }

        .sezione-titolo {
            width: 100%;
            height: 150px;
            background-color: #01cd01;
            border-radius: 15px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            color: #333;
            margin-top: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .sezione-titolo h1 {
            margin: 0;
            font-size: 32px;
            color: #333;
        }

        .sezione-titolo:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .logo {
            padding: 10px;
        }

        .top-right-image,
        .top-right-carrello {
            position: absolute;
            top: 10px;
        }

        .top-right-image {
            right: 100px;
        }

        .top-right-carrello {
            right: 20px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
            background-color: #f0f0f0;
            margin: 0;
        }

        nav ul li {
            padding: 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
        }

        nav ul li a:hover {
            color: #01cd01;
        }
    </style>
</head>
<body>
    <div class="logo">
        <a href="index.html">
            <img src="../MEDIA/immagini/Logo.png" width="8%" alt="Logo">
        </a>
    </div>

    <div class="top-right-image">
        <a href="utenti.html">
            <img src="../MEDIA/immagini/manca-immagine-profilo.jpg" alt="Profilo"> 
        </a>
    </div>

    <div class="top-right-carrello">
        <a href="carrello.html">
            <img src="../MEDIA/immagini/carrellooooooo.jpg" alt="Carrello"> 
        </a>
    </div>

    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="news.html">News</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="servizio clienti.html">Servizio clienti</a></li>
            <li><a href="piattaforme.html">Piattaforme</a></li>
            <li><a href="catalogo.html">Catalogo</a></li>
            <li><a href="categorie.html">Categorie</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="galleria-sinistra">
            <div class="immagine-principale">
                <img id="imgGrande" src="../MEDIA/immagini/lastchanceplay_4432243b.jpg" alt="Immagine Grande">
            </div>
            <div class="miniature">
                <img class="mini" src="../MEDIA/immagini/tekken-8-anteprima-06.webp" alt="Miniatura 1">
                <img class="mini" src="../MEDIA/immagini/uncharted-golden-abyss-leap-of-faith-1080p-wallpaper_bbgm.1280.webp" alt="Miniatura 2">
                <img class="mini" src="../MEDIA/immagini/FIFA-12.jpg" alt="Miniatura 3">
            </div>
        </div>

        <div class="galleria-destra">
            <div class="riquadro">Quantità</div>
            <div class="riquadro">Titolo <br> Prezzo</div>
            <div class="riquadro" id="riquadro">
                <span>Sparatutto</span>
            </div>
            <div id="barra-richieste" class="barra-richieste">
                <ul>
                    <li><a href="#">Richiesta 1</a></li>
                    <li><a href="#">Richiesta 2</a></li>
                    <li><a href="#">Richiesta 3</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="sezioni-contenitore">
        <div class="sezione">
            <div class="etichetta-sezione">DESCRIZIONE:</div>
            <p class="testo-descrizione">Questo è un esempio di descrizione del prodot
                to.OOOOOOOO
                OOOOOOOOOOOOOOOO
                OOOOOOOOOOOO
                OOOOOOOOOO
                OOOOOOOOOOOOOOO
                OOOOOOOO
                OOOOOOOOOOOOO
                OOOOOOOOOOOOOOOOOOOOOOOOO
                OOOOOOOOOO
                OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
                OOOOO Può conten
                ere informazioni dettagliate sul videogioco, come trama, modalità di gioco e piattafo
                rme supportate.</p>
        </div>

        <div class="sezione">
            <div class="etichetta-sezione">CORRELATI:</div>
            <div class="sezione-img-container">
                <img src="../MEDIA/immagini/tekken-8-anteprima-06.webp" alt="Immagine 1">
                <img src="../MEDIA/immagini/uncharted-golden-abyss-leap-of-faith-1080p-wallpaper_bbgm.1280.webp" alt="Immagine 2">
                <img src="../MEDIA/immagini/FIFA-12.jpg" alt="Immagine 3">
                <img src="../MEDIA/immagini/tekken-8-anteprima-06.webp" alt="Immagine 4">
                <img src="../MEDIA/immagini/uncharted-golden-abyss-leap-of-faith-1080p-wallpaper_bbgm.1280.webp" alt="Immagine 5">
            </div>
        </div>

        <div class="sezione">
            <div class="etichetta-sezione">CONSIGLIATI:</div>
            <div class="sezione-img-container">
                <img src="../MEDIA/immagini/tekken-8-anteprima-06.webp" alt="Immagine 1">
                <img src="../MEDIA/immagini/uncharted-golden-abyss-leap-of-faith-1080p-wallpaper_bbgm.1280.webp" alt="Immagine 2">
                <img src="../MEDIA/immagini/FIFA-12.jpg" alt="Immagine 3">
                <img src="../MEDIA/immagini/tekken-8-anteprima-06.webp" alt="Immagine 4">
                <img src="../MEDIA/immagini/uncharted-golden-abyss-leap-of-faith-1080p-wallpaper_bbgm.1280.webp" alt="Immagine 5">
            </div>
        </div>
    </div>

    <script>
        // Mostra/nasconde la barra delle richieste
        document.addEventListener("DOMContentLoaded", function () {
            const riquadro = document.getElementById('riquadro');
            const barraRichieste = document.getElementById('barra-richieste');
            riquadro.addEventListener('click', function () {
                barraRichieste.style.display = (barraRichieste.style.display === "block") ? "none" : "block";
            });

            // Galleria click immagini
            const miniature = document.querySelectorAll('.mini');
            const imgGrande = document.getElementById('imgGrande');
            miniature.forEach(mini => {
                mini.addEventListener('click', () => {
                    imgGrande.src = mini.src;
                    imgGrande.alt = mini.alt;
                });
            });
        });
    </script>

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
