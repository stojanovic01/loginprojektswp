<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> 

</head>
<body>
    <h2>Login</h2>
    <form method="post" action="check_pwd.php">
        <label for="emailadresse">Email-Adresse:</label>
        <input type="email" name="emailadresse" id="emailadresse" required><br><br>

        <label for="password">Passwort:</label>
        <input type="password" name="password" id="password" required><br><br>

        <button type="submit">Login</button>
    </form>

</body>
</html>
