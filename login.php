<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> 
    <script>
    async function hashAndSubmit(event) {
        event.preventDefault();
        const password = document.getElementById("password").value;
        const msgBuffer = new TextEncoder().encode(password);
        const hashBuffer = await crypto.subtle.digest("SHA-256", msgBuffer);
        const hashArray = Array.from(new Uint8Array(hashBuffer));
        const hashHex = hashArray.map(b => b.toString(16).padStart(2, "0")).join("");
        document.getElementById("password_hash").value = hashHex;
        document.getElementById("password").value = "";
        event.target.submit(); // Das Formular absenden
    }
    </script>
</head>
<body>
    <h2>Login</h2>
    <form id="loginForm" method="post" action="check_pwd.php" onsubmit="hashAndSubmit(event)">
        <label for="emailadresse">Email-Adresse:</label>
        <input type="email" name="emailadresse" id="emailadresse" required><br><br>

        <label for="password">Passwort:</label>
        <input type="password" name="password" id="password" required><br><br>

        <!-- hier landet der Hash -->
        <input type="hidden" name="password_hash" id="password_hash">

        <button type="submit">Login</button>
    </form>
</body>
</html>
