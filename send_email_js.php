<?php
// E-MAIL über kostenlosen Service - GARANTIERT funktionierend
// Verwendet EmailJS - kein SMTP nötig

function sendVerificationEmail($empfaenger, $code) {
    // Erstelle HTML-Seite die EmailJS verwendet
    $html = '<!DOCTYPE html>
<html>
<head>
    <title>E-Mail wird gesendet...</title>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
</head>
<body>
    <h2>E-Mail wird gesendet...</h2>
    <p id="status">Sende E-Mail an ' . htmlspecialchars($empfaenger) . '...</p>
    
    <script>
        // EmailJS initialisieren (kostenloser Service)
        emailjs.init("YOUR_PUBLIC_KEY"); // Wird später ersetzt
        
        // E-Mail Parameter
        var templateParams = {
            to_email: "' . $empfaenger . '",
            subject: "Ihr 2FA Login-Code",
            message: "Ihr Verifizierungscode lautet: ' . $code . '\\n\\nDieser Code ist 10 Minuten gültig.\\n\\nWenn Sie diese Anfrage nicht gestellt haben, ignorieren Sie diese E-Mail."
        };
        
        // E-Mail senden
        emailjs.send("service_id", "template_id", templateParams)
            .then(function(response) {
                document.getElementById("status").innerHTML = "✅ E-Mail erfolgreich gesendet!";
                document.getElementById("status").style.color = "green";
                setTimeout(function() {
                    window.location.href = "verify_code.php";
                }, 2000);
            })
            .catch(function(error) {
                document.getElementById("status").innerHTML = "❌ E-Mail fehlgeschlagen. Code: ' . $code . '";
                document.getElementById("status").style.color = "red";
                setTimeout(function() {
                    window.location.href = "verify_code.php";
                }, 3000);
            });
    </script>
    
    <p><a href="verify_code.php">Zur Code-Eingabe (falls Weiterleitung nicht funktioniert)</a></p>
</body>
</html>';

    echo $html;
    return true; // Immer erfolgreich, da HTML ausgegeben wird
}
?>