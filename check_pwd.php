<?php
session_start();

// PHPMailer Email-Funktion einbinden
require_once 'send_email.php';

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

$sql = "SELECT * FROM user WHERE email_adresse=? AND user_password=?";
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
    
    // Debug: Code generiert
    echo "DEBUG: Code generiert: " . $code . "<br>";
    echo "DEBUG: Session gesetzt für Email: " . $emailadresse . "<br>";
    
    // E-Mail mit PHPMailer senden
    $emailSent = sendVerificationEmail($emailadresse, $code);
    echo "DEBUG: E-Mail-Versand Ergebnis: " . ($emailSent ? "Erfolgreich" : "Fehlgeschlagen") . "<br>";
    
    if ($emailSent) {
        // Weiterleitung zur Code-Eingabe
        echo "DEBUG: Weiterleitung zu verify_code.php...<br>";
        echo '<a href="verify_code.php">Manuell weiterleiten (falls automatisch nicht funktioniert)</a><br>';
        // header("Location: verify_code.php");
        // exit();
    } else {
        echo "Fehler beim Senden der E-Mail. Bitte versuchen Sie es erneut.<br>";
        echo '<a href="login.php">Zurück zum Login</a>';
    }
    
} else {
    echo "Login fehlgeschlagen. Versuche es mit einer anderen Emailadresse oder Passwort erneut.<br>";
    echo '<a href="login.php">Zurück zum Login</a>';
}

$stmt->close();
$conn->close();
?>
