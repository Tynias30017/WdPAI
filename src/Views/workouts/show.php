<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= time() ?>">
    <style>
        .timer-btn {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-color);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.2s;
        }
        .timer-btn:hover {
            border-color: var(--primary-color);
            background-color: rgba(239, 68, 68, 0.1);
        }
        .form-row {
            display: grid;
            grid-template-columns: 2fr 1.2fr 1.2fr 1.2fr 1.8fr auto;
            gap: 0.75rem;
            align-items: end;
        }
        @media (max-width: 992px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- WERSJA MOBILNA: Górny pasek nawigacji (komórki) -->
    <div class="mobile-nav">
        <a href="/" class="mobile-nav-logo">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18H18M6 12H18M6 6H18"/></svg>
            <span>IronLog</span>
        </a>
        <div class="mobile-nav-links">
            <a href="/">Pulpit</a>
            <a href="/workouts" class="active">Treningi</a>
            <a href="/profile">Profil</a>
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
            
            <!-- Pasek górny (Top Bar) -->
            <header class="top-bar">
                <div class="user-badge">
                    <span>Zalogowany jako: <strong><?= htmlspecialchars($_SESSION['user_email']) ?></strong> (<?= htmlspecialchars($_SESSION['user_role'] ?? 'user') ?>)</span>
                    <div class="user-avatar"><?= strtoupper(substr($_SESSION['user_email'], 0, 1)) ?></div>
                </div>
            </header>

            <main>
                <!-- Siatka treningowa: po lewej stoper/szczegóły, po prawej lista serii -->
                <div class="workout-container">
                    
                    <!-- Kolumna 1: Panel boczny sesji (Rest Timer i Notatki) -->
                    <div class="workout-sidebar">
                        
                        <!-- Rest Timer -->
                        <div class="rest-timer-box">
                            <div class="rest-timer-title">Rest Timer</div>
                            <div class="rest-timer-value" id="timer-display">01:30</div>
                            <div class="rest-timer-controls">
                                <button class="timer-btn" id="timer-minus">-30s</button>
                                <button class="timer-btn" id="timer-play-pause" style="width: auto; padding: 0 0.75rem; border-radius: 6px;">Start</button>
                                <button class="timer-btn" id="timer-plus">+30s</button>
                            </div>
                        </div>

                        <!-- Dane treningu -->
                        <div class="card">
                            <h3 style="font-size: 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem; margin-bottom: 0.75rem;">Szczegóły Sesji</h3>
                            <div style="font-size: 0.9rem; display: flex; flex-direction: column; gap: 0.5rem;">
                                <div><strong style="color: var(--text-muted);">Data:</strong> <?= htmlspecialchars($workout['workout_date']) ?></div>
                                <?php if (!empty($workout['notes'])): ?>
                                    <div>
                                        <strong style="color: var(--text-muted);">Notatki:</strong>
                                        <p style="font-size: 0.85rem; font-style: italic; color: var(--text-muted); margin-top: 0.25rem;">
                                            <?= nl2br(htmlspecialchars($workout['notes'])) ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <a href="/workouts" class="btn btn-secondary" style="width: 100%;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.25rem;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            Wróć do treningów
                        </a>
                    </div>

                    <!-- Kolumna 2: Rejestracja i Tabela serii -->
                    <div class="card" style="margin-bottom: 0;">
                        <h2 style="font-size: 1.25rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem; margin-bottom: 1.5rem;">
                            Wykonane Serie w tym Treningu
                        </h2>
                        
                        <div id="no-sets-message" style="display: <?= empty($sets) ? 'block' : 'none' ?>; text-align: center; padding: 3rem 1rem; color: var(--text-muted);">
                            Brak zarejestrowanych serii. Użyj poniższego formularza, aby dodać swoją pierwszą serię!
                        </div>
                 
                        <table id="sets-table" style="display: <?= empty($sets) ? 'none' : 'table' ?>; margin-bottom: 2rem;">
                            <thead>
                                <tr>
                                    <th>Ćwiczenie</th>
                                    <th>Ciężar</th>
                                    <th>Powtórzenia</th>
                                    <th style="text-align: center;">RPE</th>
                                    <th style="text-align: center;">Typ Serii</th>
                                    <th style="width: 80px; text-align: center;">Akcja</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sets as $set): ?>
                                    <tr id="set-row-<?= $set['id'] ?>">
                                        <td><strong style="color: var(--text-color);"><?= htmlspecialchars($set['exercise_name']) ?></strong></td>
                                        <td><span class="badge badge-primary"><?= htmlspecialchars((string)($set['weight'] ?? 0.0)) ?> kg</span></td>
                                        <td><strong><?= htmlspecialchars((string)($set['reps'] ?? 0)) ?></strong> powtórzeń</td>
                                        <td style="text-align: center;">
                                            <span class="badge" style="background-color: rgba(245, 158, 11, 0.15); color: var(--warning-color); font-weight: bold;">
                                                <?= $set['rpe'] ? htmlspecialchars(number_format((float)$set['rpe'], 1)) : '-' ?>
                                            </span>
                                        </td>
                                        <td style="text-align: center;">
                                            <span class="badge <?= $set['set_type'] === 'pr' ? 'badge-success' : '' ?>">
                                                <?= $set['set_type'] === 'warmup' ? 'Rozgrzewka' : ($set['set_type'] === 'backoff' ? 'Zrzutka' : ($set['set_type'] === 'pr' ? '🏆 Rekord' : 'Normalna')) ?>
                                            </span>
                                        </td>
                                        <td style="text-align: center;">
                                            <button class="btn-delete-set btn-danger btn-sm" data-id="<?= $set['id'] ?>" style="background-color: #d32f2f;">Usuń</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                 
                        <h3 style="font-size: 1.05rem; margin-top: 2rem; margin-bottom: 1rem;">Dodaj nową serię (Asynchronicznie)</h3>
                        <form id="add-set-form">
                            <input type="hidden" name="workout_id" value="<?= $workout['id'] ?>">
                            
                            <div class="form-row">
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
                                
                                <div>
                                    <label for="weight">Ciężar (kg):</label>
                                    <input type="number" step="0.5" id="weight" name="weight" placeholder="np. 100" required>
                                </div>
                                
                                <div>
                                    <label for="reps">Powtórzenia:</label>
                                    <input type="number" id="reps" name="reps" placeholder="np. 8" required>
                                </div>

                                <div>
                                    <label for="rpe">RPE (1-10):</label>
                                    <input type="number" step="0.5" min="1" max="10" id="rpe" name="rpe" placeholder="Brak">
                                </div>

                                <div>
                                    <label for="set_type">Typ serii:</label>
                                    <select id="set_type" name="set_type" required>
                                        <option value="normal" selected>Normalna</option>
                                        <option value="warmup">Rozgrzewkowa</option>
                                        <option value="backoff">Zrzucana (Back-off)</option>
                                        <option value="pr">Rekord (PR)</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn" style="height: 42px;">Dodaj Serię</button>
                            </div>

                            <!-- Podgląd ostatniego treningu w locie -->
                            <div id="last-workout-preview" style="display: none; margin-top: 1rem; padding: 0.75rem 1rem; background-color: rgba(255,255,255,0.02); border: 1px dashed var(--border-color); border-radius: 8px; font-size: 0.85rem; color: var(--text-muted);">
                                <!-- Będzie ładowane dynamicznie przez JS -->
                            </div>
                        </form>
                    </div>

                </div>
            </main>

        </div>
    </div>

    <!-- SKRYPTY SĄ IDENTYCZNE JAK WCZEŚNIEJ, NIE ZMIENIAMY LOGIKI DZIAŁANIA -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('add-set-form');
        const tableBody = document.querySelector('#sets-table tbody');
        const table = document.getElementById('sets-table');
        const noSetsMessage = document.getElementById('no-sets-message');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const workoutId = form.elements['workout_id'].value;
            const exerciseId = form.elements['exercise_id'].value;
            const weight = form.elements['weight'].value;
            const reps = form.elements['reps'].value;
            const rpe = form.elements['rpe'].value;
            const setType = form.elements['set_type'].value;

            try {
                const response = await fetch('/api/workout/add-set', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        workout_id: parseInt(workoutId),
                        exercise_id: parseInt(exerciseId),
                        weight: parseFloat(weight),
                        reps: parseInt(reps),
                        rpe: rpe !== '' ? parseFloat(rpe) : null,
                        set_type: setType
                    })
                });

                if (!response.ok) {
                    const errData = await response.json();
                    alert('Błąd: ' + (errData.error || 'Nieznany błąd'));
                    return;
                }

                const data = await response.json();
                if (data.success) {
                    // Pozostawiamy wartości w polach w celu łatwego dodawania kolejnych identycznych serii (np. 3x5)
                    renderSets(data.sets);
                    resetAndStartTimer();
                    // Odśwież podgląd historii, bo ostatni trening mógł się zmienić
                    fetchLastPerformance();
                }
            } catch (err) {
                console.error(err);
                alert('Wystąpił błąd połączenia podczas dodawania serii.');
            }
        });

        function renderSets(sets) {
            if (!sets || sets.length === 0) {
                table.style.display = 'none';
                noSetsMessage.style.display = 'block';
                return;
            }

            table.style.display = 'table';
            noSetsMessage.style.display = 'none';

            tableBody.innerHTML = '';
            sets.forEach(set => {
                const tr = document.createElement('tr');
                tr.id = `set-row-${set.id}`;
                
                const rpeVal = set.rpe ? parseFloat(set.rpe).toFixed(1) : '-';
                let typeLabel = 'Normalna';
                let typeClass = '';
                if (set.set_type === 'warmup') typeLabel = 'Rozgrzewka';
                if (set.set_type === 'backoff') typeLabel = 'Zrzutka';
                if (set.set_type === 'pr') {
                    typeLabel = '🏆 Rekord';
                    typeClass = 'badge-success';
                }

                tr.innerHTML = `
                    <td><strong style="color: var(--text-color);">${escapeHtml(set.exercise_name)}</strong></td>
                    <td><span class="badge badge-primary">${parseFloat(set.weight)} kg</span></td>
                    <td><strong>${parseInt(set.reps)}</strong> powtórzeń</td>
                    <td style="text-align: center;">
                        <span class="badge" style="background-color: rgba(245, 158, 11, 0.15); color: var(--warning-color); font-weight: bold;">${rpeVal}</span>
                    </td>
                    <td style="text-align: center;">
                        <span class="badge ${typeClass}">${typeLabel}</span>
                    </td>
                    <td style="text-align: center;">
                        <button class="btn-delete-set btn-danger btn-sm" data-id="${set.id}" style="background-color: #d32f2f;">Usuń</button>
                    </td>
                `;
                tableBody.appendChild(tr);
            });

            attachDeleteEvents();
        }

        function attachDeleteEvents() {
            document.querySelectorAll('.btn-delete-set').forEach(button => {
                const newButton = button.cloneNode(true);
                button.parentNode.replaceChild(newButton, button);
                
                newButton.addEventListener('click', async () => {
                    if (!confirm('Czy na pewno chcesz usunąć tę serię?')) {
                        return;
                    }

                    const setId = newButton.getAttribute('data-id');

                    try {
                        const response = await fetch('/api/workout/delete-set', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ set_id: parseInt(setId) })
                        });

                        if (!response.ok) {
                            const errData = await response.json();
                            alert('Błąd: ' + (errData.error || 'Nieznany błąd'));
                            return;
                        }

                        const data = await response.json();
                        if (data.success) {
                            const row = document.getElementById(`set-row-${setId}`);
                            if (row) {
                                row.remove();
                            }
                            if (tableBody.children.length === 0) {
                                table.style.display = 'none';
                                noSetsMessage.style.display = 'block';
                            }
                        }
                    } catch (err) {
                        console.error(err);
                        alert('Wystąpił błąd połączenia podczas usuwania serii.');
                    }
                });
            });
        }

        function escapeHtml(str) {
            return str
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Rest Timer Logic
        let timerSeconds = 90;
        let timerInterval = null;

        const timerDisplay = document.getElementById('timer-display');
        const timerPlayPause = document.getElementById('timer-play-pause');
        const timerMinus = document.getElementById('timer-minus');
        const timerPlus = document.getElementById('timer-plus');

        function updateTimerDisplay() {
            const minutes = Math.floor(timerSeconds / 60);
            const seconds = timerSeconds % 60;
            timerDisplay.textContent = 
                `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        function resetAndStartTimer() {
            clearInterval(timerInterval);
            timerSeconds = 90;
            updateTimerDisplay();
            startTimer();
        }

        function startTimer() {
            timerPlayPause.textContent = 'Pauza';
            timerPlayPause.style.borderColor = 'var(--primary-color)';
            timerPlayPause.style.color = 'var(--primary-color)';
            
            timerInterval = setInterval(() => {
                if (timerSeconds > 0) {
                    timerSeconds--;
                    updateTimerDisplay();
                } else {
                    clearInterval(timerInterval);
                    timerPlayPause.textContent = 'Start';
                    timerPlayPause.style.borderColor = 'var(--border-color)';
                    timerPlayPause.style.color = 'var(--text-color)';
                    
                    try {
                        const context = new (window.AudioContext || window.webkitAudioContext)();
                        const oscillator = context.createOscillator();
                        oscillator.type = 'sine';
                        oscillator.frequency.setValueAtTime(880, context.currentTime);
                        oscillator.connect(context.destination);
                        oscillator.start();
                        oscillator.stop(context.currentTime + 0.3);
                    } catch(e) {}
                    
                    alert('Czas przerwy minął! Czas na kolejną serię!');
                }
            }, 1000);
        }

        function pauseTimer() {
            clearInterval(timerInterval);
            timerInterval = null;
            timerPlayPause.textContent = 'Start';
            timerPlayPause.style.borderColor = 'var(--border-color)';
            timerPlayPause.style.color = 'var(--text-color)';
        }

        timerPlayPause.addEventListener('click', () => {
            if (timerInterval) {
                pauseTimer();
            } else {
                startTimer();
            }
        });

        timerMinus.addEventListener('click', () => {
            if (timerSeconds > 30) {
                timerSeconds -= 30;
                updateTimerDisplay();
            }
        });

        timerPlus.addEventListener('click', () => {
            timerSeconds += 30;
            updateTimerDisplay();
        });

        // === LOGIKA HISTORII W LOCIE ===
        const exerciseSelect = document.getElementById('exercise_id');
        const lastWorkoutPreview = document.getElementById('last-workout-preview');

        async function fetchLastPerformance(autofill = false) {
            const exerciseId = exerciseSelect.value;
            const workoutId = form.elements['workout_id'].value;
            
            if (!exerciseId) {
                lastWorkoutPreview.style.display = 'none';
                return;
            }

            try {
                const response = await fetch(`/api/exercise/last-workout?exercise_id=${exerciseId}&workout_id=${workoutId}`);
                if (response.ok) {
                    const data = await response.json();
                    if (data.success && data.sets && data.sets.length > 0) {
                        const date = data.sets[0].workout_date;
                        let setsHtml = `<strong>Poprzedni trening (${date}):</strong> `;
                        const setsDesc = data.sets.map((set, idx) => {
                            let typeSymbol = '';
                            if (set.set_type === 'warmup') typeSymbol = ' (Rozgrz.)';
                            if (set.set_type === 'backoff') typeSymbol = ' (Zrz.)';
                            if (set.set_type === 'pr') typeSymbol = ' (🏆 PR)';
                            const rpeText = set.rpe ? ` @ RPE ${parseFloat(set.rpe)}` : '';
                            return `${idx + 1}. ${parseFloat(set.weight)}kg x ${parseInt(set.reps)}${rpeText}${typeSymbol}`;
                        }).join(', ');
                        lastWorkoutPreview.innerHTML = setsHtml + setsDesc;
                        lastWorkoutPreview.style.display = 'block';

                        // Automatyczne uzupełnienie pól na podstawie ostatniej serii z poprzedniego treningu
                        if (autofill) {
                            const lastSet = data.sets[data.sets.length - 1];
                            if (lastSet) {
                                form.elements['weight'].value = parseFloat(lastSet.weight);
                                form.elements['reps'].value = parseInt(lastSet.reps);
                                form.elements['rpe'].value = lastSet.rpe ? parseFloat(lastSet.rpe) : '';
                                form.elements['set_type'].value = lastSet.set_type || 'normal';
                            }
                        }
                    } else {
                        lastWorkoutPreview.innerHTML = '<strong>Poprzedni trening:</strong> Brak danych dla tego ćwiczenia.';
                        lastWorkoutPreview.style.display = 'block';

                        if (autofill) {
                            // Czyszczenie pól, jeśli brak historii dla danego ćwiczenia
                            form.elements['weight'].value = '';
                            form.elements['reps'].value = '';
                            form.elements['rpe'].value = '';
                            form.elements['set_type'].value = 'normal';
                        }
                    }
                } else {
                    lastWorkoutPreview.style.display = 'none';
                }
            } catch (err) {
                console.error(err);
                lastWorkoutPreview.style.display = 'none';
            }
        }

        exerciseSelect.addEventListener('change', () => fetchLastPerformance(true));
        
        // Uruchomienie na starcie z autouzupełnianiem
        fetchLastPerformance(true);

        attachDeleteEvents();
    });
    </script>
</body>
</html>