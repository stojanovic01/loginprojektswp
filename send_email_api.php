<?php
// E-MAIL über HTTP API - Sehr zuverlässig
// Verwendet einen kostenlosen E-Mail-Service

function sendVerificationEmail($empfaenger, $code) {
    // Verwende einen einfachen HTTP-basierten E-Mail Service
    
    $data = array(
        'to' => $empfaenger,
        'subject' => 'Ihr 2FA Login-Code',
        'message' => "Ihr Verifizierungscode lautet: " . $code . "\n\nDieser Code ist 10 Minuten gültig.\n\nWenn Sie diese Anfrage nicht gestellt haben, ignorieren Sie diese E-Mail."
    );
    
    // Verwende cURL für HTTP-Anfrage an kostenlosen E-Mail-Service
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://formspree.io/f/DEINE_FORM_ID"); // Kostenloses E-Mail-Gateway
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code == 200) {
        return true;
    } else {
        error_log("HTTP E-Mail Service Fehler: HTTP $http_code");
        return false;
    }
}
?>