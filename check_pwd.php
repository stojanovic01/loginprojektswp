<?php
//$host = "e157104-mysql.services.easyname.eu";
$host = "localhost";
$user = "u243204db1";
$pass = "01122024spSP.";
$dbname = "u243204db1";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Debug: Prüfen, was ankommt
var_dump($_POST);

$username = $_POST['username'] ?? '';
$password_hash = $_POST['password_hash'] ?? '';

// Sicherheit: Felder nicht leer
if (empty($username) || empty($password_hash)) {
    die("Fehler: Username oder Passwort-Hash fehlt!");
}

$sql = "SELECT * FROM user WHERE username=? AND user_password=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password_hash); 
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    echo "✅ Login erfolgreich. Willkommen, " . htmlspecialchars($username);
} else {
    echo "❌ Login fehlgeschlagen. Versuche es mit einem anderen Username oder Passwort.";
}

$stmt->close();
$conn->close();
?>
