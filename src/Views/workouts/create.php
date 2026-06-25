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
        <h1>Nowy Trening</h1>
        <nav>
            <p>Zalogowany jako: <strong><?= htmlspecialchars($_SESSION['user_email']) ?></strong></p>
            <a href="/">Strona Główna</a>
            <a href="/profile">Mój Profil</a>
            <a href="/workouts" class="active">Treningi</a>
            <a href="/logout">Wyloguj się</a>
        </nav>
    </header>

    <main class="auth-wrapper" style="max-width: 500px; margin-top: 3rem;">
        <div class="auth-header" style="margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.5rem;">Dodaj Nowy Trening</h1>
            <p>Zarejestruj nową sesję w swoim dzienniku treningowym.</p>
        </div>

        <div class="card">
            <form action="/workouts/create" method="POST">
                <div>
                    <label for="workout_date">Data sesji treningowej:</label>
                    <input type="date" id="workout_date" name="workout_date" value="<?= date('Y-m-d') ?>" required>
                </div>
                
                <div>
                    <label for="workout_name">Nazwa treningu (opcjonalnie):</label>
                    <input type="text" id="workout_name" name="workout_name" placeholder="np. Wyciskanie - Siła / Dół - Hipertrofia">
                </div>
                
                <div>
                    <label for="notes">Notatki / Samopoczucie (opcjonalnie):</label>
                    <textarea id="notes" name="notes" rows="4" placeholder="np. Trening nóg. Czułem się silny, świetna dynamika w przysiadach..."></textarea>
                </div>
                
                <div style="display: flex; gap: 0.75rem; margin-top: 1rem; margin-bottom: 0;">
                    <a href="/workouts" class="btn btn-secondary" style="flex: 1;">Anuluj</a>
                    <button type="submit" style="flex: 1.5;">Utwórz Trening</button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>