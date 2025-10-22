<?php
echo "<h2>Einfacher E-Mail Test</h2>";

if ($_POST) {
    $test_email = $_POST['email'];
    $test_code = rand(10000, 99999);
    
    echo "<h3>Teste E-Mail-Versand...</h3>";
    echo "An: " . htmlspecialchars($test_email) . "<br>";
    echo "Code: $test_code<br><br>";
    
    $betreff = "Test E-Mail - " . date('H:i:s');
    $nachricht = "Dies ist ein Test.\n\nDein Code: $test_code\n\nZeit: " . date('Y-m-d H:i:s');
    
    // Verschiedene Absender testen
    $absender_tests = [
        "noreply@sstojanovic.webspace.edudigital.at",
        "test@" . $_SERVER['HTTP_HOST'],
        "noreply@" . $_SERVER['HTTP_HOST'],
        "info@easyname.com" // Fallback
    ];
    
    foreach ($absender_tests as $index => $absender) {
        echo "<h4>Test " . ($index + 1) . " - Absender: $absender</h4>";
        
        $headers = "From: $absender\r\n";
        $headers .= "Reply-To: $absender\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        $success = mail($test_email, $betreff . " (Test " . ($index + 1) . ")", $nachricht, $headers);
        
        if ($success) {
            echo "<span style='color: green;'>✅ mail() gab TRUE zurück</span><br>";
        } else {
            echo "<span style='color: red;'>❌ mail() gab FALSE zurück</span><br>";
        }
    }
    
    echo "<br><p><strong>Prüfe dein E-Mail-Postfach (auch Spam-Ordner!) in den nächsten 5 Minuten.</strong></p>";
    
} else {
    echo "<p>Teste verschiedene E-Mail-Konfigurationen:</p>";
}
?>

<form method="post">
    <label for="email">Deine E-Mail-Adresse:</label><br>
    <input type="email" name="email" value="stasastojanovic09@gmail.com" style="width: 300px;"><br><br>
    <button type="submit">E-Mail Tests senden</button>
</form>

<h3>Häufige Probleme bei Shared Hosting:</h3>
<ul>
    <li><strong>Absender-Domain:</strong> E-Mail muss von deiner Domain kommen</li>
    <li><strong>Spam-Filter:</strong> E-Mails landen im Spam-Ordner</li>
    <li><strong>Rate-Limiting:</strong> Hosting begrenzt E-Mails pro Minute</li>
    <li><strong>SPF/DKIM fehlt:</strong> E-Mail-Authentifizierung nicht konfiguriert</li>
</ul>

<br><a href="login.php">Zurück zum Login</a>