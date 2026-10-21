<?php
require_once __DIR__ . '/assets/functions.php';
session_start();

$error = false;

if (isset($_POST['submit'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) && $password !== '' && !frisorEmailExists($email)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $frisorId = addFrisor([
            'name' => $name,
            'email' => $email,
            'password' => $passwordHash
        ]);

        $_SESSION['frisor_id'] = $frisorId;
        $_SESSION['username'] = $email;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        header('Location: frisör.php');
        exit;
    } else {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrera | Frisörprofil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main class="login">
        <h1>Registrera dig</h1>
        <p>Skapa en frisörprofil för att komma igång.</p>

        <?php if ($error): ?>
            <p role="alert">Kontrollera uppgifterna. E-postadressen kan redan vara registrerad.</p>
        <?php endif; ?>

        <form method="post" action="">
            <label for="name">Namn</label>
            <input type="text" id="name" name="name" autocomplete="name" required>

            <label for="email">E-postadress</label>
            <input type="email" id="email" name="email" autocomplete="email" required>

            <label for="password">Lösenord</label>
            <input type="password" id="password" name="password" autocomplete="new-password" required>

            <button type="submit" name="submit">Skapa konto</button>
        </form>
        <p><a href="loggain.php">Har du redan ett konto? Logga in</a></p>
    </main>
</body>
</html>