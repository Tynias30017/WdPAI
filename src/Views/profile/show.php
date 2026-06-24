<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .profile-card {
            background-color: var(--bg-color);
            padding: 2rem;
            border-radius: 6px;
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary-color);
        }
        .profile-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.5rem;
        }
        .profile-info-label {
            color: var(--text-muted);
            font-weight: bold;
        }
        .alert-success {
            background-color: #2e7d32;
            color: white;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            font-weight: bold;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        @media (max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>Dziennik Trójboisty - Mój Profil</h1>
        <nav>
            <a href="/">Strona Główna</a> |
            <a href="/workouts">Moje Treningi</a> |
            <a href="/logout">Wyloguj się</a>
        </nav>
    </header>

    <main>
        <?php if ($success): ?>
            <div class="alert-success">Profil został pomyślnie zaktualizowany! Wyzwalacz bazy danych automatycznie przeliczył Twoją kategorię wagową.</div>
        <?php endif; ?>

        <h2>Dane Profilu (Relacja 1:1)</h2>
        <div class="profile-card">
            <div class="profile-info-row">
                <span class="profile-info-label">Imię i Nazwisko:</span>
                <span><?= htmlspecialchars(($profile['first_name'] ?? '') . ' ' . ($profile['last_name'] ?? '')) ?: 'Brak danych' ?></span>
            </div>
            <div class="profile-info-row">
                <span class="profile-info-label">Płeć:</span>
                <span><?= ($profile['gender'] ?? '') === 'male' ? 'Mężczyzna' : 'Kobieta' ?></span>
            </div>
            <div class="profile-info-row">
                <span class="profile-info-label">Aktualna Waga:</span>
                <span><?= htmlspecialchars((string)($profile['body_weight'] ?? 0.0)) ?> kg</span>
            </div>
            <div class="profile-info-row">
                <span class="profile-info-label">Kategoria Wagowa (Automatycznie z wyzwalacza):</span>
                <span style="color: var(--primary-color); font-weight: bold;">
                    <?= htmlspecialchars($profile['weight_category_name'] ?? 'Brak (ustaw wagę)') ?>
                </span>
            </div>
        </div>

        <h2>Edytuj dane profilu</h2>
        <form action="/profile" method="POST">
            <div class="form-grid">
                <div>
                    <label for="first_name">Imię:</label>
                    <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($profile['first_name'] ?? '') ?>" required>
                </div>
                
                <div>
                    <label for="last_name">Nazwisko:</label>
                    <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($profile['last_name'] ?? '') ?>" required>
                </div>
            </div>
            <br>
            
            <div class="form-grid">
                <div>
                    <label for="gender">Płeć:</label>
                    <select id="gender" name="gender" required>
                        <option value="male" <?= ($profile['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Mężczyzna</option>
                        <option value="female" <?= ($profile['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Kobieta</option>
                    </select>
                </div>
                
                <div>
                    <label for="body_weight">Waga ciała (kg):</label>
                    <input type="number" step="0.1" id="body_weight" name="body_weight" value="<?= htmlspecialchars((string)($profile['body_weight'] ?? 0.0)) ?>" required>
                </div>
            </div>
            <br>
            
            <button type="submit">Zapisz Zmiany</button>
        </form>
    </main>

</body>
</html>
