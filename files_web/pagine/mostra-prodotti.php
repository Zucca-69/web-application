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

        .quantita-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .quantita-text {
            font-size: 18px;
            color: #333;
        }

        .quantita-btn {
            font-size: 24px;
            padding: 10px 20px;
            background-color: white;
            color: #01cd01;
            border: 2px solid #01cd01;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
        }

        .quantita-btn:hover {
            background-color: #01cd01;
            color: white;
            transform: scale(1.1);
        }

        .quantita-btn-container {
            display: flex;
            gap: 20px;
        }

        .titolo-prezzo {
            font-size: 32px;
            text-align: center;
            line-height: 1.3;
        }
    </style>
</head>
<body>
    <?php include '../php_files/header_check.php'; ?>
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
            <div class="riquadro">
                <div class="titolo-prezzo">
                    Titolo <br> Prezzo
                </div>
            </div>
            <div class="riquadro">
                <div class="quantita-container">
                    <div class="quantita-text">Quantità</div>
                    <div class="quantita-btn-container">
                        <button class="quantita-btn" onclick="cambiaQuantita(-1)">−</button>
                        <span id="quantita">1</span>
                        <button class="quantita-btn" onclick="cambiaQuantita(1)">+</button>
                    </div>
                </div>
            </div>
            <div class="riquadro" onclick="aggiungiAlCarrello()">
                <span class="quantita-text">Aggiungi al carrello</span>
            </div>
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

        // Controllo quantità
        function cambiaQuantita(valore) {
            const span = document.getElementById("quantita");
            let quantita = parseInt(span.textContent);
            quantita = Math.max(1, quantita + valore); // evita valori minori di 1
            span.textContent = quantita;
        }

        // Funzione per aggiungere al carrello
        function aggiungiAlCarrello() {
            const quantita = document.getElementById("quantita").textContent;
            const titoloPrezzo = document.querySelector(".titolo-prezzo").textContent.split('\n');
            const titolo = titoloPrezzo[0].trim();
            const prezzo = titoloPrezzo[1].trim();
            
            // Reindirizza alla pagina del carrello con i parametri
            window.location.href = "carrello.php?titolo=" + encodeURIComponent(titolo) + 
                                 "&prezzo=" + encodeURIComponent(prezzo) + 
                                 "&quantita=" + encodeURIComponent(quantita);
        }
    </script>
</body>
</html>