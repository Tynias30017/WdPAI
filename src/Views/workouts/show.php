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
        <h1>Trening z dnia: <?= htmlspecialchars($workout['workout_date']) ?></h1>
        <nav>
            <a href="/workouts">Wróć do listy treningów</a>
        </nav>
    </header>

    <main>
        <?php if (!empty($workout['notes'])): ?>
            <p><strong>Notatki:</strong> <?= nl2br(htmlspecialchars($workout['notes'])) ?></p>
        <?php endif; ?>

        <h2>Wykonane serie</h2>
        
        <?php if (empty($sets)): ?>
            <p>Brak zapisanych serii na tym treningu.</p>
        <?php else: ?>
            <table border="1" cellpadding="5" cellspacing="0" style="margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th>Ćwiczenie</th>
                        <th>Ciężar (kg)</th>
                        <th>Powtórzenia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sets as $set): ?>
                        <tr>
                            <td><?= htmlspecialchars($set['exercise_name']) ?></td>
                            <td><?= htmlspecialchars((string)$set['weight']) ?></td>
                            <td><?= htmlspecialchars((string)$set['reps']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <h3>Dodaj nową serię</h3>
        <form action="/workout/add-set" method="POST">
            <!-- Ukryte pole przesyłające ID treningu -->
            <input type="hidden" name="workout_id" value="<?= $workout['id'] ?>">
            
            <div>
                <label for="exercise_id">Ćwiczenie:</label>
                <select id="exercise_id" name="exercise_id" required>
                    <?php foreach ($exercises as $exercise): ?>
                        <option value="<?= $exercise['id'] ?>">
                            <?= htmlspecialchars($exercise['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>
            
            <div>
                <label for="weight">Ciężar (kg):</label>
                <input type="number" step="0.5" id="weight" name="weight" required>
            </div>
            <br>
            
            <div>
                <label for="reps">Powtórzenia:</label>
                <input type="number" id="reps" name="reps" required>
            </div>
            <br>
            
            <button type="submit">Zapisz serię</button>
        </form>
    </main>

</body>
</html>