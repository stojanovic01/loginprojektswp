<?php
session_start();

// Prüfen ob Benutzer vom verify_code.php kommt
if (!isset($_SESSION['email']) || !isset($_SESSION['2fa_code'])) {
    header("Location: login.php");
    exit();
}

// Prüfen ob Code abgelaufen ist (2 Minuten)
if (time() - $_SESSION['2fa_time'] > 120) {
    session_destroy();
    echo "Der Code ist abgelaufen. Bitte melden Sie sich erneut an.<br>";
    echo '<a href="login.php">Zurück zum Login</a>';
    exit();
}

$eingabe_code = $_POST['code'];
$gespeicherter_code = $_SESSION['2fa_code'];

if ($eingabe_code === $gespeicherter_code) {
    // Code korrekt - Login erfolgreich
    $_SESSION['logged_in'] = true;
    $_SESSION['user_email'] = $_SESSION['email'];
    
    // 2FA Daten aus Session entfernen
    unset($_SESSION['2fa_code']);
    unset($_SESSION['2fa_time']);
    
    // Weiterleitung zum geschützten Bereich
    header("Location: dashboard.php");
    exit();
} else {
    // Code falsch
    echo "<!DOCTYPE html>
    <html lang='de'>
    <head>
        <meta charset='UTF-8'>
        <title>Fehler</title>
        <link rel='stylesheet' href='style.css'>
    </head>
    <body>
        <h2>Verifizierung fehlgeschlagen</h2>
        <p style='color: red;'>Der eingegebene Code ist falsch.</p>
        <p><a href='verify_code.php'>Erneut versuchen</a></p>
        <p><a href='login.php'>Zurück zum Login</a></p>
    </body>
    </html>";
}
?>
