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
        <h1>Dziennik Treningowy</h1>
        <nav>
            <p>Zalogowany jako: <strong><?= htmlspecialchars($_SESSION['user_email']) ?></strong></p>
            <a href="/">Strona Główna</a>
            <a href="/profile">Mój Profil</a>
            <a href="/workouts" class="active">Treningi</a>
            <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
                <a href="/admin/users" style="color: #facc15;">Panel Admina</a>
            <?php endif; ?>
            <a href="/logout">Wyloguj się</a>
        </nav>
    </header>

    <main>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em;">Witaj z powrotem, Alex!</h2>
                <p style="color: var(--text-muted);">Gotowy na dzisiejszy trening? Pobijmy dzisiaj jakieś rekordy!</p>
            </div>
            <a href="/workouts/create" class="btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.25rem;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Rozpocznij Nowy Trening
            </a>
        </div>

        <!-- Statystyki z widoku SQL (Wyświetlane na pulpicie) -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Całkowita Objętość</div>
                <div class="stat-value"><?= number_format((float)($stats['total_volume'] ?? 0.0), 1, '.', ' ') ?> kg</div>
                <div class="stat-desc">Suma wszystkich serii</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Ukończone Treningi</div>
                <div class="stat-value"><?= htmlspecialchars((string)($stats['total_workouts'] ?? 0)) ?></div>
                <div class="stat-desc">Zapisane sesje w dzienniku</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Najcięższy Dźwig</div>
                <div class="stat-value"><?= number_format((float)($stats['max_weight_lifted'] ?? 0.0), 1, '.', ' ') ?> kg</div>
                <div class="stat-desc">Twój aktualny rekord</div>
            </div>
        </div>

        <div class="card">
            <h2 style="font-size: 1.25rem; margin-bottom: 1.5rem;">Historia Treningów</h2>

            <?php if (empty($workouts)): ?>
                <div style="text-align: center; padding: 3rem 1rem; color: var(--text-muted);">
                    <p style="margin-bottom: 1.5rem;">Nie masz jeszcze zapisanych żadnych treningów. Czas rozpocząć pierwszą sesję!</p>
                    <a href="/workouts/create" class="btn">Zapisz pierwszy trening</a>
                </div>
            <?php else: ?>
                <div class="workout-list">
                    <?php foreach ($workouts as $workout): ?>
                        <div class="workout-item">
                            <div class="workout-info">
                                <span class="workout-date">Trening z dnia <?= htmlspecialchars($workout['workout_date']) ?></span>
                                <?php if (!empty($workout['notes'])): ?>
                                    <span class="workout-notes">Notatki: <?= htmlspecialchars($workout['notes']) ?></span>
                                <?php else: ?>
                                    <span class="workout-notes" style="color: rgba(255,255,255,0.15);">Brak dodatkowych notatek</span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <a href="/workout?id=<?= $workout['id'] ?>" class="btn btn-secondary btn-sm">Edytuj / Zobacz</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>