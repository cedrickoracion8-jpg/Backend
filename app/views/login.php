<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in | Product Desk</title>
    <style>
        :root {
            color-scheme: dark;
            --bg: #000000;          /* Black background */
            --panel: linear-gradient(135deg, #064e3b, #10b981); /* Dark green → Emerald gradient */
            --line: #065f46;        /* Deep green border */
            --accent: #34d399;      /* Emerald accent */
            --text: #ecfdf5;        /* Light greenish text */
            --muted: #6ee7b7;       /* Muted mint */
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            font: 16px/1.5 "Segoe UI", Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }
        main {
            width: min(100%, 420px);
            padding: 36px;
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,.6);
        }
        h1 {
            margin: 0 0 8px;
            font: 700 2rem/1.1 "Segoe UI", sans-serif;
            color: #d1fae5;
        }
        p {
            color: var(--muted);
            margin: 0 0 28px;
        }
        label {
            display: block;
            margin: 18px 0 7px;
            font-weight: 700;
            color: #ecfdf5;
        }
        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--line);
            border-radius: 6px;
            background: #022c22;
            color: var(--text);
            font: inherit;
        }
        input:focus {
            outline: none;
            border-color: #34d399;
            box-shadow: 0 0 6px #34d399;
        }
        button {
            width: 100%;
            margin-top: 24px;
            padding: 12px 16px;
            border: 0;
            border-radius: 6px;
            background: linear-gradient(90deg, #047857, #34d399);
            color: #fff;
            cursor: pointer;
            font-weight: 700;
            font: inherit;
            transition: background 0.3s ease;
        }
        button:hover {
            background: linear-gradient(90deg, #065f46, #10b981);
        }
        .error {
            padding: 10px 12px;
            border-left: 3px solid #ef4444;
            background: rgba(239,68,68,.12);
            color: #fecaca;
            border-radius: 6px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<main>
    <h1>Product Desk</h1>
    <p>Sign in to manage the product inventory.</p>
    <?php if (!empty($error)): ?>
        <div class="error" role="alert"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="post" action="<?= site_url('login'); ?>">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" required autocomplete="username">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required autocomplete="current-password">
        <button type="submit">Sign in</button>
    </form>
</main>
</body>
</html>
