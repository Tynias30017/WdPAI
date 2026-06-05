<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
</head>
<body>

    <header>
        <h1>Zaloguj się</h1>
        <nav>
            <a href="/">Strona główna</a>
        </nav>
    </header>

    <main>
        <form action="/login" method="POST">
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
            
            <button type="submit">Zaloguj</button>
        </form>
    </main>

</body>
</html>