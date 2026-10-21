<?php
require_once __DIR__ . '/assets/sessioncheck.php';
require_once __DIR__ . '/assets/functions.php';

if (!isset($_SESSION['frisor_id'])) {
    header('Location: loggain.php');
    exit();
}

$frisorId = (int)$_SESSION['frisor_id'];
$message = '';
$statement = $forum->prepare(
    'SELECT COALESCE(Namn, \'\') AS name, COALESCE(Email, \'\') AS email, Lösenord AS password
     FROM `Frisör` WHERE Frisörid = :id'
);
$statement->execute([':id' => $frisorId]);
$frisor = $statement->fetch(PDO::FETCH_ASSOC);

if (!$frisor) {
    session_unset();
    session_destroy();
    header('Location: loggain.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $newPassword = $_POST['password'] ?? '';

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Ange ett namn och en giltig e-postadress.';
    } elseif (frisorEmailExists($email, $frisorId)) {
        $message = 'E-postadressen används redan av ett annat konto.';
    } else {
        if ($newPassword !== '') {
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $statement = $forum->prepare(
                'UPDATE `Frisör` SET Namn = :name, Email = :email, Lösenord = :password WHERE Frisörid = :id'
            );
            $statement->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $passwordHash,
                ':id' => $frisorId
            ]);
        } else {
            $statement = $forum->prepare(
                'UPDATE `Frisör` SET Namn = :name, Email = :email WHERE Frisörid = :id'
            );
            $statement->execute([
                ':name' => $name,
                ':email' => $email,
                ':id' => $frisorId
            ]);
        }

        $frisor['name'] = $name;
        $frisor['email'] = $email;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $email;
        $message = 'Profilen har uppdaterats.';
    }
}
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Min frisörprofil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main class="login">
        <h1>Hej, välkommen till din frisörsida <?= htmlspecialchars($frisor['name'], ENT_QUOTES, 'UTF-8') ?>!</h1>
        <p>Hantera dina profiluppgifter här.</p>

        <?php if ($message !== ''): ?>
            <p role="status"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <label for="name">Namn</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($frisor['name'], ENT_QUOTES, 'UTF-8') ?>" required>

            <label for="email">E-postadress (används vid inloggning)</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($frisor['email'], ENT_QUOTES, 'UTF-8') ?>" autocomplete="email" required>

            <label for="password">Nytt lösenord</label>
            <input type="password" id="password" name="password" autocomplete="new-password" placeholder="Lämna tomt för att behålla nuvarande">

            <button type="submit">Spara ändringar</button>
        </form>
    </main>
</body>
</html>
