<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
</head>
<body>

    <header>
        <h1>Moje Treningi</h1>
        <nav>
            <a href="/">Strona główna</a> |
            <a href="/workouts/create">Dodaj nowy trening</a>
        </nav>
    </header>

    <main>
        <?php if (empty($workouts)): ?>
            <p>Nie masz jeszcze zapisanych żadnych treningów. Czas ruszyć na siłownię!</p>
        <?php else: ?>
            <ul>
                <?php foreach ($workouts as $workout): ?>
                    <li>
                        <strong>Data:</strong> <?= htmlspecialchars($workout['workout_date']) ?>
                        <br>
                        <?php if (!empty($workout['notes'])): ?>
                            <em>Notatki: <?= nl2br(htmlspecialchars($workout['notes'])) ?></em>
                            <br>
                        <?php endif; ?>
                        <a href="/workout?id=<?= $workout['id'] ?>">Szczegóły / Dodaj serię</a>
                    </li>
                    <br>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </main>

</body>
</html>