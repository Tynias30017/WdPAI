<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= time() ?>">
    <style>
        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .exercise-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .exercise-card {
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            transition: border-color 0.2s;
        }
        .exercise-card:hover {
            border-color: var(--primary-color);
        }
        .exercise-name {
            font-size: 1.05rem;
            font-weight: 700;
        }
        .exercise-meta {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            font-size: 0.75rem;
        }
        .alert-success {
            background-color: rgba(34, 197, 94, 0.15);
            border: 1px solid var(--success-color);
            color: var(--success-color);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        .alert-danger {
            background-color: rgba(239, 68, 68, 0.15);
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 600;
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
            <a href="/profile">Profil</a>
            <a href="/exercises" class="active">Katalog</a>
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
                    <a href="/profile">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Mój Profil
                    </a>
                </li>
                <li>
                    <a href="/exercises" class="active">
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
            
            <header class="top-bar">
                <div class="user-badge">
                    <span>Zalogowany jako: <strong><?= htmlspecialchars($_SESSION['user_email']) ?></strong></span>
                    <div class="user-avatar"><?= strtoupper(substr($_SESSION['user_email'], 0, 1)) ?></div>
                </div>
            </header>

            <main>
                <div style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em;">Baza Ćwiczeń</h2>
                    <p style="color: var(--text-muted);">Przeglądaj wbudowane ruchy trójbojowe oraz dodawaj własne ćwiczenia akcesoryjne.</p>
                </div>

                <?php if ($success): ?>
                    <div class="alert-success">Nowe ćwiczenie zostało pomyślnie zapisane w katalogu!</div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <div class="workout-container">
                    
                    <!-- Lewa strona: dodawanie ćwiczenia -->
                    <div class="workout-sidebar">
                        <div class="card" style="margin-bottom: 0;">
                            <h3 style="font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem; margin-bottom: 1.25rem;">
                                Nowe Ćwiczenie
                            </h3>
                            <form action="/exercises" method="POST">
                                <div>
                                    <label for="name">Nazwa ćwiczenia:</label>
                                    <input type="text" id="name" name="name" placeholder="np. Wyciskanie wąsko" required>
                                </div>
                                
                                <div>
                                    <label for="muscle_group">Grupa mięśniowa:</label>
                                    <select id="muscle_group" name="muscle_group" required>
                                        <option value="Klatka piersiowa">Klatka piersiowa</option>
                                        <option value="Plecy">Plecy</option>
                                        <option value="Nogi">Nogi</option>
                                        <option value="Barki">Barki</option>
                                        <option value="Triceps">Triceps</option>
                                        <option value="Biceps">Biceps</option>
                                        <option value="Brzuch">Brzuch / Core</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="equipment_type">Typ sprzętu:</label>
                                    <select id="equipment_type" name="equipment_type" required>
                                        <option value="Sztanga">Sztanga</option>
                                        <option value="Hantle">Hantle</option>
                                        <option value="Wyciąg">Wyciąg</option>
                                        <option value="Maszyna">Maszyna</option>
                                        <option value="Masa ciała">Masa ciała</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="category">Kategoria boju:</label>
                                    <select id="category" name="category" required>
                                        <option value="accessory" selected>Akcesorium (Accessory)</option>
                                        <option value="main">Główny bój (Main lift)</option>
                                        <option value="warmup">Rozgrzewka (Warmup)</option>
                                    </select>
                                </div>
                                
                                <button type="submit" style="width: 100%; margin-top: 0.5rem;">Zapisz w Bazie</button>
                            </form>
                        </div>
                    </div>

                    <!-- Prawa strona: lista i filtry -->
                    <div class="card" style="margin-bottom: 0;">
                        <h3 style="font-size: 1.1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem; margin-bottom: 1.25rem;">
                            Katalog Ćwiczeń
                        </h3>

                        <!-- Proste filtry w JS -->
                        <div class="filter-row">
                            <div>
                                <label for="filter-muscle">Grupa mięśniowa:</label>
                                <select id="filter-muscle">
                                    <option value="all">Wszystkie</option>
                                    <?php foreach ($muscleGroups as $mg): ?>
                                        <option value="<?= htmlspecialchars($mg) ?>"><?= htmlspecialchars($mg) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div>
                                <label for="filter-category">Kategoria:</label>
                                <select id="filter-category">
                                    <option value="all">Wszystkie</option>
                                    <option value="main">Główny bój</option>
                                    <option value="accessory">Akcesorium</option>
                                    <option value="warmup">Rozgrzewka</option>
                                </select>
                            </div>
                        </div>

                        <div class="exercise-grid" id="exercises-list-container">
                            <?php foreach ($exercises as $exercise): ?>
                                <div class="exercise-card" 
                                     data-muscle="<?= htmlspecialchars($exercise['muscle_group'] ?? '') ?>" 
                                     data-category="<?= htmlspecialchars($exercise['category'] ?? 'accessory') ?>">
                                    
                                    <span class="exercise-name"><?= htmlspecialchars($exercise['name']) ?></span>
                                    
                                    <div class="exercise-meta">
                                        <span class="badge badge-primary">
                                            <?= htmlspecialchars($exercise['muscle_group'] ?? 'Brak') ?>
                                        </span>
                                        <span class="badge">
                                            <?= htmlspecialchars($exercise['equipment_type'] ?? 'Inny') ?>
                                        </span>
                                        <span class="badge <?= $exercise['category'] === 'main' ? 'badge-success' : '' ?>">
                                            <?= $exercise['category'] === 'main' ? 'Główny bój' : ($exercise['category'] === 'warmup' ? 'Rozgrzewka' : 'Akcesorium') ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- JS filtrujący w locie dla super płynnego UX -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterMuscle = document.getElementById('filter-muscle');
        const filterCategory = document.getElementById('filter-category');
        const cards = document.querySelectorAll('.exercise-card');

        function applyFilters() {
            const muscleVal = filterMuscle.value;
            const catVal = filterCategory.value;

            cards.forEach(card => {
                const muscleMatch = (muscleVal === 'all' || card.getAttribute('data-muscle') === muscleVal);
                const catMatch = (catVal === 'all' || card.getAttribute('data-category') === catVal);

                if (muscleMatch && catMatch) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        filterMuscle.addEventListener('change', applyFilters);
        filterCategory.addEventListener('change', applyFilters);
    });
    </script>
</body>
</html>
