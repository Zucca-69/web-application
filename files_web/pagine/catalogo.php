
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
        session_start(); 
        include '../php_files/header_check.php'; 
        include '../php_files/db_connection.php'; 
    ?>

    <div class="catalogo-title">CATALOGO</div>

    <?php
        $numGiochiPagina = 25;

        // condizioni del filtro
        $condizioniFiltro = [];

        // filtro categoria
        if (isset($_GET['categoryId'])) {
            $categoria = $conn->real_escape_string($_GET['categoryId']);
            $condizioniFiltro[] = "a.FKcategoryId = '$categoria'";
        }

        // filtra nuove uscite
        if (isset($_GET['news']) && $_GET['news'] == '1') {
            $condizioniFiltro[] = "dataUscita BETWEEN (SELECT NOW() - INTERVAL 1 MONTH) AND NOW()";
        }

        // Build the final WHERE clause
        $condizioneFiltro = '';
        if (!empty($condizioniFiltro)) {
            $condizioneFiltro = "WHERE " . implode(" AND ", $condizioniFiltro);
        }

        $query = "SELECT MIN(p.productId) as productId, p.nome,p.piattaforma, i.imageData, i.imageType
                FROM prodotti p
                JOIN immagini i ON p.productId = i.FKproductId
                JOIN appartenenze a ON p.productId = a.FKproductId
                $condizioneFiltro
                GROUP BY p.nome";

        $rawResult = $conn->query($query);

        $giochi = [];
        if ($rawResult && $rawResult->num_rows > 0) {
            while ($row = $rawResult->fetch_assoc()) {
                $giochi[] = [
                    'productId' => $row['productId'],
                    'piattaforma' => $row['piattaforma'],
                    'nome' => $row['nome'],
                    'src' => "data:" . $row['imageType'] . ";base64," . base64_encode($row['imageData'])
                ];
            }
        } else {
            echo "<div class='sezione'><div class='testo-nessun-gioco'> Siamo spiacenti, non abbiamo prodotti che riespettano i tuoi parametri di ricerca. </div></div>";
        }

        // chiudo la connessione al server una volta finite le query necessarie
        $conn -> close();
    ?>

    <div class="catalogo">
        <?php 
            foreach ($giochi as $gioco) {
                $out = "<a href='mostra-prodotti.php?productId=" . $gioco['productId'] . "&piattaforma=" . $gioco['piattaforma'] . "'>
                            <div class='catalogo-item'>
                                <img src='" . $gioco['src'] . "' alt='Immagine'>
                                <div class='sottotitolo'>" . $gioco['nome'] . "</div> 
                            </div>
                        </a>";
                echo $out;
            }
        ?>
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