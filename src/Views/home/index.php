<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <!-- Tu w przyszłości podepniemy naszego CSSa -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    <header>
        <h1><?= htmlspecialchars($title) ?></h1>
        <nav>
            <?php if (isset($_SESSION['user_id'])): ?>
                <p>Zalogowany jako: <strong><?= htmlspecialchars($_SESSION['user_email']) ?></strong> (<?= htmlspecialchars($_SESSION['user_role'] ?? 'user') ?>)</p>
                <a href="/profile">Mój Profil</a> |
                <a href="/workouts">Moje Treningi</a> |
                <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
                    <a href="/admin/users" style="color: #ffeb3b;">Panel Admina</a> |
                <?php endif; ?>
                <a href="/logout">Wyloguj się</a>
            <?php else: ?>
                <a href="/login">Zaloguj się</a> | 
                <a href="/register">Zarejestruj się</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <h2>Oficjalne kategorie wagowe IPF:</h2>
        <ul>
            <?php foreach ($categories as $category): ?>
                <li>
                    <?= htmlspecialchars($category['name']) ?> 
                    (Max: <?= htmlspecialchars((string)$category['max_weight']) ?> kg)
                </li>
            <?php endforeach; ?>
        </ul>
    </main>

</body>
</html>