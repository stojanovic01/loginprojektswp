<?php
// PHPMailer Email-Versand Funktion
// Diese Datei verwendet PHPMailer mit Gmail SMTP

function sendVerificationEmail($empfaenger, $code) {
    // SICHERE VERSION - Nie crashen!
    
    try {
        // Prüfe ob PHPMailer Dateien existieren
        if (!file_exists('PHPMailer-7.0.0/src/PHPMailer.php')) {
            error_log("PHPMailer files not found");
            return false;
        }
        
        require 'PHPMailer-7.0.0/src/Exception.php';
        require 'PHPMailer-7.0.0/src/PHPMailer.php';
        require 'PHPMailer-7.0.0/src/SMTP.php';
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        
        $mail = new PHPMailer(false); // Keine Exceptions werfen
    } catch (Exception $e) {
        error_log("PHPMailer loading failed: " . $e->getMessage());
        return false;
    } catch (Error $e) {
        error_log("PHPMailer fatal error: " . $e->getMessage());
        return false;
    }
    
    try {
        // SMTP Server Einstellungen
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'stasastojanovic09@gmail.com';
        $mail->Password   = 'ibkppsdzumdaware';
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
        
        if ($mail->send()) {
            return true;
        } else {
            error_log("E-Mail konnte nicht gesendet werden. Fehler: {$mail->ErrorInfo}");
            return false;
        }
    } catch (Exception $e) {
        error_log("E-Mail Exception: " . $e->getMessage());
        return false;
    }
}
?>
