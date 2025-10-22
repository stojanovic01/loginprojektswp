<?php
// EINFACHE E-MAIL FUNKTION - Native PHP mail()
// Funktioniert meist sofort bei Hosting-Providern wie Easyname

function sendVerificationEmail($empfaenger, $code) {
    $betreff = "Ihr 2FA Login-Code";
    $nachricht = "Ihr Verifizierungscode lautet: " . $code . "\n\n";
    $nachricht .= "Dieser Code ist 10 Minuten gültig.\n\n"; 
    $nachricht .= "Zeit: " . date('Y-m-d H:i:s') . "\n\n";
    $nachricht .= "Wenn Sie diese Anfrage nicht gestellt haben, ignorieren Sie diese E-Mail.";
    
    // Verwende die Domain des Servers als Absender
    $server_domain = $_SERVER['HTTP_HOST'] ?? 'sstojanovic.webspace.edudigital.at';
    $absender = "noreply@" . $server_domain;
    
    // Einfache Headers - oft zuverlässiger
    $headers = "From: 2FA System <$absender>\r\n";
    $headers .= "Reply-To: $absender\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    
    // E-Mail senden
    $success = mail($empfaenger, $betreff, $nachricht, $headers);
    
    // Detailliertes Logging
    $log_message = date('Y-m-d H:i:s') . " - E-Mail ";
    $log_message .= $success ? "ERFOLGREICH" : "FEHLGESCHLAGEN";
    $log_message .= " - An: $empfaenger - Code: $code - Absender: $absender";
    error_log($log_message);
    
    return $success;
}
?>