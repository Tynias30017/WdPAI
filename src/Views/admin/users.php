<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }
        .admin-table th, .admin-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        .role-badge {
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: bold;
        }
        .badge-admin {
            background-color: var(--primary-color);
            color: white;
        }
        .badge-user {
            background-color: #333;
            color: #ccc;
        }
        .action-form {
            display: inline-block;
            margin: 0;
        }
        .action-form select {
            width: auto;
            display: inline-block;
            padding: 0.3rem;
            margin-right: 0.5rem;
        }
        .btn-sm {
            padding: 0.3rem 0.6rem;
            font-size: 0.85rem;
        }
        .btn-danger {
            background-color: #d32f2f;
        }
        .btn-danger:hover {
            background-color: #c62828;
        }
    </style>
</head>
<body>

    <header>
        <h1>Panel Admina - Użytkownicy</h1>
        <nav>
            <a href="/">Strona Główna</a> |
            <a href="/workouts">Moje Treningi</a> |
            <a href="/logout">Wyloguj się</a>
        </nav>
    </header>

    <main style="max-width: 1000px;">
        <h2>Wykaz Użytkowników Systemu</h2>
        <p style="color: var(--text-muted); margin-bottom: 1rem;">
            Tutaj możesz zarządzać uprawnieniami (rolami) użytkowników oraz usuwać ich konta (co spowoduje usunięcie wszystkich powiązanych danych treningowych za pomocą relacji kaskadowej w bazie).
        </p>

        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Imię i Nazwisko</th>
                        <th>Kategoria</th>
                        <th>Rola</th>
                        <th>Zmień Rolę</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><strong><?= htmlspecialchars($user['email']) ?></strong></td>
                            <td>
                                <?= htmlspecialchars(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?: '<em style="color: var(--text-muted);">Brak profilu</em>' ?>
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
                                    <button type="submit" class="btn-sm">Aktualizuj</button>
                                </form>
                            </td>
                            <td>
                                <?php if ((int)$user['id'] !== (int)$_SESSION['user_id']): ?>
                                    <form action="/admin/users/delete" method="POST" class="action-form" onsubmit="return confirm('Czy na pewno chcesz usunąć tego użytkownika i wszystkie jego dane?');">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <button type="submit" class="btn-sm btn-danger">Usuń</button>
                                    </form>
                                <?php else: ?>
                                    <span style="color: var(--text-muted); font-size: 0.85rem;">To Ty</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
