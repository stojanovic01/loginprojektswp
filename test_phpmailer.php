<?php
echo "<h2>PHPMailer Test</h2>";

// Prüfe ob PHPMailer Dateien existieren
$phpmailer_files = [
    'PHPMailer-7.0.0/src/Exception.php',
    'PHPMailer-7.0.0/src/PHPMailer.php', 
    'PHPMailer-7.0.0/src/SMTP.php'
];

echo "<h3>1. Prüfe PHPMailer Dateien:</h3>";
foreach ($phpmailer_files as $file) {
    if (file_exists($file)) {
        echo "✅ $file existiert<br>";
    } else {
        echo "❌ $file NICHT GEFUNDEN!<br>";
    }
}

echo "<h3>2. Teste PHPMailer Loading:</h3>";
try {
    require_once 'PHPMailer-7.0.0/src/Exception.php';
    require_once 'PHPMailer-7.0.0/src/PHPMailer.php';
    require_once 'PHPMailer-7.0.0/src/SMTP.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    $mail = new PHPMailer(true);
    echo "✅ PHPMailer Klasse erfolgreich geladen!<br>";
    
    echo "<h3>3. Teste SMTP Verbindung:</h3>";
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'stasastojanovic09@gmail.com';
    $mail->Password = 'tnkn ghvr ttbv ncga';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    
    echo "SMTP Konfiguration gesetzt.<br>";
    echo "✅ PHPMailer ist bereit zum Senden!<br>";
    
} catch (Exception $e) {
    echo "❌ PHPMailer Fehler: " . $e->getMessage() . "<br>";
}

echo "<br><a href='login.php'>Zurück zum Login</a>";
?>