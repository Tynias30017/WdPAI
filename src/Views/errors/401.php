<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .error-container {
            text-align: center;
            padding: 3rem 1rem;
        }
        .error-code {
            font-size: 6rem;
            font-weight: 800;
            color: var(--primary-color);
            line-height: 1;
            margin-bottom: 1rem;
            text-shadow: 0 0 10px rgba(229, 57, 53, 0.3);
        }
        .error-message {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: var(--text-color);
        }
        .error-desc {
            color: var(--text-muted);
            margin-bottom: 3rem;
        }
        .btn-home {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 4px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn-home:hover {
            background-color: var(--primary-hover);
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <h1>Trójbój Siłowy - Dziennik</h1>
        <nav>
            <a href="/">Strona Główna</a>
        </nav>
    </header>
    <main>
        <div class="error-container">
            <div class="error-code">401</div>
            <div class="error-message">Brak autoryzacji (Unauthorized)</div>
            <p class="error-desc"><?= htmlspecialchars($message ?? 'Musisz być zalogowany, aby uzyskać dostęp do tej strony.') ?></p>
            <a href="/login" class="btn-home">Zaloguj się</a>
        </div>
    </main>
</body>
</html>
