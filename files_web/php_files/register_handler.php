<?php
// session_start();
// require_once 'db_connection.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $nome = trim($_POST['nome']);
//     $cognome = trim($_POST['cognome']);
//     $dataNascita = $_POST['dataNascita'];
//     $email = trim($_POST['email']);
//     $username = trim($_POST['username']);
//     $password = trim($_POST['password']);
    
//     // Hashiamo la password
//     $passwordHash = password_hash($password, PASSWORD_DEFAULT);

//     // Data di iscrizione oggi
//     $dataIscrizione = date('Y-m-d');

//     // Codice di verifica (esempio: stringa random)
//     $codiceVerifica = strval(rand(100000, 999999)); // codice di 6 cifre
//     $verificato = 0; // Utente non ancora verificato

//     $query = "INSERT INTO Utenti (nome, cognome, dataNascita, dataIscrizione, email, username, passwordHash, codiceVerifica, verificato) 
//               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

//     $stmt = $conn->prepare($query);
//     $stmt->bind_param("ssssssssi", $nome, $cognome, $dataNascita, $dataIscrizione, $email, $username, $passwordHash, $codiceVerifica, $verificato);

//     if ($stmt->execute()) {
//         // Registrazione riuscita
//         header("Location: ../pagine/login.php?success=1");
//         exit();
//     } else {
//         echo "Errore durante la registrazione: " . $stmt->error;
//     }
// }
?>
<?php
session_start();
require_once 'db_connection.php';

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $nome = trim($_POST['nome']);
    $cognome = trim($_POST['cognome']);
    $dataNascita = $_POST['dataNascita'];

    // Controllo se l'utente esiste già
    $sql_check = "SELECT userId FROM Utenti WHERE username=?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('s', $username);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "L'utente esiste già.";
    } else {
        // Se non esiste, lo registriamo
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $codiceVerifica = strval(rand(100000, 999999)); // codice di 6 cifre
        $dataIscrizione = date('Y-m-d');
        $verificato = 0;

        $sql_insert = "INSERT INTO Utenti (nome, cognome, dataNascita, dataIscrizione, email, username, passwordHash, codiceVerifica, verificato) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssssssssi", $nome, $cognome, $dataNascita, $dataIscrizione, $email, $username, $hashed_password, $codiceVerifica, $verificato);

        if ($stmt_insert->execute()) {
            // Invio email
            $headers = "From: noreply@localhost";
            mail($email, "Benvenuto su RunGame!", "Grazie per esserti registrato!\nIl tuo codice di conferma è: $codiceVerifica", $headers);

            // Redirigo a verifica
            header("Location: ../pagine/verifica.php?utente=$username");
            exit();
        } else {
            echo "Errore durante la registrazione: " . $stmt_insert->error;
        }
    }

    $stmt_check->close();
    if (isset($stmt_insert)) $stmt_insert->close();
    $conn->close();
}
?>

