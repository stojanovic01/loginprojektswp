<?php
// PHPMailer Email-Versand Funktion
// Diese Datei verwendet PHPMailer mit Gmail SMTP

function sendVerificationEmail($empfaenger, $code) {
    // PHPMailer verwenden (muss installiert sein)
    // Download von: https://github.com/PHPMailer/PHPMailer
    
    require 'PHPMailer-7.0.0/src/Exception.php';
    require 'PHPMailer-7.0.0/src/PHPMailer.php';
    require 'PHPMailer-7.0.0/src/SMTP.php';
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    $mail = new PHPMailer(true);
    
    try {
        // SMTP Server Einstellungen
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'stasastojanovic09@gmail.com';  // Ihre Gmail-Adresse
        $mail->Password   = 'tnkn ghvr ttbv ncga';              // App-Passwort (nicht normales Passwort!)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';
        
        // Absender und Empfänger
        $mail->setFrom('stasastojanovic09@gmail.com', '2FA Login System');
        $mail->addAddress($empfaenger);
        
        // E-Mail Inhalt
        $mail->isHTML(false);
        $mail->Subject = 'Ihr 2FA Login-Code';
        $mail->Body    = "Ihr Verifizierungscode lautet: " . $code . "\n\nDieser Code ist 10 Minuten gültig.\n\nWenn Sie diese Anfrage nicht gestellt haben, ignorieren Sie diese E-Mail.";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("E-Mail konnte nicht gesendet werden. Fehler: {$mail->ErrorInfo}");
        return false;
    }
}
?>
