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
        <p>Registrera dig för att hantera din frisörprofil och dina arbetstider.</p>

        <form method="post">
            <label for="username">Användarnamn</label>
            <input
                type="text"
                id="username"
                name="username"
                autocomplete="username"
                required
            >
               <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                autocomplete="email"
                required
            >

         
            <label for="username">Telefonnummer</label>
            <input
                type="text"
                id="tel"
                name="tel"
                autocomplete="tel"
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

        <button type="button" onclick="window.location.href='index.php'">Registrera</button>
        </form>
        <button type="button" onclick="window.location.href='loggain.php'">Logga in</button>
    </main>
</body>
</html>