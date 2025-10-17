<?php
session_start();

// Prüfen ob Benutzer vom Login kommt
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
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Verifizierung</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Zwei-Faktor-Authentifizierung</h2>
    <p>Ein 5-stelliger Verifizierungscode wurde an <strong><?php echo htmlspecialchars($_SESSION['email']); ?></strong> gesendet.</p>
    <p>Bitte geben Sie den Code ein, um sich anzumelden.</p>
    
    <form method="post" action="check_code.php">
        <label for="code">Verifizierungscode:</label>
        <input type="text" name="code" id="code" maxlength="5" pattern="\d{5}" required 
               placeholder="12345" style="font-size: 1.2em; letter-spacing: 0.3em; text-align: center;">
        <br><br>
        <input type="submit" value="Verifizieren">
    </form>
    
    <p><small>Der Code ist 2 Minuten gültig.</small></p>
    <p><a href="login.php">Zurück zum Login</a></p>
</body>
</html>
