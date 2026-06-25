<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= time() ?>">
    <style>
        .profile-card {
            background-color: var(--bg-color);
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary-color);
            border: 1px solid var(--border-color);
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
            font-weight: 600;
        }
        .alert-success {
            background-color: rgba(34, 197, 94, 0.15);
            border: 1px solid var(--success-color);
            color: var(--success-color);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }
        @media (max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- WERSJA MOBILNA: Górny pasek nawigacji -->
    <div class="mobile-nav">
        <a href="/" class="mobile-nav-logo">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18H18M6 12H18M6 6H18"/></svg>
            <span>IronLog</span>
        </a>
        <div class="mobile-nav-links">
            <a href="/">Pulpit</a>
            <a href="/workouts">Treningi</a>
            <a href="/profile" class="active">Profil</a>
            <a href="/analytics">Statystyki</a>
            <a href="/exercises">Katalog</a>
            <a href="/logout">Wyloguj</a>
        </div>
    </div>

    <!-- UKŁAD DESKTOP: Siatka z panelem bocznym (Sidebar) -->
    <div class="app-layout">
        
        <!-- LEWY PANEL (Sidebar) -->
        <aside class="sidebar">
            <a href="/" class="sidebar-logo">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18H18M6 12H18M6 6H18"/></svg>
                <span>IronLog</span>
            </a>
            <ul class="sidebar-menu">
                <li>
                    <a href="/">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
                        Pulpit
                    </a>
                </li>
                <li>
                    <a href="/workouts">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9M3 20h4M3 12h18M3 4h18"/></svg>
                        Treningi
                    </a>
                </li>
                <li>
                    <a href="/profile" class="active">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Mój Profil
                    </a>
                </li>
                <li>
                    <a href="/analytics">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        Statystyki & Analizy
                    </a>
                </li>
                <li>
                    <a href="/exercises">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        Baza Ćwiczeń
                    </a>
                </li>
                <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
                    <li>
                        <a href="/admin/users" style="color: #facc15;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            Panel Admina
                        </a>
                    </li>
                <?php endif; ?>
                <li style="margin-top: auto;">
                    <a href="/logout" style="color: #ef4444;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                        Wyloguj się
                    </a>
                </li>
            </ul>
        </aside>

        <!-- PRAWY PANEL (Główna zawartość) -->
        <div class="main-content">
            
            <!-- Pasek górny (Top Bar) -->
            <header class="top-bar">
                <div class="user-badge">
                    <span>Zalogowany jako: <strong><?= htmlspecialchars($_SESSION['user_email']) ?></strong> (<?= htmlspecialchars($_SESSION['user_role'] ?? 'user') ?>)</span>
                    <div class="user-avatar"><?= strtoupper(substr($_SESSION['user_email'], 0, 1)) ?></div>
                </div>
            </header>

            <main>
                <h2 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 2rem;">Profil Zawodnika</h2>

                <?php if ($success): ?>
                    <div class="alert-success">Profil zaktualizowany! Wyzwalacz automatycznie przeliczył Twoją oficjalną kategorię wagową.</div>
                <?php endif; ?>

                <div class="card">
                    <h3 style="font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem; margin-bottom: 1.25rem;">
                        Informacje o profilu (1:1)
                    </h3>
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
                            <span class="profile-info-label">Waga ciała:</span>
                            <span><?= htmlspecialchars((string)($profile['body_weight'] ?? 0.0)) ?> kg</span>
                        </div>
                        <div class="profile-info-row" style="border-bottom: none; padding-bottom: 0; margin-bottom: 0;">
                            <span class="profile-info-label">Kategoria Wagowa IPF:</span>
                            <span style="color: var(--primary-color); font-weight: bold; font-size: 1.05rem;">
                                <?= htmlspecialchars($profile['weight_category_name'] ?? 'Brak (ustaw wagę)') ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h3 style="font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem; margin-bottom: 1.25rem;">
                        Edytuj swoje dane
                    </h3>
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
                        
                        <button type="submit" style="margin-top: 0.5rem;">Zapisz profil</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

</body>
</html>
