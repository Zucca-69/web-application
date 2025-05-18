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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Aggiungi Prodotto</title>
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --error-color: #f72585;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: #f5f7fa;
            color: var(--dark-color);
            padding: 40px 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        h1 {
            color: var(--primary-color);
            margin-bottom: 30px;
            text-align: center;
            font-size: 2.2rem;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--secondary-color);
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: var(--transition);
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        button {
            grid-column: span 2;
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 14px;
            font-size: 16px;
            font-weight: 600;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            margin-top: 10px;
        }

        button:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .message {
            margin-top: 25px;
            padding: 15px;
            border-radius: var(--border-radius);
            font-weight: 600;
            text-align: center;
        }

        .success {
            background-color: rgba(76, 201, 240, 0.2);
            color: #1a936f;
            border: 1px solid #4cc9f0;
        }

        .error {
            background-color: rgba(247, 37, 133, 0.2);
            color: #d00000;
            border: 1px solid var(--error-color);
        }

        .required::after {
            content: " *";
            color: var(--error-color);
        }

        @media (max-width: 768px) {
            form {
                grid-template-columns: 1fr;
            }
            
            .form-group.full-width, button {
                grid-column: span 1;
            }
            
            body {
                padding: 20px 10px;
            }
            
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin: Aggiungi Prodotto</h1>

        <form method="POST">
            <div class="form-group full-width">
                <label for="nome" class="required">Nome</label>
                <input type="text" name="nome" required>
            </div>

            <div class="form-group full-width">
                <label for="descrizione" class="required">Descrizione</label>
                <textarea name="descrizione" rows="5" required></textarea>
            </div>

            <div class="form-group">
                <label for="prezzo" class="required">Prezzo (€)</label>
                <input type="number" step="0.01" name="prezzo" required>
            </div>

            <div class="form-group">
                <label for="sconto">Sconto (%)</label>
                <input type="number" name="sconto" min="0" max="100" value="0">
            </div>

            <div class="form-group">
                <label for="saga">Saga</label>
                <input type="text" name="saga">
            </div>

            <div class="form-group">
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
            </div>

            <div class="form-group">
                <label for="quantitaDisponibile" class="required">Quantità Disponibile</label>
                <input type="number" name="quantitaDisponibile" required>
            </div>

            <div class="form-group">
                <label for="dataUscita" class="required">Data Uscita</label>
                <input type="date" name="dataUscita" required>
            </div>

            <div class="form-group">
                <label for="dataDisponibile">Data Disponibile</label>
                <input type="date" name="dataDisponibile">
            </div>

            <button type="submit">Aggiungi Prodotto</button>
        </form>

        <?php if ($message): ?>
            <div class="message <?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>