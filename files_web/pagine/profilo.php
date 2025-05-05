<?php 
// Avvia la sessione per gestire l'immagine profilo
session_start(); 
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RunGame - profilo</title>
    <!-- collegamento dei file CSS globali + specifici -->
    <link rel="stylesheet" href="../css/global.css"> 
    <link rel="stylesheet" href="../css/profilo.css">
    <link rel="stylesheet" href="../css/footer.css">

</head>
<?php include '../php_files/header.php'; ?>

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
            <div class="sezione-sotto-immagine">
            <?php if (!empty($userData)): ?>
                <div><strong>Nome:</strong> <?= htmlspecialchars($userData['nome']) ?></div>
                <div><strong>Cognome:</strong> <?= htmlspecialchars($userData['cognome']) ?></div>
                <div><strong>Username:</strong> <?= htmlspecialchars($userData['username']) ?></div>
                <div><strong>Email:</strong> <?= htmlspecialchars($userData['email']) ?></div>
                <div><strong>Data di Nascita:</strong> <?= htmlspecialchars($userData['data_nascita']) ?></div>
                <div>
                    <strong>Bio:</strong><br>
                    <form action="../php_files/update_bio.php" method="POST">
                        <textarea name="bio" rows="4" cols="40"><?= htmlspecialchars($userData['bio']) ?></textarea><br>
                        <button type="submit">Aggiorna Bio</button>
                    </form>
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
    
            <p>Email: info@tuaazienda.it | Telefono: +39 123 456 789</p>
        </div>
    </footer>


</body>
</html>












<!-- 
Ottimo! Ti spiego **come aggiornare la bio in tempo reale usando AJAX**, senza ricaricare la pagina.

---

### 🔁 Funzionalità:

* L'utente scrive nella `textarea`.
* Appena clicca su “Aggiorna Bio”, viene inviata una richiesta AJAX a `update_bio.php`.
* La risposta appare subito (es. “Bio aggiornata con successo”), **senza refresh**.

---

### 🔧 Passaggi:

#### 1. **Modifica il form HTML in `profilo.php`**

Sostituisci il `form` nella `.sezione-sotto-immagine` con:

```html
<div>
    <strong>Bio:</strong><br>
    <textarea id="bio" rows="4" cols="40"><?= htmlspecialchars($userData['bio']) ?></textarea><br>
    <button type="button" id="updateBioBtn">Aggiorna Bio</button>
    <div id="bioStatus" style="margin-top: 10px; color: green;"></div>
</div>
```

---

#### 2. **Aggiungi lo script JavaScript in fondo a `profilo.php` (prima di `</body>`)**

```html
<script>
document.getElementById("updateBioBtn").addEventListener("click", function() {
    const bio = document.getElementById("bio").value;
    const status = document.getElementById("bioStatus");

    fetch("../php_files/update_bio.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "bio=" + encodeURIComponent(bio)
    })
    .then(response => response.text())
    .then(data => {
        status.textContent = "Bio aggiornata con successo!";
        status.style.color = "green";
    })
    .catch(error => {
        status.textContent = "Errore durante l'aggiornamento.";
        status.style.color = "red";
        console.error("Errore:", error);
    });
});
</script>
```

---

#### 3. **Modifica `update_bio.php` per rispondere correttamente ad AJAX**

Sostituisci il `header("Location: ...")` con una semplice `echo`:

```php
<?php
// session_start();
// require_once("db_connection.php");

// if (isset($_SESSION['user_id'], $_POST['bio'])) {
//     $userId = $_SESSION['user_id'];
//     $bio = trim($_POST['bio']);

//     $stmt = $conn->prepare("UPDATE utenti SET bio = ? WHERE id = ?");
//     $stmt->bind_param("si", $bio, $userId);

//     if ($stmt->execute()) {
//         echo "success";
//     } else {
//         echo "error";
//     }

//     $stmt->close();
// } else {
//     echo "invalid";
// }
?>
```

---

### ✅ Risultato:

L'utente può modificare la bio, cliccare su “Aggiorna Bio” e vedrà un messaggio conferma istantaneamente, **senza ricaricare la pagina**.

Vuoi aggiungere il salvataggio automatico della bio man mano che l’utente scrive (auto-save)? -->
