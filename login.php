<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <!-- Hash-Funktionen aus externer Datei laden -->
    <script src="hash.js"></script>
    <script>
    function hashAndSubmit() {
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        if (!username || !password) {
            alert("Bitte Username und Passwort eingeben!");
            return;
        }

        // SHA-256 Hash aus hash.js verwenden
        const hashHex = sha256Hash(password);

        // Hash ins versteckte Feld
        document.getElementById("password_hash").value = hashHex;

        // Passwortfeld leeren
        document.getElementById("password").value = "";

        // Formular absenden
        document.getElementById("loginForm").submit();
    }
    </script>
</head>
<body>
    <h2>Login</h2>
    <form id="loginForm" method="post" action="check_pwd.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Passwort:</label>
        <input type="password" id="password" required><br><br>

        <!-- Hashwert -->
        <input type="hidden" name="password_hash" id="password_hash">
        
        <button type="button" onclick="hashAndSubmit()">Login</button>
    </form>
</body>
</html>