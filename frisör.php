<?php
session_start();
$username = $_SESSION['username'] ?? '';
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Din frisörsida</title>
</head>
<body>
    <h1>Hej, välkommen till din frisör sida<?= $username !== '' ? ' ' . htmlspecialchars($username, ENT_QUOTES, 'UTF-8') : '' ?>!</h1>
</body>
</html>