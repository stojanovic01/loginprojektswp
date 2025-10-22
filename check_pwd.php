<?php
session_start();

// Robuste E-Mail Funktion einbinden
require_once 'send_email_robust.php';

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
    
    // E-Mail mit EmailJS (Frontend-Lösung)
    echo "<!DOCTYPE html><html><head><title>2FA Code</title><link rel='stylesheet' href='style.css'>";
    echo '<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>';
    echo "</head><body>";
    echo "<h2>Login erfolgreich!</h2>";
    echo "<p>Sende 2FA Code an <strong>$emailadresse</strong>...</p>";
    echo '<div id="email-status">Sende E-Mail...</div>';
    echo "<p><strong>Dein Code: <span style='font-size: 2em; color: green;'>$code</span></strong></p>";
    echo "<p>(Falls E-Mail nicht ankommt, verwende den Code oben)</p>";
    echo '<a href="verify_code.php" style="background: green; color: white; padding: 10px; text-decoration: none;">Code eingeben</a><br><br>';
    echo '<a href="login.php">Zurück zum Login</a>';
    
    echo '<script>
        // EmailJS konfiguration - TRAGE DEINE ECHTEN DATEN EIN!
        emailjs.init("KZtWegtZ4OXhRpgNX"); // z.B. "user_abc123defgh"
        
        const templateParams = {
            to_name: "Benutzer",
            to_email: "' . $emailadresse . '",
            verification_code: "' . $code . '"
        };
        
        // Versuche E-Mail zu senden - TRAGE DEINE ECHTEN IDs EIN!
        emailjs.send("service_j39neem", "template_c0qfciv", templateParams)
            .then(function(response) {
                console.log("EmailJS Erfolg:", response);
                document.getElementById("email-status").innerHTML = "✅ E-Mail erfolgreich gesendet!";
                document.getElementById("email-status").style.color = "green";
            })
            .catch(function(error) {
                console.error("EmailJS Fehler Details:", error);
                document.getElementById("email-status").innerHTML = "⚠️ Fehler: " + error.text + " - verwende den Code oben";
                document.getElementById("email-status").style.color = "orange";
            });
    </script>';
    
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
