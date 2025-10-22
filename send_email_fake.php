<?php
// TEMPORÄRE E-MAIL FUNKTION - IMMER ERFOLGREICH
// Sendet keine echte E-Mail, gibt aber true zurück

function sendVerificationEmail($empfaenger, $code) {
    // SIMULATION: Erfolgreiche E-Mail
    error_log("SIMULATION: E-Mail an $empfaenger mit Code $code gesendet");
    return true; // Immer erfolgreich
}
?>