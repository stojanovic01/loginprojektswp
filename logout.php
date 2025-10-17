<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abgemeldet</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Erfolgreich abgemeldet</h2>
    <p>Sie wurden erfolgreich abgemeldet.</p>
    <p><a href="index.html">Zur Startseite</a></p>
    <p><a href="login.php">Erneut anmelden</a></p>
</body>
</html>
