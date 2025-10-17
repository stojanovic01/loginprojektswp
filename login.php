<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> 
    <script>
    async function hashAndSubmit(event) {
        event.preventDefault(); // Formular nicht sofort senden
        const emailadresse = document.getElementById("emailadresse").value;
        const password = document.getElementById("password").value;

        // SHA-256 Hash mit SubtleCrypto
        const msgBuffer = new TextEncoder().encode(password);
        const hashBuffer = await crypto.subtle.digest("SHA-256", msgBuffer);
        const hashArray = Array.from(new Uint8Array(hashBuffer));
        const hashHex = hashArray.map(b => b.toString(16).padStart(2, "0")).join("");

        // Hashwert in verstecktes Feld eintragen
        document.getElementById("password_hash").value = hashHex;

        // Passwortfeld leeren (zur Sicherheit)
        document.getElementById("password").value = "";

        // Formular absenden
        document.getElementById("loginForm").submit();
    }
    </script>
</head>
<body>
    <h2>Login</h2>
    <form id="loginForm" method="post" action="check_pwd.php" onsubmit="hashAndSubmit(event)">
        <label for="emailadresse">Email-Adresse:</label>
        <input type="emailadresse" name="emailadresse" id="emailadresse" required><br><br>

        <label for="password">Passwort:</label>
        <input type="password" id="password" required><br><br>

        <!-- hier landet der Hash -->
        <input type="hidden" name="password_hash" id="password_hash">

        <input type="submit" value="Login">
    </form>
</body>
</html>
