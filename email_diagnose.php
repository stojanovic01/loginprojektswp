<?php
echo "<h2>E-Mail Test Diagnose</h2>";

// Schritt 1: PHPMailer Dateien prüfen
echo "<h3>1. PHPMailer Dateien prüfen:</h3>";
$phpmailer_files = [
    'PHPMailer-7.0.0/src/Exception.php',
    'PHPMailer-7.0.0/src/PHPMailer.php', 
    'PHPMailer-7.0.0/src/SMTP.php'
];

$files_ok = true;
foreach ($phpmailer_files as $file) {
    if (file_exists($file)) {
        echo "✅ $file existiert<br>";
    } else {
        echo "❌ $file NICHT GEFUNDEN!<br>";
        $files_ok = false;
    }
}

if (!$files_ok) {
    echo "<p style='color: red;'>PHPMailer Dateien fehlen! Upload prüfen.</p>";
    exit();
}

// Schritt 2: PHPMailer laden
echo "<h3>2. PHPMailer laden:</h3>";
try {
    require_once 'PHPMailer-7.0.0/src/Exception.php';
    require_once 'PHPMailer-7.0.0/src/PHPMailer.php';
    require_once 'PHPMailer-7.0.0/src/SMTP.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    echo "✅ PHPMailer erfolgreich geladen<br>";
} catch (Exception $e) {
    echo "❌ Fehler beim Laden: " . $e->getMessage() . "<br>";
    exit();
}

// Schritt 3: E-Mail-Konfiguration testen
echo "<h3>3. E-Mail Test:</h3>";

$mail = new PHPMailer(true); // Mit Exceptions für detaillierte Fehler

try {
    // SMTP Konfiguration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'stasastojanovic09@gmail.com';
    $mail->Password = 'ibkppsdzumdaware'; // Dein App-Passwort
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';
    
    // Debugging aktivieren
    $mail->SMTPDebug = 2; // Zeigt SMTP-Kommunikation
    $mail->Debugoutput = function($str, $level) {
        echo "DEBUG ($level): " . htmlspecialchars($str) . "<br>";
    };
    
    echo "SMTP Konfiguration gesetzt.<br>";
    
    // E-Mail Details
    $mail->setFrom('stasastojanovic09@gmail.com', '2FA Test System');
    $mail->addAddress('stasastojanovic09@gmail.com'); // Test an dich selbst
    
    $mail->isHTML(false);
    $mail->Subject = 'PHPMailer Test - ' . date('Y-m-d H:i:s');
    $mail->Body = "Dies ist ein Test der PHPMailer Konfiguration.\n\nZeit: " . date('Y-m-d H:i:s') . "\n\nWenn du diese E-Mail erhältst, funktioniert PHPMailer!";
    
    echo "<h4>Versuche E-Mail zu senden...</h4>";
    
    if ($mail->send()) {
        echo "<p style='color: green; font-size: 1.2em;'>✅ E-MAIL ERFOLGREICH GESENDET!</p>";
        echo "<p>Prüfe dein E-Mail Postfach (auch Spam-Ordner).</p>";
    } else {
        echo "<p style='color: red;'>❌ E-Mail senden fehlgeschlagen.</p>";
        echo "Fehler: " . $mail->ErrorInfo . "<br>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ FEHLER BEIM E-MAIL VERSAND:</p>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    
    echo "<h4>Mögliche Lösungen:</h4>";
    echo "<ul>";
    echo "<li>App-Passwort ist falsch oder abgelaufen</li>";
    echo "<li>2-Faktor-Authentifizierung nicht aktiviert</li>";
    echo "<li>Gmail blockiert den Zugriff</li>";
    echo "<li>SMTP Port 587 ist blockiert</li>";
    echo "</ul>";
}

echo "<br><a href='login.php'>Zurück zum Login</a>";
?>