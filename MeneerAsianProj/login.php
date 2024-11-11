<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Inloggen</h1>
</header>

<section class="login">
    <form action="dashboard.php" method="post">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Wachtwoord:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Inloggen</button>
    </form>
</section>

</body>
</html>