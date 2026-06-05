<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
</head>
<body>

    <header>
        <h1>Dodaj nowy trening</h1>
        <nav>
            <a href="/workouts">Wróć do listy</a>
        </nav>
    </header>

    <main>
        <form action="/workouts/create" method="POST">
            <div>
                <label for="workout_date">Data treningu:</label>
                <input type="date" id="workout_date" name="workout_date" value="<?= date('Y-m-d') ?>" required>
            </div>
            
            <br>
            
            <div>
                <label for="notes">Notatki (opcjonalnie):</label>
                <br>
                <textarea id="notes" name="notes" rows="4" cols="50" placeholder="np. Dobry dzień na przysiady, czułem się silny..."></textarea>
            </div>

            <br>
            
            <button type="submit">Zapisz trening</button>
        </form>
    </main>

</body>
</html>