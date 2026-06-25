<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= time() ?>">
    <style>
        .analytics-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-top: 1rem;
        }
        @media (min-width: 1024px) {
            .analytics-grid {
                grid-template-columns: 2fr 1fr;
            }
        }
        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .stat-card {
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.25rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: border-color 0.2s;
        }
        .stat-card:hover {
            border-color: var(--primary-color);
        }
        .stat-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background-color: var(--primary-color);
        }
        .stat-val {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-color);
            margin: 0.5rem 0;
        }
        .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .chart-toggle {
            display: flex;
            background-color: rgba(255, 255, 255, 0.05);
            padding: 2px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
        }
        .toggle-btn {
            background: none;
            border: none;
            color: var(--text-muted);
            padding: 0.4rem 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.2s;
        }
        .toggle-btn.active {
            background-color: var(--primary-color);
            color: white;
        }
        .chart-container {
            position: relative;
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .chart-wrapper {
            position: relative;
            width: 100%;
            height: 320px;
            margin-top: 1rem;
        }
        svg.chart-svg {
            width: 100%;
            height: 100%;
            overflow: visible;
        }
        .chart-tooltip {
            position: absolute;
            background-color: rgba(20, 20, 20, 0.95);
            border: 1px solid var(--border-color);
            padding: 0.6rem 1rem;
            border-radius: 6px;
            font-size: 0.8rem;
            color: white;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.15s ease;
            z-index: 10;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        }
        .record-badge {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(245, 158, 11, 0.05));
            border: 1px solid var(--warning-color);
            color: var(--warning-color);
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
            <a href="/analytics" class="active">Statystyki</a>
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
                    <a href="/profile">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Mój Profil
                    </a>
                </li>
                <li>
                    <a href="/analytics" class="active">
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
            
            <header class="top-bar">
                <div class="user-badge">
                    <span>Zalogowany jako: <strong><?= htmlspecialchars($_SESSION['user_email']) ?></strong></span>
                    <div class="user-avatar"><?= strtoupper(substr($_SESSION['user_email'], 0, 1)) ?></div>
                </div>
            </header>

            <main>
                <div style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em;">Statystyki i Wykresy</h2>
                    <p style="color: var(--text-muted);">Śledź swoje rekordy życiowe (PR) i analizuj progresję siły oraz objętości.</p>
                </div>
                
                <!-- Wyliczenia trójbojowe - top 3 główne boje -->
                <div class="stats-summary">
                    <?php
                    $squatPr = 0; $benchPr = 0; $deadliftPr = 0;
                    foreach ($personalRecords as $pr) {
                        $nameLower = mb_strtolower($pr['exercise_name']);
                        if (str_contains($nameLower, 'przysiad')) {
                            $squatPr = max($squatPr, (float)$pr['max_weight_lifted']);
                        } elseif (str_contains($nameLower, 'wyciskanie')) {
                            $benchPr = max($benchPr, (float)$pr['max_weight_lifted']);
                        } elseif (str_contains($nameLower, 'martwy') || str_contains($nameLower, 'ciąg')) {
                            $deadliftPr = max($deadliftPr, (float)$pr['max_weight_lifted']);
                        }
                    }
                    $totalTotal = $squatPr + $benchPr + $deadliftPr;
                    ?>
                    <div class="stat-card">
                        <div class="stat-label">Max Przysiad</div>
                        <div class="stat-val"><?= $squatPr > 0 ? $squatPr . ' kg' : 'Brak' ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Max Wyciskanie</div>
                        <div class="stat-val"><?= $benchPr > 0 ? $benchPr . ' kg' : 'Brak' ?></div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Max Martwy Ciąg</div>
                        <div class="stat-val"><?= $deadliftPr > 0 ? $deadliftPr . ' kg' : 'Brak' ?></div>
                    </div>
                    <div class="stat-card" style="border-color: var(--success-color);">
                        <div class="stat-label" style="color: var(--success-color);">Suma Trójbojowa</div>
                        <div class="stat-val" style="color: var(--success-color);"><?= $totalTotal > 0 ? $totalTotal . ' kg' : 'Brak' ?></div>
                    </div>
                </div>

                <div class="analytics-grid">
                    
                    <!-- Sekcja wykresu postępów -->
                    <div class="card" style="margin-top: 0;">
                        <div class="chart-header">
                            <h3 style="margin: 0;">Prognoza & Wykres Postępów</h3>
                            
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <select id="chart-exercise-select" style="padding: 0.4rem 1rem; border-radius: 6px; border: 1px solid var(--border-color); background-color: var(--surface-color); color: var(--text-color); font-size: 0.85rem; width: 220px;">
                                    <?php foreach ($exercises as $ex): ?>
                                        <option value="<?= $ex['id'] ?>" <?= ($ex['id'] == 1) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($ex['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <div class="chart-toggle">
                                    <button class="toggle-btn active" data-metric="1rm">1RM / Max</button>
                                    <button class="toggle-btn" data-metric="volume">Objętość</button>
                                </div>
                            </div>
                        </div>

                        <div class="chart-container">
                            <div class="chart-wrapper">
                                <svg id="progression-chart" class="chart-svg" viewBox="0 0 800 320" preserveAspectRatio="none">
                                    <!-- Siatka i osie będą generowane w JS -->
                                    <g id="grid-lines"></g>
                                    <g id="axes"></g>
                                    <path id="chart-path-fill" d="" fill="rgba(229, 57, 53, 0.05)" />
                                    <path id="chart-path" d="" fill="none" stroke="var(--primary-color)" stroke-width="3" />
                                    <g id="chart-points"></g>
                                    <g id="chart-labels"></g>
                                </svg>
                            </div>
                            <div id="chart-tooltip" class="chart-tooltip"></div>
                            
                            <div id="chart-no-data" style="display: none; position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background-color: rgba(30,30,30,0.8); color: var(--text-muted); font-size: 0.95rem; border-radius: 12px;">
                                Brak wystarczających danych treningowych dla tego ćwiczenia. Dodaj co najmniej 2 treningi.
                            </div>
                        </div>
                    </div>

                    <!-- Sekcja Rekordów Osobistych (Widok 2 w akcji) -->
                    <div class="card" style="margin-top: 0;">
                        <h3>Osobiste Rekordy (PR)</h3>
                        <p style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 1rem;">
                            Najlepsze wyniki szacowane na podstawie wzoru Epleya: <br>
                            <code>1RM = Ciężar * (1 + Powtórzenia / 30)</code>.
                        </p>

                        <div class="table-responsive">
                            <table class="table" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>Ćwiczenie</th>
                                        <th style="text-align: right;">Ciężar Max</th>
                                        <th style="text-align: right;">Szac. 1RM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($personalRecords)): ?>
                                        <tr>
                                            <td colspan="3" style="text-align: center; color: var(--text-muted); padding: 1.5rem 0;">
                                                Brak zarejestrowanych rekordów. Rozpocznij trening!
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($personalRecords as $record): ?>
                                            <tr>
                                                <td>
                                                    <strong style="color: var(--text-color);"><?= htmlspecialchars($record['exercise_name']) ?></strong>
                                                    <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase;">
                                                        <?= $record['exercise_category'] === 'primary' ? '🏆 Główny bój' : 'Akcesorium' ?>
                                                    </div>
                                                </td>
                                                <td style="text-align: right; font-weight: bold; color: var(--text-color);">
                                                    <?= (float)$record['max_weight_lifted'] ?> kg
                                                </td>
                                                <td style="text-align: right;">
                                                    <span class="badge record-badge">
                                                        <?= (float)$record['max_calculated_1rm'] ?> kg
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </main>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const exerciseSelect = document.getElementById('chart-exercise-select');
        const toggleButtons = document.querySelectorAll('.toggle-btn');
        const tooltip = document.getElementById('chart-tooltip');
        const noDataDiv = document.getElementById('chart-no-data');
        
        let currentMetric = '1rm'; // '1rm' lub 'volume'
        let chartData = [];

        // Przełączanie metryki wykresu
        toggleButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                toggleButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentMetric = btn.dataset.metric;
                drawChart();
            });
        });

        // Obsługa wyboru ćwiczenia
        exerciseSelect.addEventListener('change', fetchChartData);

        // Pobieranie danych wykresu przez Fetch API
        async function fetchChartData() {
            const exerciseId = exerciseSelect.value;
            if (!exerciseId) return;

            try {
                const response = await fetch(`/api/analytics/chart?exercise_id=${exerciseId}`);
                if (response.ok) {
                    const res = await response.json();
                    if (res.success) {
                        chartData = res.data;
                        drawChart();
                    }
                }
            } catch (err) {
                console.error('Error fetching chart data:', err);
            }
        }

        // Rysowanie wykresu SVG
        function drawChart() {
            const svg = document.getElementById('progression-chart');
            const gridLinesGroup = document.getElementById('grid-lines');
            const axesGroup = document.getElementById('axes');
            const pathElement = document.getElementById('chart-path');
            const pathFillElement = document.getElementById('chart-path-fill');
            const pointsGroup = document.getElementById('chart-points');
            const labelsGroup = document.getElementById('chart-labels');

            // Czyszczenie dynamicznych elementów
            gridLinesGroup.innerHTML = '';
            axesGroup.innerHTML = '';
            pointsGroup.innerHTML = '';
            labelsGroup.innerHTML = '';
            pathElement.setAttribute('d', '');
            pathFillElement.setAttribute('d', '');

            if (!chartData || chartData.length < 2) {
                noDataDiv.style.display = 'flex';
                return;
            }
            noDataDiv.style.display = 'none';

            // Marginesy i wymiary wewnątrz viewBox="0 0 800 320"
            const width = 800;
            const height = 320;
            const paddingLeft = 60;
            const paddingRight = 40;
            const paddingTop = 30;
            const paddingBottom = 50;

            const chartWidth = width - paddingLeft - paddingRight;
            const chartHeight = height - paddingTop - paddingBottom;

            // Wybór wartości na podstawie metryki
            const values = chartData.map(d => currentMetric === '1rm' ? d.max_1rm : d.total_volume);
            const maxVal = Math.max(...values) * 1.1; // +10% marginesu na górze
            const minVal = Math.min(...values) * 0.9; // -10% marginesu na dole
            const valRange = maxVal - minVal;

            const n = chartData.length;

            // Rysowanie linii siatki poziomej i etykiet Y
            const gridCount = 5;
            for (let i = 0; i <= gridCount; i++) {
                const ratio = i / gridCount;
                const y = paddingTop + chartHeight * (1 - ratio);
                const val = minVal + valRange * ratio;

                // Linia pomocnicza
                const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line.setAttribute('x1', paddingLeft);
                line.setAttribute('y1', y);
                line.setAttribute('x2', width - paddingRight);
                line.setAttribute('y2', y);
                line.setAttribute('stroke', 'rgba(255,255,255,0.05)');
                line.setAttribute('stroke-width', '1');
                if (i === 0) line.setAttribute('stroke', 'rgba(255,255,255,0.2)'); // Dolna oś
                gridLinesGroup.appendChild(line);

                // Etykieta Y
                const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                text.setAttribute('x', paddingLeft - 10);
                text.setAttribute('y', y + 4);
                text.setAttribute('text-anchor', 'end');
                text.setAttribute('fill', 'var(--text-muted)');
                text.setAttribute('font-size', '10px');
                text.textContent = Math.round(val) + (currentMetric === '1rm' ? ' kg' : ' kg');
                gridLinesGroup.appendChild(text);
            }

            // Punkty wykresu (mapowanie na współrzędne SVG)
            const points = chartData.map((d, index) => {
                const x = paddingLeft + (index / (n - 1)) * chartWidth;
                const val = currentMetric === '1rm' ? d.max_1rm : d.total_volume;
                const y = paddingTop + chartHeight * (1 - ((val - minVal) / valRange));
                return { x, y, data: d };
            });

            // Generowanie ścieżki
            let pathD = '';
            let fillD = `M ${paddingLeft} ${paddingTop + chartHeight} `;
            
            points.forEach((pt, idx) => {
                if (idx === 0) {
                    pathD += `M ${pt.x} ${pt.y} `;
                } else {
                    pathD += `L ${pt.x} ${pt.y} `;
                }
                fillD += `L ${pt.x} ${pt.y} `;
            });

            fillD += `L ${points[points.length - 1].x} ${paddingTop + chartHeight} Z`;

            pathElement.setAttribute('d', pathD);
            pathFillElement.setAttribute('d', fillD);

            // Dodawanie punktów (kółek) i etykiet X
            points.forEach((pt, idx) => {
                // Kółko
                const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                circle.setAttribute('cx', pt.x);
                circle.setAttribute('cy', pt.y);
                circle.setAttribute('r', '5');
                circle.setAttribute('fill', 'var(--primary-color)');
                circle.setAttribute('stroke', '#121212');
                circle.setAttribute('stroke-width', '2');
                circle.style.cursor = 'pointer';
                circle.style.transition = 'r 0.15s ease';

                // Hover na kółko (Tooltip)
                circle.addEventListener('mouseenter', (e) => {
                    circle.setAttribute('r', '8');
                    tooltip.style.opacity = '1';
                    
                    const unit = ' kg';
                    const mainVal = currentMetric === '1rm' ? pt.data.max_1rm : pt.data.total_volume;
                    let tooltipHtml = `
                        <strong>${pt.data.date}</strong><br>
                        ${pt.data.workout_name ? `<em>${pt.data.workout_name}</em><br>` : ''}
                        <strong>${currentMetric === '1rm' ? 'Szacowany 1RM' : 'Objętość'}</strong>: ${mainVal.toFixed(1)}${unit}<br>
                        Max Ciężar: ${pt.data.max_weight} kg
                    `;
                    tooltip.innerHTML = tooltipHtml;
                });

                circle.addEventListener('mousemove', (e) => {
                    const rect = svg.getBoundingClientRect();
                    const tooltipWidth = tooltip.offsetWidth;
                    const tooltipHeight = tooltip.offsetHeight;
                    
                    // Pozycja relatywna do kontenera chart-wrapper
                    let xPos = (e.clientX - rect.left) / rect.width * 100;
                    let yPos = (e.clientY - rect.top) / rect.height * 100;

                    // Przypisz piksele
                    tooltip.style.left = `${e.clientX - rect.left - tooltipWidth / 2}px`;
                    tooltip.style.top = `${e.clientY - rect.top - tooltipHeight - 15}px`;
                });

                circle.addEventListener('mouseleave', () => {
                    circle.setAttribute('r', '5');
                    tooltip.style.opacity = '0';
                });

                pointsGroup.appendChild(circle);

                // Etykieta X (co drugi lub trzeci punkt, żeby się nie nakładały)
                if (n <= 6 || idx % Math.ceil(n / 6) === 0 || idx === n - 1) {
                    const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                    // Format daty: DD.MM
                    const dateParts = pt.data.date.split('-');
                    const dateFormatted = dateParts.length === 3 ? `${dateParts[2]}.${dateParts[1]}` : pt.data.date;

                    text.setAttribute('x', pt.x);
                    text.setAttribute('y', height - paddingBottom + 20);
                    text.setAttribute('text-anchor', 'middle');
                    text.setAttribute('fill', 'var(--text-muted)');
                    text.setAttribute('font-size', '10px');
                    text.textContent = dateFormatted;
                    labelsGroup.appendChild(text);

                    // Mała kreska na osi X
                    const tick = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                    tick.setAttribute('x1', pt.x);
                    tick.setAttribute('y1', height - paddingBottom);
                    tick.setAttribute('x2', pt.x);
                    tick.setAttribute('y2', height - paddingBottom + 5);
                    tick.setAttribute('stroke', 'rgba(255,255,255,0.2)');
                    labelsGroup.appendChild(tick);
                }
            });
        }

        // Pierwsze załadowanie
        fetchChartData();
    });
    </script>

</body>
</html>
