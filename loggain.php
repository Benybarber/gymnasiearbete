<?php
require_once __DIR__ . '/assets/functions.php';
session_start();

$error = false;

if (isset($_POST['submit'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $frisor = loggain($email, $password);
    if ($frisor) {
        $_SESSION['frisor_id'] = $frisor['frisor_id'];
        $_SESSION['username'] = $frisor['email'];
        $_SESSION['name'] = $frisor['name'];
        $_SESSION['email'] = $frisor['email'];
        header('Location: frisör.php');
        exit();
    }
    $error = true;
}
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logga in | Frisörprofil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main class="login">
        <h1>Logga in</h1>
        <p>Logga in för att hantera din frisörprofil och dina arbetstider.</p>

        <?php if ($error): ?>
            <p role="alert">Fel användarnamn eller lösenord. Försök igen.</p>
        <?php endif; ?>

        <form method="post" action="">
            <label for="email">E-postadress</label>
            <input type="email" id="email" name="email" autocomplete="username" required>

            <label for="password">Lösenord</label>
            <input type="password" id="password" name="password" autocomplete="current-password" required>

            <button type="submit" name="submit">Logga in</button>
        </form>
        <p><a href="registrera.php">Har du inte ett konto? Registrera dig</a></p>
    </main>
</body>
</html>
