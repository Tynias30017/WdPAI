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
        <h1>Dziennik Trójboisty</h1>
        <nav>
            <a href="/">Strona Główna</a>
            <a href="/register">Utwórz konto</a>
        </nav>
    </header>

    <main class="auth-wrapper">
        <div class="auth-header">
            <h1>Zaloguj się</h1>
            <p>Witaj z powrotem! Wprowadź swoje dane, aby kontynuować trening.</p>
        </div>

        <div class="card">
            <form action="/login" method="POST">
                <div>
                    <label for="email">Adres E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="nazwa@domena.pl" required>
                </div>
                
                <div>
                    <label for="password">Hasło:</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                
                <button type="submit" style="width: 100%; margin-top: 1rem;">Zaloguj się</button>
            </form>
            
            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.85rem; color: var(--text-muted);">
                Nie masz jeszcze konta? <a href="/register" style="font-weight: bold;">Zarejestruj się</a>
            </p>
        </div>
    </main>

</body>
</html>