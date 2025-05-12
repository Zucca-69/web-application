<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RunGame - Profilo</title>
    <!-- collegamento dei file CSS globali + specifici -->
    <link rel="stylesheet" href="../css/global.css"> 
    <link rel="stylesheet" href="../css/profilo.css">
    <link rel="stylesheet" href="../css/footer.css">

</head>

<?php include '../php_files/header_check.php'; ?>
<?php include '../php_files/get_user_data.php';?>

<body>
    <!-- Contenitore principale -->
    <div class="container">
        <!-- Immagine grande a sinistra -->
        <div class="galleria-sinistra">
        <div class="profile-pic-wrapper">
        <form action="../php_files/change_profile_img.php" method="POST" enctype="multipart/form-data" id="uploadForm">
                    <label for="profileUpload">
                    <div class="img.profile-pic">
                        <img src="../php_files/get_profile_img.php" alt="Immagine profilo" class="profile-pic" />
                    </div>
                        <div class="overlay">
                            <span>Cambia immagine</span>
                        </div>
                    </label>
                    <input type="file" id="profileUpload" name="profile_img" onchange="this.form.submit()" hidden />
                </div>
            </form>
            <!-- Pulsante per rimuovere l'immagine -->
            <form action="../php_files/change_profile_img.php" method="POST">
                <input type="hidden" name="remove_profile_image" value="1" />
                <button type="submit" class="remove-btn">Rimuovi immagine profilo</button>
            </form>

            <!-- Nuova sezione sotto l'immagine -->
            <!-- htmlspecialchars codifica la stringa in html elements, ciò serve ad evitare che vengano letti ed eseguiti i tag 
             es: il nickname <b>SONOpiùBello</b>, senza specialchar, risulterebbe in grassetto-->
            <div class="sezione-sotto-immagine">
            <?php if (!empty($userData)): ?>
                <div><strong>Nome:</strong> <?= htmlspecialchars($userData['nome']) ?></div>
                <div><strong>Cognome:</strong> <?= htmlspecialchars($userData['cognome']) ?></div>
                <div><strong>Username:</strong> <?= htmlspecialchars($userData['username']) ?></div>
                <div><strong>Email:</strong> <?= htmlspecialchars($userData['email']) ?></div>
                <div><strong>Data di Nascita:</strong> <?= htmlspecialchars($userData['dataNascita']) ?></div>
                <div>
                    <!-- 
                    <strong>Bio:</strong><br>
                    <form action="../php_files/update_bio.php" method="POST">
                        <textarea name="bio" rows="4" cols="40"><?= htmlspecialchars($userData['bio']) ?></textarea><br>
                        <button type="submit">Aggiorna Bio</button>
                    </form>
                     -->
                </div>
            <?php else: ?>
                <p>Dati utente non disponibili.</p>
            <?php endif; ?>
        </div>

        </div>

        <!-- Sezioni a destra -->
        <div class="sezioni-contenitore">
            <div class="sezione">
                <div class="sezione-titolo">CARRELLO</div>
                <div class="sezione-img-container">
                    <img class="mini" src="../MEDIA/immagini/tekken-8-anteprima-06.webp" alt="Immagine 1">
                    <img class="mini" src="../MEDIA/immagini/uncharted-golden-abyss-leap-of-faith-1080p-wallpaper_bbgm.1280.webp" alt="Immagine 2">
                    <img class="mini" src="../MEDIA/immagini/FIFA-12.jpg" alt="Immagine 3">
                    <img class="mini" src="../MEDIA/immagini/tekken-8-anteprima-06.webp" alt="Immagine 4">
                    <img class="mini" src="../MEDIA/immagini/uncharted-golden-abyss-leap-of-faith-1080p-wallpaper_bbgm.1280.webp" alt="Immagine 5">
                </div>
            </div>

            <div class="sezione">
                <div class="sezione-titolo">CONSIGLIATI</div>
                <div class="sezione-img-container">
                    <img class="mini" src="../MEDIA/immagini/tekken-8-anteprima-06.webp" alt="Immagine 6">
                    <img class="mini" src="../MEDIA/immagini/uncharted-golden-abyss-leap-of-faith-1080p-wallpaper_bbgm.1280.webp" alt="Immagine 7">
                    <img class="mini" src="../MEDIA/immagini/FIFA-12.jpg" alt="Immagine 8">
                    <img class="mini" src="../MEDIA/immagini/tekken-8-anteprima-06.webp" alt="Immagine 9">
                    <img class="mini" src="../MEDIA/immagini/uncharted-golden-abyss-leap-of-faith-1080p-wallpaper_bbgm.1280.webp" alt="Immagine 10">
                </div>
            </div>

            <div class="sezione">
                <div class="sezione-titolo">CRONOLOGIA</div>
                <div class="sezione-img-container">
                    <img class="mini" src="../MEDIA/immagini/tekken-8-anteprima-06.webp" alt="Immagine 6">
                    <img class="mini" src="../MEDIA/immagini/uncharted-golden-abyss-leap-of-faith-1080p-wallpaper_bbgm.1280.webp" alt="Immagine 7">
                    <img class="mini" src="../MEDIA/immagini/FIFA-12.jpg" alt="Immagine 8">
                    <img class="mini" src="../MEDIA/immagini/tekken-8-anteprima-06.webp" alt="Immagine 9">
                    <img class="mini" src="../MEDIA/immagini/uncharted-golden-abyss-leap-of-faith-1080p-wallpaper_bbgm.1280.webp" alt="Immagine 10">
                </div>
            </div>
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
    
            <p>Email: info@rungame.it | Telefono: +39 123 456 789</p>
        </div>
    </footer>


</body>
</html>
