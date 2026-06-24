<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .btn-delete-set {
            background-color: #d32f2f;
            padding: 0.3rem 0.6rem;
            font-size: 0.85rem;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-delete-set:hover {
            background-color: #c62828;
        }
        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.9rem;
        }
    </style>
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
        
        <div id="no-sets-message" style="display: <?= empty($sets) ? 'block' : 'none' ?>;">
            <p>Brak zapisanych serii na tym treningu.</p>
        </div>
 
        <table id="sets-table" border="1" cellpadding="5" cellspacing="0" style="margin-bottom: 20px; display: <?= empty($sets) ? 'none' : 'table' ?>;">
            <thead>
                <tr>
                    <th>Ćwiczenie</th>
                    <th>Ciężar (kg)</th>
                    <th>Powtórzenia</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sets as $set): ?>
                    <tr id="set-row-<?= $set['id'] ?>">
                        <td><?= htmlspecialchars($set['exercise_name']) ?></td>
                        <td><?= htmlspecialchars((string)$set['weight']) ?> kg</td>
                        <td><?= htmlspecialchars((string)$set['reps']) ?></td>
                        <td>
                            <button class="btn-delete-set btn-sm" data-id="<?= $set['id'] ?>">Usuń</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
 
        <h3>Dodaj nową serię</h3>
        <form id="add-set-form">
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
                    <td>${escapeHtml(set.exercise_name)}</td>
                    <td>${parseFloat(set.weight)} kg</td>
                    <td>${parseInt(set.reps)}</td>
                    <td>
                        <button class="btn-delete-set btn-sm" data-id="${set.id}">Usuń</button>
                    </td>
                `;
                tableBody.appendChild(tr);
            });

            attachDeleteEvents();
        }

        // Obsługa asynchronicznego usuwania serii przez Fetch API
        function attachDeleteEvents() {
            document.querySelectorAll('.btn-delete-set').forEach(button => {
                // Klonujemy, by zapobiec wielokrotnemu bindowaniu zdarzeń
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

        // Inicjalizacja nasłuchu zdarzeń usuwania na starcie
        attachDeleteEvents();
    });
    </script>
</body>
</html>