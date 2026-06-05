<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    <header>
        <h1>Zarejestruj się</h1>
        <nav>
            <a href="/">Strona główna</a>
        </nav>
    </header>

    <main>
        <!-- Formularz wysyła dane metodą POST na ten sam adres (/register) -->
        <form action="/register" method="POST">
            <div>
                <label for="email">Adres E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <br>
            
            <div>
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <br>
            
            <button type="submit">Zarejestruj profil zawodnika</button>
        </form>
    </main>

</body>
</html>