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
    $piattaforme = $_POST['piattaforma'] ?? [];
    $multiInsert = isset($_POST['multiInsert']) && $_POST['multiInsert'] == '1';
    $quantitaDisponibile = intval($_POST['quantitaDisponibile'] ?? 0);
    $dataUscita = $_POST['dataUscita'] ?? null;
    $dataDisponibile = $_POST['dataDisponibile'] ?? null;
    $sconto = intval($_POST['sconto'] ?? 0);

    if ($nome && $descrizione && $prezzo > 0 && $quantitaDisponibile >= 0 && $dataUscita && count($piattaforme) > 0) {
        $stmt = $conn->prepare("INSERT INTO prodotti (nome, descrizione, prezzo, saga, piattaforma, quantitaDisponibile, dataUscita, dataDisponibile, sconto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($piattaforme as $piattaforma) {
            $stmt->bind_param("ssdssisss", $nome, $descrizione, $prezzo, $saga, $piattaforma, $quantitaDisponibile, $dataUscita, $dataDisponibile, $sconto);
            if (!$stmt->execute()) {
                $message .= "❌ Errore per piattaforma $piattaforma: " . $stmt->error . "<br>";
            } else {
                $message .= "✅ Prodotto inserito per piattaforma $piattaforma.<br>";
            }
        }
        $stmt->close();
    } else {
        $message = "❌ Compila tutti i campi obbligatori correttamente e seleziona almeno una piattaforma.";
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

        <label>Piattaforme*</label>
        <div>
            <label><input type="checkbox" name="piattaforma[]" value="PS3"> PS3</label><br>
            <label><input type="checkbox" name="piattaforma[]" value="PS4"> PS4</label><br>
            <label><input type="checkbox" name="piattaforma[]" value="PS5"> PS5</label><br>
            <label><input type="checkbox" name="piattaforma[]" value="PC"> PC</label><br>
            <label><input type="checkbox" name="piattaforma[]" value="XBOX360"> XBOX360</label><br>
            <label><input type="checkbox" name="piattaforma[]" value="XBOXONE"> XBOXONE</label><br>
        </div>

        <label>
            <input type="checkbox" name="multiInsert" value="1">
            Inserisci per tutte le piattaforme selezionate
        </label>


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
