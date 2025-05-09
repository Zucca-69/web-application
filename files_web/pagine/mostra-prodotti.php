<?php session_start() ?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RunGame</title>

    <!-- fogli di stile -->
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/slider.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/darkmode.css">
    <link rel="stylesheet" href="../css/categorie.css">
    <link rel="stylesheet" href="../css/barra-navigazione.css">
    <link rel="stylesheet" href="../css/mostra-prodotti.css">

</head>
<body>
    <?php 
        // script php
        include '../php_files/header.php'; 
        include '../php_files/db_connection.php'; 

        $productId = $_GET['productId'];

        // Verifica se l'utente è loggato
        if (isset($_SESSION['userId'])) {
            // Ottieni l'ID del prodotto dalla query string
            $productId = $_GET['productId'];

            // Connessione al database
            include '../php_files/db_connection.php';

            // Prepara la query per inserire l'interazione nel database
            $query = $conn->prepare("INSERT INTO interazioni (FKuserId, FKproductId, FKcartId, tipologia, timestamp) 
                                    VALUES (?, ?, NULL, 'visualizzato', NOW())");

            // Associa i parametri della query
            $query->bind_param("ii", $_SESSION['userId'], $productId);

            // Esegui la query
            $query->execute();
        }

        //info sul gioco
        $query = "SELECT * FROM prodotti WHERE productId = $productId;";
        $rawResult = $conn -> query($query);
        $gameInfo = $rawResult->fetch_assoc();
    
        // immagini del gioco
        $query = "SELECT imageData, imageType FROM immagini WHERE FKproductId = $productId;";
        $rawResult = $conn->query($query);
        
        $immagini = [];
        $result = $rawResult->fetch_all(MYSQLI_ASSOC);
        foreach ($result as $row) {
            $base64 = base64_encode($row['imageData']);
            $immagini[] = "data:" . $row['imageType'] . ";base64," . $base64;
        }

        // cerco le diverse piattaforme del gioco
        $nome = $gameInfo['nome'];
        $query = "SELECT productId, piattaforma FROM prodotti WHERE nome = '" . $conn->real_escape_string($nome) . "';";
        $rawResult = $conn->query($query);
        
        $piattaforme = [];
        
        if ($rawResult && $rawResult->num_rows > 0) {
            while ($row = $rawResult->fetch_assoc()) {
                $piattaforme[] = [
                    'productId' => $row['productId'],
                    'piattaforma' => $row['piattaforma'],
                ];
            }
        } else {
            echo "errore query: " . $conn->error;
        }
        
        // controllo se il gioco fa parte di una saga
        $saga = $conn->real_escape_string($gameInfo['saga']);
        $giochiSaga = [];

        if (!empty($saga)) {
            $query = "SELECT p.productId, i.imageData, i.imageType
                    FROM prodotti p
                    JOIN immagini i ON p.productId = i.FKproductId
                    WHERE p.saga = '$saga' 
                    AND p.productId != '$productId'
                    GROUP BY p.productId;
                ";

            $rawResult = $conn->query($query);

            if ($rawResult && $rawResult->num_rows > 0) {
                while ($row = $rawResult->fetch_assoc()) {
                    $giochiSaga[] = [
                        'productId' => $row['productId'],
                        'src' => "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData'])
                    ];
                }
            } else {
                echo "errore query: " . $conn->error;
            }
        }

        // carco giochi simili per categoria
        $query = "SELECT DISTINCT p.productId, p.nome, i.imageData, i.imageType
                    FROM Prodotti p
                    JOIN Appartenenze a ON p.productId = a.FKproductId
                    JOIN Immagini i ON p.productId = i.FKproductId
                    WHERE a.FKcategoryId IN (
                        SELECT FKcategoryId
                        FROM Appartenenze
                        WHERE FKproductId = ?
                    )
                    AND p.productId != ?
                    AND p.saga != (
                        SELECT saga FROM Prodotti WHERE productId = ?
                    )
                    GROUP BY p.productId
                    ORDER BY RAND()
                    LIMIT 5;
                ";
        
        // Esegui la query
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iii", $productId, $productId, $productId); // 3 volte il productId
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Recupera i risultati
        $giochiConsigliati = [];
        while ($row = $result->fetch_assoc()) {
            // Crea il link dell'immagine base64
            $imageSrc = "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData']);
            $giochiConsigliati[] = [
                'productId' => $row['productId'],
                'src' => "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData'])
                
            ];
        }

        // chiudo la connessione al server una volta finite le query necessarie
        $conn -> close();
    ?>
    
    <div class="container">
        <div class="immagini-gioco">
            <div class="immagine-principale">
                <img id="imgGrande" src="<?php echo $immagini[0]; ?>" alt="Immagine Grande">
            </div>
                
            <div class="miniature">
                <?php for ($i = 0; $i < 3 && isset($immagini[$i]); $i++): ?>
                    <img class="mini" src="<?php echo $immagini[$i]; ?>" alt="Miniatura <?php echo $i + 1; ?>">
                <?php endfor; ?>
            </div>
        </div>

        <div class="informazioni-gioco">
            <!-- titolo e prezo -->
            <div class="riquadro">
                <p> 
                    <?php
                        echo $gameInfo['nome'] . '<br>' . $gameInfo['prezzo'] . '€';
                    ?>
                </p>
            </div>

            <!-- mostra la disponibilità di un prodotto -->
            <div class="riquadro">
                <p>
                    <?php
                        if ($gameInfo['quantitaDisponibile'] == 0 or is_null($gameInfo['quantitaDisponibile'])) {
                            echo 'Prodotto non disponibile';
                        } else if ($gameInfo['quantitaDisponibile'] > 10) {
                            echo 'Disponibilità immediata';
                        } else {
                            echo 'Disponibili solo ' . $gameInfo['quantitaDisponibile'];
                        }
                    ?>
                </p>
            </div>

            <!-- seleziona la piattaforma per il gioco -->
            <div class="riquadro" id="riquadro">
                <span>
                    Piattaforma: <?php echo $gameInfo['piattaforma']; ?>
                </span>
            </div>
                        
            <?php
                echo '<div id="barra-richieste" class="barra-richieste"><ul>';
                    if (count($piattaforme) > 1) {
                        $limite = min(5, count($piattaforme));
                        for ($i = 0; $i < $limite; $i++) {
                            $link = "mostra-prodotti.php?productId=" . $piattaforme[$i]['productId'];
                            $testo = htmlspecialchars($piattaforme[$i]['piattaforma'] ?? '');
                            echo "<li><a href=\"$link\">$testo</a></li>";
                        }
                    } else {
                        echo "<li>Siamo spiacenti: non ci sono altre piattaforme per questo contenuto</li>";
                    }
                echo '</ul></div>';
            ?>

        </div>
    </div>

    <!-- descrizione -->
    <div class="sezioni-contenitore">
        <div class="sezione">
            <div class="etichetta-sezione">DESCRIZIONE:</div>
            <p class="testo-descrizione">
                <?php
                    echo $gameInfo['descrizione'];
                ?>
            </p>
        </div>

        <!-- riquadro con la saga -->
        <?php 
            if ($saga != "NULL" && !empty($giochiSaga)) {
                echo "<div class='sezione'>
                    <div class='etichetta-sezione'>SAGA:</div>
                    <div class='sezione-img-container'>";

                foreach ($giochiSaga as $giocoSaga) {
                    echo "<a href='mostra-prodotti.php?productId=" . $giocoSaga['productId'] . "'>";
                    echo "<img src='" . $giocoSaga['src'] . "' alt='Gioco saga'>";
                    echo "</a>";
                }

                echo "</div></div>";
            }
        ?>

        <!-- riquadro per i correlati -->
        <?php 
            if ($saga != "NULL" && !empty($giochiConsigliati)) {
                echo "<div class='sezione'>
                    <div class='etichetta-sezione'>GIOCHI CORRELATI:</div>
                    <div class='sezione-img-container'>";

                foreach ($giochiConsigliati as $giocoConsigliato) {
                    echo "<a href='mostra-prodotti.php?productId=" . $giocoConsigliato['productId'] . "'>";
                    echo "<img src='" . $giocoConsigliato['src'] . "' alt='Gioco saga'>";
                    echo "</a>";
                }

                echo "</div></div>";
            }
        ?>

        <!-- riquadro per i consigliati -->
        <?php 
            // TODO : aggiungere la query per i consigliati
            if ($saga != "NULL" && !empty($giochiSaga)) {
                echo "<div class='sezione'>
                    <div class='etichetta-sezione'>CONSIGLIATI PER TE:</div>
                    <div class='sezione-img-container'>";

                foreach ($giochiSaga as $giocoSaga) {
                    echo "<a href='mostra-prodotti.php?productId=" . $giocoSaga['productId'] . "'>";
                    echo "<img src='" . $giocoSaga['src'] . "' alt='Gioco saga'>";
                    echo "</a>";
                }

                echo "</div></div>";
            }
        ?>
    </div>

    <script>
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
    </script>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <h2>Chi Siamo</h2>
            <p>
                Siamo un team appassionato d'arte che si dedica a portare quadri unici e originali nelle case di tutto il mondo.
                La nostra missione è offrire opere di alta qualità, curate con amore e attenzione, per arricchire ogni spazio
                con bellezza ed emozione.
            </p>
            
            <p>
                Contattaci per qualsiasi informazione o curiosità! Siamo sempre felici di aiutarti.
            </p>

            <p>
                Email: info@rungame.it | Telefono: +39 123 456 789
            </p>
        </div>
    </footer>
</body>
</html>