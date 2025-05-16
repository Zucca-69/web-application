<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>RunGame</title>

        <!-- fogli di stile -->
        <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/slider.css">
        <link rel="stylesheet" href="../css/footer.css">
        <link rel="stylesheet" href="../css/categorie.css">
        <link rel="stylesheet" href="../css/barra-navigazione.css">
        <link rel="stylesheet" href="../css/mostra-prodotti.css">
    </head>

    <body>
        <?php 
            session_start();
            include '../php_files/header_check.php'; 
            include '../php_files/db_connection.php'; 
            include '../php_files/get_history.php';
            
            $productId = (int)$_GET['productId'];
            
            // se l'utente è loggato, aggiungi il gioco alla cronologia
            if (isset($_SESSION['userId'])) {
                $query = "INSERT INTO interazioni (FKuserId, FKproductId, FKcartId, tipologia, timestamp) 
                        VALUES (?, ?, NULL, 'visualizzato', NOW())";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ii", $_SESSION['userId'], $productId);
                $stmt->execute();
                $stmt->close();
            }

            // info sul gioco selezionato
            $gameInfo = [];
            $immagini = [];
            
            $query = "SELECT p.*, i.imageData, i.imageType 
                    FROM prodotti p
                    LEFT JOIN immagini i ON p.productId = i.FKproductId
                    WHERE p.productId = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                if (empty($gameInfo)) {
                    $gameInfo = $row;
                }
                if (!empty($row['imageData'])) {
                    $immagini[] = "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData']);
                }
            }
            $stmt->close();

            // piattaforme per cui è disponibile il gioco
            $piattaforme = [];
            if (!empty($gameInfo['nome'])) {
                $query = "SELECT productId, piattaforma FROM prodotti WHERE nome = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $gameInfo['nome']);
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($row = $result->fetch_assoc()) {
                    $piattaforme[] = [
                        'productId' => $row['productId'],
                        'piattaforma' => $row['piattaforma'],
                    ];
                }
                $stmt->close();
            }

            // ottieni i giochi della saga
            $saga = $gameInfo['saga'];
            $giochiSaga = [];
            if (!empty($saga)) {
                $query = "SELECT DISTINCT p.nome, p.productId, i.imageData, i.imageType
                        FROM prodotti p
                        JOIN immagini i ON p.productId = i.FKproductId
                        WHERE p.saga = ? 
                        AND p.productId != ?
                        GROUP BY p.productId
                        ORDER BY RAND()";

                $stmt = $conn->prepare($query);
                $stmt->bind_param("si", $gameInfo['saga'], $productId);
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($row = $result->fetch_assoc()) {
                    $giochiSaga[] = [
                        'productId' => $row['productId'],
                        'src' => "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData'])
                    ];
                }
                $stmt->close();
            }

            // giochi simili per categoria
            $giochiConsigliati = [];
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
                    AND (p.saga IS NULL OR p.saga != ?)
                    GROUP BY p.productId
                    ORDER BY RAND()
                    LIMIT 5";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iis", $productId, $productId, $gameInfo['saga']);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $giochiConsigliati[] = [
                    'productId' => $row['productId'],
                    'src' => "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData'])
                ];
            }
            $stmt->close();

            $conn->close();
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
                        // TODO : fixare la codifica del bd, guarda chatGPT moka
                        // https://chatgpt.com/c/6821a003-12b4-800b-b594-a11fcc2b18ac
                        echo htmlspecialchars($gameInfo['descrizione']);
                    ?>
                </p>
            </div>

            <?php
                // riquadro con la saga
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

                // riquadro per i correlati
                if (!empty($giochiConsigliati)) {
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

                // riquadro per la cronologia
                if (!empty($giochiVisualizzati)) {
                    echo "<div class='sezione'>
                        <div class='etichetta-sezione'>VISUALIZZATI IN PRECEDENZA:</div>
                        <div class='sezione-img-container'>";

                    foreach ($giochiVisualizzati as $giocoVisualizzato) {
                        echo "<a href='mostra-prodotti.php?productId=" . $giocoVisualizzato['productId'] . "'>";
                        echo "<img src='" . $giocoVisualizzato['src'] . "' alt='Gioco'>";
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