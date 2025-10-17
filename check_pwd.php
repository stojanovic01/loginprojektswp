<?php
session_start();

$host = "e157104-mysql.services.easyname.eu";
$user = "u243204db1"; 
$pass = "01122024spSP."; 
$dbname = "d243204db1"; 

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$emailadresse = $_POST['emailadresse'];
$password_hash = $_POST['password_hash'];

$sql = "SELECT * FROM users WHERE emailadresse=? AND password_hash=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $emailadresse, $password_hash);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // Login erfolgreich - 2FA Code generieren
    $code = sprintf("%05d", rand(0, 99999)); // 5-stelliger Code
    
    // Code in Session speichern
    $_SESSION['email'] = $emailadresse;
    $_SESSION['2fa_code'] = $code;
    $_SESSION['2fa_time'] = time();
    
    // Code in logins-Tabelle speichern
    $sql_insert = "INSERT INTO logins (email_adress, sentcode, timestamp) VALUES (?, ?, NOW())";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ss", $emailadresse, $code);
    $stmt_insert->execute();
    $stmt_insert->close();
    
    // E-Mail senden
    $betreff = "Ihr 2FA Login-Code";
    $nachricht = "Ihr Verifizierungscode lautet: " . $code . "\n\nDieser Code ist 2 Minuten gültig.";
    $headers = "From: noreply@yourdomain.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    if (mail($emailadresse, $betreff, $nachricht, $headers)) {
        // Weiterleitung zur Code-Eingabe
        header("Location: verify_code.php");
        exit();
    } else {
        echo "Fehler beim Senden der E-Mail. Bitte versuchen Sie es erneut.";
    }
    
} else {
    echo "Login fehlgeschlagen. Versuche es mit einer anderen Emailadresse oder Passwort erneut.<br>";
    echo '<a href="login.php">Zurück zum Login</a>';
}

$stmt->close();
$conn->close();
?>
