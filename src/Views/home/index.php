<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <!-- Tu w przyszłości podepniemy naszego CSSa -->
</head>
<body>

    <header>
        <h1><?= htmlspecialchars($title) ?></h1>
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