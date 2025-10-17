<?php
session_start();

// Prüfen ob Benutzer eingeloggt ist
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Willkommen im geschützten Bereich!</h2>
    <p>Sie sind erfolgreich eingeloggt als: <strong><?php echo htmlspecialchars($_SESSION['user_email']); ?></strong></p>
    
    <p>Dies ist Ihr Dashboard. Hier können Sie geschützte Inhalte sehen.</p>
    
    <p><a href="logout.php">Ausloggen</a></p>
</body>
</html>
