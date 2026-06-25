<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <!-- v=time() zapobiega cache'owaniu pliku CSS w przeglądarce -->
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= time() ?>">
</head>
<body>

    <!-- WERSJA MOBILNA: Dolny, podążający pasek nawigacji (Toolbar z ikonami) -->
    <?php $currentPath = parse_url($_SERVER['REQUEST_URI'])['path']; ?>
    <div class="mobile-nav">
        <a href="/" class="mobile-nav-item <?= ($currentPath === '/' || $currentPath === '') ? 'active' : '' ?>" title="Pulpit">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
        </a>
        <a href="/workouts" class="mobile-nav-item <?= (str_starts_with($currentPath, '/workouts') || str_starts_with($currentPath, '/workout')) ? 'active' : '' ?>" title="Treningi">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9M3 20h4M3 12h18M3 4h18"/></svg>
        </a>
        <a href="/profile" class="mobile-nav-item <?= ($currentPath === '/profile') ? 'active' : '' ?>" title="Profil">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        </a>
        <a href="/analytics" class="mobile-nav-item <?= ($currentPath === '/analytics') ? 'active' : '' ?>" title="Statystyki">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
        </a>
        <a href="/exercises" class="mobile-nav-item <?= ($currentPath === '/exercises') ? 'active' : '' ?>" title="Baza Ćwiczeń">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
        </a>
        <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
            <a href="/admin/users" class="mobile-nav-item <?= ($currentPath === '/admin/users') ? 'active' : '' ?>" title="Panel Admina" style="color: #facc15;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </a>
        <?php endif; ?>
        <a href="/logout" class="mobile-nav-item" title="Wyloguj" style="color: #ef4444;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
        </a>
    </div>

    <!-- UKŁAD CAŁOŚCIOWY: Siatka z panelem bocznym na desktopie -->
    <div class="app-layout">
        
        <!-- LEWY PANEL (Sidebar - widoczny tylko na komputerach) -->
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
                    <a href="/workouts" class="active">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9M3 20h4M3 12h18M3 4h18"/></svg>
                        Treningi
                    </a>
                </li>
                <li>
                    <a href="/profile">
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
            
            <!-- Górny pasek z małym info o zalogowanym (komputery) -->
            <header class="top-bar">
                <div class="user-badge">
                    <span>Zalogowany jako: <strong><?= htmlspecialchars($_SESSION['user_email']) ?></strong> (<?= htmlspecialchars($_SESSION['user_role'] ?? 'user') ?>)</span>
                    <div class="user-avatar"><?= strtoupper(substr($_SESSION['user_email'], 0, 1)) ?></div>
                </div>
            </header>

            <main>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <h2 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em;">Moje Treningi</h2>
                        <p style="color: var(--text-muted);">Przeglądaj historię i planuj swoje sesje trójbojowe.</p>
                    </div>
                    <a href="/workouts/create" class="btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.25rem;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Rozpocznij Nowy Trening
                    </a>
                </div>

                <!-- Statystyki z widoku SQL -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-label">Całkowita Objętość</div>
                        <div class="stat-value"><?= number_format((float)($stats['total_volume'] ?? 0.0), 1, '.', ' ') ?> kg</div>
                        <div class="stat-desc">Zsumowany ciężar ze wszystkich serii</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-label">Ilość Sesji</div>
                        <div class="stat-value"><?= htmlspecialchars((string)($stats['total_workouts'] ?? 0)) ?></div>
                        <div class="stat-desc">Zapisane treningi w bazie danych</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-label">Max. Ciężar</div>
                        <div class="stat-value"><?= number_format((float)($stats['max_weight_lifted'] ?? 0.0), 1, '.', ' ') ?> kg</div>
                        <div class="stat-desc">Najcięższa podniesiona seria</div>
                    </div>
                </div>

                <!-- Lista treningów -->
                <div class="card">
                    <h2 style="font-size: 1.2rem; margin-bottom: 1.5rem;">Historia Zapisanych Treningów</h2>

                    <?php if (empty($workouts)): ?>
                        <div style="text-align: center; padding: 3.5rem 1rem; color: var(--text-muted);">
                            <p style="margin-bottom: 1.5rem; font-size: 0.95rem;">Nie masz jeszcze zapisanych żadnych sesji treningowych.</p>
                            <a href="/workouts/create" class="btn">Dodaj swój pierwszy trening</a>
                        </div>
                    <?php else: ?>
                        <div class="workout-list">
                            <?php foreach ($workouts as $workout): ?>
                                <div class="workout-item">
                                    <div class="workout-info">
                                        <span class="workout-date">
                                            Sesja z dnia: <?= htmlspecialchars($workout['workout_date']) ?>
                                            <?php if (!empty($workout['name'])): ?>
                                                • <span style="color: var(--primary-color); font-weight: 600;"><?= htmlspecialchars($workout['name']) ?></span>
                                            <?php endif; ?>
                                        </span>
                                        <?php if (!empty($workout['notes'])): ?>
                                            <span class="workout-notes">Notatki: <?= htmlspecialchars($workout['notes']) ?></span>
                                        <?php else: ?>
                                            <span class="workout-notes" style="color: rgba(255,255,255,0.15);">Brak notatek do tego treningu</span>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <a href="/workout?id=<?= $workout['id'] ?>" class="btn btn-secondary btn-sm">Rejestruj Serie</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

</body>
</html>