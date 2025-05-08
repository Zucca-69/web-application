<?php 
// Questo file gestisce la registrazione di un nuovo utente

session_start();
require_once 'db_connection.php'; // Connessione al database

if (isset($_POST['username'])) {
    // Ricezione dati dal form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $nome = trim($_POST['nome']);
    $cognome = trim($_POST['cognome']);
    $dataNascita = $_POST['dataNascita'];

    // Controlla se l'utente esiste già
    $sql_check = "SELECT userId FROM Utenti WHERE username=?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('s', $username);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "L'utente esiste già.";
    } else {
        // Hash della password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Genera codice di verifica
        $codiceVerifica = strval(rand(100000, 999999));
        $dataIscrizione = date('Y-m-d');
        $verificato = 0;

        // Inserisce nuovo utente
        $sql_insert = "INSERT INTO Utenti (nome, cognome, dataNascita, dataIscrizione, email, username, passwordHash, codiceVerifica, verificato) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssssssssi", $nome, $cognome, $dataNascita, $dataIscrizione, $email, $username, $hashed_password, $codiceVerifica, $verificato);

        if ($stmt_insert->execute()) {
            // Invia email con codice di verifica
            $headers = "From: noreply@localhost";
            mail($email, "Benvenuto su RunGame!", "Grazie per esserti registrato!\nIl tuo codice di conferma è: $codiceVerifica", $headers);

            // Redirect alla pagina di verifica
            header("Location: ../pagine/verifica.php?utente=$username");
            exit();
        } else {
            echo "Errore durante la registrazione: " . $stmt_insert->error;
        }

    $stmt_check->close();
    if (isset($stmt_insert)) $stmt_insert->close();
    $conn->close();
}
?>
