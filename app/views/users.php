<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        :root {
            --forest-950: #06231b;
            --forest-900: #0a3327;
            --forest-800: #0f4a37;
            --forest-700: #166647;
            --moss-500: #2f9463;
            --moss-400: #4bb37e;
            --mint-300: #86d9ab;
            --mint-200: #bdeed0;
            --paper: #f4faf6;
            --ink: #10231a;
            --ink-soft: #4d6b5c;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 15% 10%, rgba(134, 217, 171, 0.18), transparent 45%),
                radial-gradient(circle at 85% 90%, rgba(47, 148, 99, 0.25), transparent 50%),
                linear-gradient(160deg, var(--forest-950) 0%, var(--forest-800) 45%, var(--moss-500) 100%);
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 8vh 20px 48px;
        }

        .container {
            width: 100%;
            max-width: 1180px;
            background: var(--paper);
            border-radius: 22px;
            box-shadow:
                0 30px 60px -20px rgba(6, 35, 27, 0.55),
                0 0 0 1px rgba(255, 255, 255, 0.06);
            overflow: hidden;
        }

        .container h2 {
            margin: 0;
            padding: 40px 44px 30px;
            font-size: 26px;
            font-weight: 600;
            letter-spacing: 0.2px;
            color: #ffffff;
            background: linear-gradient(120deg, var(--forest-900), var(--forest-700) 60%, var(--moss-500));
            border-bottom: 3px solid var(--mint-300);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        thead th {
            text-align: left;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.4px;
            color: var(--forest-900);
            padding: 18px 24px;
            background: var(--mint-200);
            border-bottom: 2px solid var(--moss-400);
            border-right: 2px solid rgba(22, 102, 71, 0.25);
        }

        thead th:first-child {
            padding-left: 44px;
            border-top-left-radius: 14px;
        }
        thead th:last-child {
            padding-right: 44px;
            border-right: none;
            border-top-right-radius: 14px;
        }

        tbody td {
            padding: 18px 24px;
            font-size: 15px;
            color: var(--ink);
            border-bottom: 1px solid #dcefe2;
            border-right: 2px solid #cfe9da;
        }

        tbody td:first-child { padding-left: 44px; color: var(--ink-soft); }
        tbody td:last-child { padding-right: 44px; border-right: none; }

        tbody tr:last-child td:first-child { border-bottom-left-radius: 14px; }
        tbody tr:last-child td:last-child { border-bottom-right-radius: 14px; }

        tbody tr:nth-child(even) { background: #eef8f1; }

        tbody tr:hover {
            background: linear-gradient(90deg, rgba(75, 179, 126, 0.14), rgba(134, 217, 171, 0.08));
        }

        tbody tr:last-child td { border-bottom: none; }

        td.empty {
            text-align: center;
            padding: 40px 20px;
            color: var(--ink-soft);
            font-style: italic;
            background: #fff;
        }

        @media (max-width: 640px) {
            .container h2 { padding: 24px 20px 20px; font-size: 19px; }
            thead th, tbody td { padding: 12px 14px; font-size: 13px; }
            thead th:first-child, tbody td:first-child { padding-left: 20px; }
            thead th:last-child, tbody td:last-child { padding-right: 20px; }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Registered Users</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= html_escape($user['id'] ?? ''); ?></td>
                        <td><?= html_escape($user['firstname'] ?? ''); ?></td>
                        <td><?= html_escape($user['lastname'] ?? ''); ?></td>
                        <td><?= html_escape($user['email'] ?? ''); ?></td>
                        <td><?= html_escape($user['username'] ?? ''); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty">No users found in the database.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>