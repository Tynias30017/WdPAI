<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= time() ?>">
    <style>
        .role-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-admin {
            background-color: rgba(239, 68, 68, 0.15);
            color: var(--primary-color);
        }
        .badge-user {
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--text-muted);
        }
        .action-form {
            display: inline-flex;
            gap: 0.5rem;
            align-items: center;
        }
        .action-form select {
            width: auto;
            padding: 0.35rem 0.5rem;
            font-size: 0.85rem;
        }
    </style>
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
                        <a href="/admin/users" class="active" style="color: #facc15;">
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
                <h2 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em; margin-bottom: 2rem;">Zarządzanie Użytkownikami</h2>

                <div class="card">
                    <h3 style="font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem; margin-bottom: 1.25rem;">
                        Wykaz zarejestrowanych kont
                    </h3>
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem;">
                        Zmiana roli użytkownika następuje natychmiastowo. Usunięcie użytkownika działa kaskadowo w transakcji SQL (usuwa profil 1:1, sesje treningowe 1:N oraz serie N:M).
                    </p>

                    <div style="overflow-x: auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Zawodnik</th>
                                    <th>Kategoria</th>
                                    <th>Rola</th>
                                    <th>Uprawnienia</th>
                                    <th style="width: 80px; text-align: center;">Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td><strong><?= htmlspecialchars($user['email']) ?></strong></td>
                                        <td>
                                            <?= htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?: '<em style="color: var(--text-muted); font-size: 0.85rem;">Nieuzupełniony profil</em>' ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($user['weight_category'] ?? '-') ?>
                                        </td>
                                        <td>
                                            <span class="role-badge <?= $user['role'] === 'admin' ? 'badge-admin' : 'badge-user' ?>">
                                                <?= htmlspecialchars($user['role']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <form action="/admin/users/update-role" method="POST" class="action-form">
                                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                <select name="role" required>
                                                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>user</option>
                                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>admin</option>
                                                </select>
                                                <button type="submit" class="btn-sm">Ustaw</button>
                                            </form>
                                        </td>
                                        <td style="text-align: center;">
                                            <?php if ((int)$user['id'] !== (int)$_SESSION['user_id']): ?>
                                                <form action="/admin/users/delete" method="POST" style="margin: 0; display: inline;" onsubmit="return confirm('Czy na pewno chcesz usunąć użytkownika i wszystkie jego sesje treningowe?');">
                                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                    <button type="submit" class="btn-sm btn-danger">Usuń</button>
                                                </form>
                                            <?php else: ?>
                                                <span style="color: var(--text-muted); font-size: 0.8rem; font-weight: 600;">Ty</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>
