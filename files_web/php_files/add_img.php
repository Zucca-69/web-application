<?php
include 'db_connection.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $FKproductId = $_POST['FKproductId'];

    // elenco dei nomi input file
    $imageFields = ['image1', 'image2', 'image3'];

    foreach ($imageFields as $fieldName) {
        if (isset($_FILES[$fieldName]) && is_uploaded_file($_FILES[$fieldName]['tmp_name'])) {
            $imgData = file_get_contents($_FILES[$fieldName]['tmp_name']);
            $imgName = $_FILES[$fieldName]['name'];
            $imgType = $_FILES[$fieldName]['type'];
            $imgSize = $_FILES[$fieldName]['size'];

            $sql = "INSERT INTO immagini (imageData, imageName, imageType, imageSize, FKproductId) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sssii', $imgData, $imgName, $imgType, $imgSize, $FKproductId);
            $stmt->execute();
        }
    }

    echo "Immagini caricate correttamente.";
}
?>


<HTML>
    <HEAD>
        <TITLE>Add Immagine Admin</TITLE>
        <meta charset="UTF-8">
    </HEAD>
    <header>   
        <div class="navbar-container">
        <!-- Logo a sinistra -->
         <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/contact.css">
        <link rel="stylesheet" href="../css/footer.css">
        <link rel="stylesheet" href="../css/darkmode.css">
        <link rel="stylesheet" href="../css/galleria.css">
        <link rel="stylesheet" href="../css/barra-navigazione.css">
        </header>

    <BODY>
        <?php include '../php_files/header_check.php'; ?>
        <div class="contact-container">
            
                <h1>Admin: Aggiungi Immagini</h1>
                <form name="frmImage" enctype="multipart/form-data" action="add_img.php" method="post" class="form">
                    <label>ID prodotto:</label>
                    <input type="text" name="FKproductId" required><br><br>

                    <label>Banner (immagine 1):</label>
                    <input type="file" name="image1" required><br><br>

                    <label>Gameplay / Showcase 1 (immagine 2):</label>
                    <input type="file" name="image2"><br><br>

                    <label>Gameplay / Showcase 2 (immagine 3):</label>
                    <input type="file" name="image3"><br><br>

                    <input type="submit" value="Carica Immagini">
                </form>
            
        </div>

    </BODY>
</HTML>