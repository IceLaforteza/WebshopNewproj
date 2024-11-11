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

<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check credentials (this is a simple example, use hashed passwords in production)
    if ($username === 'admin' && $password === 'password') {
        $_SESSION['loggedin'] = true;
        header("Location: admin/beheer_producten.php");
        exit();
    } else {
        $error = "Ongeldige gebruikersnaam of wachtwoord.";
    }
}
?>

<!-- Display error message if exists -->
<?php if (isset($error)) echo "<p>$error</p>"; ?>

</body>
</html>