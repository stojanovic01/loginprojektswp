<?php
session_start();

$host = "e157104-mysql.services.easyname.eu";
$user = "u243204db1"; 
$pass = "01122024spSP."; 
$dbname = "u243204db1"; 

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$emailadresse = $_POST['emailadresse'];
$password = $_POST['password'];

// Passwort hashen
$password_hash = hash('sha256', $password);

$sql = "SELECT * FROM user WHERE emailadresse=? AND user_password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $emailadresse, $password_hash);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // Login erfolgreich - 2FA Code generieren
    $code = sprintf("%05d", rand(0, 99999)); // 5-stelliger Code
    
    // Code in Session speichern (für 2FA)
    $_SESSION['email'] = $emailadresse;
    $_SESSION['2fa_code'] = $code;
    $_SESSION['2fa_time'] = time();
    
    // Code erstmal direkt anzeigen (ohne E-Mail)
    echo "<!DOCTYPE html><html><head><title>2FA Code</title><link rel='stylesheet' href='style.css'></head><body>";
    echo "<h2>Login erfolgreich!</h2>";
    echo "<p>Dein 2FA Code: <strong style='font-size: 2em; color: green;'>$code</strong></p>";
    echo "<p>Gib diesen Code auf der nächsten Seite ein:</p>";
    echo '<a href="verify_code.php" style="background: green; color: white; padding: 10px; text-decoration: none;">Code eingeben</a><br><br>';
    echo '<a href="login.php">Zurück zum Login</a>';
    echo "</body></html>";
    
} else {
    echo "<!DOCTYPE html><html><head><title>Login Fehler</title><link rel='stylesheet' href='style.css'></head><body>";
    echo "<h2>Login fehlgeschlagen</h2>";
    echo "<p>E-Mail oder Passwort ist falsch.</p>";
    echo '<a href="login.php">Zurück zum Login</a>';
    echo "</body></html>";
}

$stmt->close();
$conn->close();
?>
