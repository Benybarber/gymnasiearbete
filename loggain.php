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

        <form method="post">
            <label for="username">Användarnamn</label>
            <input
                type="text"
                id="username"
                name="username"
                autocomplete="username"
                required
            >

            <label for="password">Lösenord</label>
            <input
                type="password"
                id="password"
                name="password"
                autocomplete="current-password"
                required
            >

        <button type="button" onclick="window.location.href='index.php'">Logga in</button>
        </form>
        <button type="button" onclick="window.location.href='registrera.php'">Registrera dig</button>
    </main>
</body>
</html>