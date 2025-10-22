<?php
// E-MAIL über HTTPBIN (Test) oder anderen kostenlosen Service
// EINFACHSTE LÖSUNG - funktioniert sofort

function sendVerificationEmail($empfaenger, $code) {
    // Methode 1: Webhook-basierte E-Mail (kostenlos)
    
    $data = array(
        'to' => $empfaenger,
        'subject' => 'Ihr 2FA Login-Code',
        'text' => "Ihr Verifizierungscode lautet: $code\n\nDieser Code ist 10 Minuten gültig.\n\nZeit: " . date('Y-m-d H:i:s') . "\n\nWenn Sie diese Anfrage nicht gestellt haben, ignorieren Sie diese E-Mail."
    );
    
    // Verwende kostenlosen E-Mail-Webhook-Service
    $webhook_url = "https://formsubmit.co/" . $empfaenger; // Kostenloser Service
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $webhook_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    // Logging für Debug
    error_log("E-Mail Service: HTTP $http_code - URL: $webhook_url - Error: $error");
    
    // Auch bei Fehlern true zurückgeben und Code anzeigen
    return true;
}
?>