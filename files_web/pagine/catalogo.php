<?php 
// Avvia la sessione per gestire login/logout
session_start(); 
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RunGame - Catalogo</title>
    
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/barra-navigazione.css">
    <link rel="stylesheet" href="../css/catalogo.css">

</head>
<body>
    <?php 
        include '../php_files/header_check.php'; 
        include '../php_files/db_connection.php'; 

        $numGiochiPagina = 25;

        $query = "SELECT MIN(p.productId) as productId, p.nome, i.imageData, i.imageType
                FROM prodotti p
                JOIN immagini i ON p.productId = i.FKproductId
                GROUP BY p.nome";

        $rawResult = $conn->query($query);

        $giochi = [];
        if ($rawResult && $rawResult->num_rows > 0) {
            while ($row = $rawResult->fetch_assoc()) {
                $giochi[] = [
                    'productId' => $row['productId'],
                    'nome' => $row['nome'],
                    'src' => "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData'])
                ];
            }
        } else {
            echo "errore query: " . $conn->error;
        }

        // chiudo la connessione al server una volta finite le query necessarie
        $conn -> close();
    ?>

    <div class="catalogo-title">CATALOGO</div>

        <div class="catalogo">
            <?php 
                foreach ($giochi as $gioco) {
                    $out = "<a href='mostra-prodotti.php?productId=" . $gioco['productId'] . "'>
                                <div class='catalogo-item'>
                                    <img src='" . $gioco['src'] . "' alt='Immagine'>
                                    <div class='sottotitolo'>" . $gioco['nome'] . "</div> 
                                </div>
                            </a>";
                    echo $out;
                }
            ?>
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

            <p>Email: info@rungame.it | Telefono: +39 123 456 789</p>
        </div>
    </footer>

</body>
</html>