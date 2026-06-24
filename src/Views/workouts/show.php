<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
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
        .sets-table input {
            text-align: center;
            font-weight: bold;
            width: 80px;
            padding: 0.4rem;
        }
        .form-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 0.75rem;
            align-items: end;
        }
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
 
    <header>
        <h1>Dziennik Treningowy - Edycja</h1>
        <nav>
            <p>Zalogowany jako: <strong><?= htmlspecialchars($_SESSION['user_email']) ?></strong></p>
            <a href="/">Strona Główna</a>
            <a href="/profile">Mój Profil</a>
            <a href="/workouts" class="active">Treningi</a>
            <a href="/logout">Wyloguj się</a>
        </nav>
    </header>
 
    <main>
        <!-- Wykaz z RWD: na desktopie dwukolumnowy, na komórkach jednokolumnowy -->
        <div class="workout-container">
            
            <!-- Lewa kolumna (Pasek boczny na desktopie, na komórkach ląduje na dole/pozycjonowany) -->
            <div class="workout-sidebar">
                
                <!-- LICZNIK PRZERWY (Zrzuty ekranu miały Rest Timer) -->
                <div class="rest-timer-box">
                    <div class="rest-timer-title">Rest Timer</div>
                    <div class="rest-timer-value" id="timer-display">01:30</div>
                    <div class="rest-timer-controls">
                        <button class="timer-btn" id="timer-minus">-30s</button>
                        <button class="timer-btn" id="timer-play-pause" style="width: auto; padding: 0 0.75rem; border-radius: 6px;">Start</button>
                        <button class="timer-btn" id="timer-plus">+30s</button>
                    </div>
                </div>

                <!-- Karta szczegółów treningu -->
                <div class="card">
                    <h3 style="font-size: 1rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem; margin-bottom: 0.75rem;">Szczegóły</h3>
                    <div style="font-size: 0.9rem; display: flex; flex-direction: column; gap: 0.5rem;">
                        <div><strong style="color: var(--text-muted);">Data sesji:</strong> <?= htmlspecialchars($workout['workout_date']) ?></div>
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

            <!-- Prawa kolumna (Główna część: wykaz wykonanych serii i dodawanie nowej) -->
            <div class="card" style="margin-bottom: 0;">
                <h2 style="font-size: 1.25rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.75rem; margin-bottom: 1.5rem;">
                    Zarejestrowane Serie
                </h2>
                
                <div id="no-sets-message" style="display: <?= empty($sets) ? 'block' : 'none' ?>; text-align: center; padding: 2rem; color: var(--text-muted);">
                    Brak wykonanych serii na tym treningu. Wprowadź pierwszą serię poniżej!
                </div>
         
                <table id="sets-table" style="display: <?= empty($sets) ? 'none' : 'table' ?>; margin-bottom: 2rem;">
                    <thead>
                        <tr>
                            <th>Ćwiczenie</th>
                            <th>Ciężar</th>
                            <th>Powtórzenia</th>
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
                                    <button class="btn-delete-set btn-danger btn-sm" data-id="<?= $set['id'] ?>" style="background-color: #d32f2f;">Usuń</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
         
                <h3 style="font-size: 1.1rem; margin-top: 2rem; margin-bottom: 1rem;">Dodaj wykonaną serię</h3>
                <form id="add-set-form">
                    <!-- Ukryte pole przesyłające ID treningu -->
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
                        
                        <button type="submit" class="btn" style="height: 42px;">Dodaj Serię</button>
                    </div>
                </form>
            </div>

        </div>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('add-set-form');
        const tableBody = document.querySelector('#sets-table tbody');
        const table = document.getElementById('sets-table');
        const noSetsMessage = document.getElementById('no-sets-message');

        // Obsługa asynchronicznego dodawania serii przez Fetch API
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const workoutId = form.elements['workout_id'].value;
            const exerciseId = form.elements['exercise_id'].value;
            const weight = form.elements['weight'].value;
            const reps = form.elements['reps'].value;

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
                        reps: parseInt(reps)
                    })
                });

                if (!response.ok) {
                    const errData = await response.json();
                    alert('Błąd: ' + (errData.error || 'Nieznany błąd'));
                    return;
                }

                const data = await response.json();
                if (data.success) {
                    // Wyczyszczenie pól formularza
                    form.elements['weight'].value = '';
                    form.elements['reps'].value = '';

                    // Ponowne wyrenderowanie tabeli serii
                    renderSets(data.sets);

                    // Automatyczne uruchomienie Rest Timera po dodaniu serii!
                    resetAndStartTimer();
                }
            } catch (err) {
                console.error(err);
                alert('Wystąpił błąd połączenia podczas dodawania serii.');
            }
        });

        // Funkcja renderująca zaktualizowaną listę serii
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
                tr.innerHTML = `
                    <td><strong style="color: var(--text-color);">${escapeHtml(set.exercise_name)}</strong></td>
                    <td><span class="badge badge-primary">${parseFloat(set.weight)} kg</span></td>
                    <td><strong>${parseInt(set.reps)}</strong> powtórzeń</td>
                    <td style="text-align: center;">
                        <button class="btn-delete-set btn-danger btn-sm" data-id="${set.id}" style="background-color: #d32f2f;">Usuń</button>
                    </td>
                `;
                tableBody.appendChild(tr);
            });

            attachDeleteEvents();
        }

        // Obsługa asynchronicznego usuwania serii przez Fetch API
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
                            
                            // Sprawdzamy czy tabela jest teraz pusta
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

        // === LOGIKA REST TIMERA ===
        let timerSeconds = 90; // Domyślnie 01:30 (90s)
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
                    
                    // Prosty alarm dźwiękowy z przeglądarki (Beep)
                    try {
                        const context = new (window.AudioContext || window.webkitAudioContext)();
                        const oscillator = context.createOscillator();
                        oscillator.type = 'sine';
                        oscillator.frequency.setValueAtTime(880, context.currentTime); // Beep high frequency
                        oscillator.connect(context.destination);
                        oscillator.start();
                        oscillator.stop(context.currentTime + 0.3); // 300ms beep
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

        // Inicjalizacja nasłuchu zdarzeń usuwania na starcie
        attachDeleteEvents();
    });
    </script>
</body>
</html>