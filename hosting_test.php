<?php
echo "<h2>Hosting E-Mail Capability Test</h2>";

// Test 1: PHP mail() Funktion verfügbar?
echo "<h3>1. PHP mail() Funktion:</h3>";
if (function_exists('mail')) {
    echo "✅ mail() Funktion ist verfügbar<br>";
} else {
    echo "❌ mail() Funktion ist DEAKTIVIERT!<br>";
}

// Test 2: Sendmail Pfad
echo "<h3>2. Sendmail Konfiguration:</h3>";
$sendmail_path = ini_get('sendmail_path');
echo "Sendmail Pfad: " . ($sendmail_path ? $sendmail_path : "NICHT GESETZT") . "<br>";

// Test 3: SMTP verfügbar?
echo "<h3>3. SMTP Konfiguration:</h3>";
$smtp = ini_get('SMTP');
$smtp_port = ini_get('smtp_port');
echo "SMTP Server: " . ($smtp ? $smtp : "NICHT GESETZT") . "<br>";
echo "SMTP Port: " . ($smtp_port ? $smtp_port : "NICHT GESETZT") . "<br>";

// Test 4: Einfacher mail() Test mit mehr Details
echo "<h3>4. Direkter mail() Test:</h3>";

$test_email = "stasastojanovic09@gmail.com";
$test_subject = "Hosting Mail Test - " . date('H:i:s');
$test_message = "Test von: " . $_SERVER['HTTP_HOST'] . "\nZeit: " . date('Y-m-d H:i:s');
$test_headers = "From: test@" . $_SERVER['HTTP_HOST'];

echo "Versuche E-Mail zu senden...<br>";
echo "An: $test_email<br>";
echo "Betreff: $test_subject<br>";
echo "Absender: test@" . $_SERVER['HTTP_HOST'] . "<br><br>";

$result = mail($test_email, $test_subject, $test_message, $test_headers);

if ($result) {
    echo "<span style='color: green;'>✅ mail() Rückgabe: TRUE</span><br>";
} else {
    echo "<span style='color: red;'>❌ mail() Rückgabe: FALSE</span><br>";
}

// Test 5: Server-Informationen
echo "<h3>5. Server-Informationen:</h3>";
echo "Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unbekannt') . "<br>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Host: " . ($_SERVER['HTTP_HOST'] ?? 'Unbekannt') . "<br>";
echo "Server Admin: " . ($_SERVER['SERVER_ADMIN'] ?? 'Nicht gesetzt') . "<br>";

// Test 6: Error Log prüfen
echo "<h3>6. Letzte PHP Fehler:</h3>";
$errors = error_get_last();
if ($errors) {
    echo "Letzter Fehler: " . $errors['message'] . "<br>";
    echo "Datei: " . $errors['file'] . "<br>";
    echo "Zeile: " . $errors['line'] . "<br>";
} else {
    echo "Keine aktuellen PHP Fehler.<br>";
}

echo "<hr>";
echo "<h3>🎯 LÖSUNG:</h3>";
echo "<p><strong>Falls mail() TRUE zurückgibt aber keine E-Mails ankommen:</strong></p>";
echo "<ul>";
echo "<li>Easyname blockiert ausgehende E-Mails</li>";
echo "<li>Verwende <strong>externe E-Mail-Services</strong> statt PHP mail()</li>";
echo "<li>Beispiele: SendGrid, Mailgun, EmailJS</li>";
echo "</ul>";

echo "<br><a href='login.php'>Zurück zum Login</a>";
?>