<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .hero-section {
            text-align: center;
            padding: 4rem 1rem;
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            margin-bottom: 2.5rem;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), #b71c1c);
        }
        .hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            margin-bottom: 1rem;
            line-height: 1.1;
        }
        .hero-desc {
            color: var(--text-muted);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto 2rem auto;
        }
        .ipf-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .ipf-card {
            background-color: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s;
        }
        .ipf-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }
        .ipf-name {
            font-weight: 700;
            font-size: 1rem;
        }
        .ipf-weight {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <header>
        <h1>Dziennik Trójboisty</h1>
        <nav>
            <?php if (isset($_SESSION['user_id'])): ?>
                <p>Zalogowany jako: <strong><?= htmlspecialchars($_SESSION['user_email']) ?></strong> (<?= htmlspecialchars($_SESSION['user_role'] ?? 'user') ?>)</p>
                <a href="/profile">Mój Profil</a>
                <a href="/workouts">Moje Treningi</a>
                <a href="/analytics">Statystyki</a>
                <a href="/exercises">Baza Ćwiczeń</a>
                <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
                    <a href="/admin/users" style="color: #facc15;">Panel Admina</a>
                <?php endif; ?>
                <a href="/logout">Wyloguj się</a>
            <?php else: ?>
                <a href="/login">Zaloguj się</a>
                <a href="/register" class="active" style="color: white;">Utwórz konto</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="hero-title">Śledź Swoją Siłę. Pobijaj Rekordy.</h1>
            <p class="hero-desc">
                Zapisuj swoje sesje treningowe pod kątem Trójboju Siłowego (Przysiad, Wyciskanie, Martwy Ciąg). Wyliczaj objętość i śledź swój wzrost w oficjalnych kategoriach wagowych IPF.
            </p>
            <div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/workouts" class="btn" style="padding: 0.9rem 2.5rem; font-size: 1rem;">
                        Przejdź do Dziennika Treningowego
                    </a>
                <?php else: ?>
                    <a href="/register" class="btn" style="padding: 0.9rem 2.5rem; font-size: 1rem; margin-right: 1rem;">
                        Zarejestruj się za darmo
                    </a>
                    <a href="/login" class="btn btn-secondary" style="padding: 0.9rem 2.5rem; font-size: 1rem;">
                        Zaloguj się
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Kategorie Wagowe IPF -->
        <div class="card">
            <h2>
                Oficjalne Kategorie Wagowe IPF (Klasyczny Trójbój)
                <span class="badge badge-success">Sezon 2026</span>
            </h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">
                Te kategorie są wykorzystywane przez system do automatycznego klasyfikowania zawodników na podstawie ich wagi ciała podanej w profilu.
            </p>
            
            <div class="ipf-grid">
                <?php foreach ($categories as $category): ?>
                    <div class="ipf-card">
                        <span class="ipf-name"><?= htmlspecialchars($category['name']) ?></span>
                        <span class="ipf-weight">
                            <?= $category['max_weight'] > 900 ? 'Bez limitu' : 'do ' . htmlspecialchars((string)$category['max_weight']) . ' kg' ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

</body>
</html>