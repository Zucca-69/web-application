<?php
session_start();
require_once("../php_files/db_connection.php");

// (FACOLTATIVO) Controllo utente admin
// if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
//     die("Accesso negato.");
// }

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $descrizione = $_POST['descrizione'] ?? '';
    $prezzo = floatval($_POST['prezzo'] ?? 0);
    $saga = $_POST['saga'] ?? null;
    $piattaforma = $_POST['piattaforma'] ?? null;
    $quantitaDisponibile = intval($_POST['quantitaDisponibile'] ?? 0);
    $dataUscita = $_POST['dataUscita'] ?? null;
    $dataDisponibile = $_POST['dataDisponibile'] ?? null;
    $sconto = intval($_POST['sconto'] ?? 0);

    if ($nome && $descrizione && $prezzo > 0 && $quantitaDisponibile >= 0 && $dataUscita) {
        $stmt = $conn->prepare("INSERT INTO prodotti (nome, descrizione, prezzo, saga, piattaforma, quantitaDisponibile, dataUscita, dataDisponibile, sconto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdssisss", $nome, $descrizione, $prezzo, $saga, $piattaforma, $quantitaDisponibile, $dataUscita, $dataDisponibile, $sconto);
        if ($stmt->execute()) {
            $message = "✅ Prodotto inserito con successo.";
        } else {
            $message = "❌ Errore durante l'inserimento: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "❌ Compila tutti i campi obbligatori correttamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Admin - Aggiungi Prodotto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        form {
            max-width: 600px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
        }
        button {
            margin-top: 20px;
            padding: 10px;
            background: green;
            color: white;
            border: none;
            cursor: pointer;
        }
        .message {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h1>Admin: Aggiungi Prodotto</h1>

    <form method="POST">
        <label for="nome">Nome*</label>
        <input type="text" name="nome" required>

        <label for="descrizione">Descrizione*</label>
        <textarea name="descrizione" rows="5" required></textarea>

        <label for="prezzo">Prezzo (€)*</label>
        <input type="number" step="0.01" name="prezzo" required>

        <label for="saga">Saga</label>
        <input type="text" name="saga">

        <label for="piattaforma">Piattaforma</label>
        <select name="piattaforma">
            <option value="">-- Nessuna --</option>
            <option value="PS3">PS3</option>
            <option value="PS4">PS4</option>
            <option value="PS5">PS5</option>
            <option value="PC">PC</option>
            <option value="XBOX360">XBOX360</option>
            <option value="XBOXONE">XBOXONE</option>
        </select>

        <label for="quantitaDisponibile">Quantità Disponibile*</label>
        <input type="number" name="quantitaDisponibile" required>

        <label for="dataUscita">Data Uscita*</label>
        <input type="date" name="dataUscita" required>

        <label for="dataDisponibile">Data Disponibile</label>
        <input type="date" name="dataDisponibile">

        <label for="sconto">Sconto (%)</label>
        <input type="number" name="sconto" min="0" max="100" value="0">


        <button type="submit">Aggiungi Prodotto</button>
    </form>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

</body>
</html>
