<?php
$host = "e157104-mysql.services.easyname.eu"; // dein Host
$user = "u243204db1"; // dein DB-User
$pass = "DEIN_PASSWORT"; // dein DB-Passwort
$dbname = "d243204db1"; // deine DB

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$email = $_POST['email'];
$password_hash = $_POST['password_hash'];

$sql = "SELECT * FROM users WHERE email=? AND password_hash=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password_hash);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    echo "✅ Login erfolgreich. Willkommen, " . htmlspecialchars($email);
} else {
    echo "❌ Login fehlgeschlagen.";
}

$stmt->close();
$conn->close();
?>
