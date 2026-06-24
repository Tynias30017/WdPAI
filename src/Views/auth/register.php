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
            <a href="/login">Zaloguj się</a>
        </nav>
    </header>

    <main class="auth-wrapper">
        <div class="auth-header">
            <h1>Zarejestruj się</h1>
            <p>Dołącz do społeczności siłaczy i zacznij śledzić swoje postępy już dziś.</p>
        </div>

        <div class="card">
            <form action="/register" method="POST">
                <div>
                    <label for="email">Adres E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="nazwa@domena.pl" required>
                </div>
                
                <div>
                    <label for="password">Hasło:</label>
                    <input type="password" id="password" name="password" placeholder="Min. 6 znaków" required>
                </div>
                
                <button type="submit" style="width: 100%; margin-top: 1rem;">Zarejestruj profil zawodnika</button>
            </form>
            
            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.85rem; color: var(--text-muted);">
                Masz już konto? <a href="/login" style="font-weight: bold;">Zaloguj się</a>
            </p>
        </div>
    </main>

</body>
</html>