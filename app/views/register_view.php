<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Product Manager</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #000; /* Black background */
            color: #ecfdf5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .card {
            background: linear-gradient(135deg, #064e3b, #10b981); /* Dark green → Emerald gradient */
            width: 100%;
            max-width: 380px;
            padding: 2.25rem 2rem;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
            color: #fff;
        }
        h1 { font-size: 1.4rem; margin-bottom: .35rem; color: #d1fae5; }
        p.subtitle { color: #a7f3d0; font-size: .88rem; margin-bottom: 1.5rem; }
        label { display: block; font-size: .85rem; font-weight: 600; margin-bottom: .35rem; color: #ecfdf5; }
        input {
            width: 100%;
            padding: .65rem .8rem;
            border: 1px solid #065f46;
            border-radius: 8px;
            font-size: .95rem;
            margin-bottom: 1rem;
            background: #022c22;
            color: #d1fae5;
        }
        input:focus {
            outline: none;
            border-color: #34d399;
            box-shadow: 0 0 6px #34d399;
        }
        button {
            width: 100%;
            padding: .7rem;
            background: linear-gradient(90deg, #047857, #34d399);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: .95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover { background: linear-gradient(90deg, #065f46, #10b981); }
        .msg.error {
            padding: .7rem .9rem;
            border-radius: 8px;
            font-size: .85rem;
            margin-bottom: 1rem;
            background: #fee2e2;
            color: #991b1b;
        }
        .footer-link {
            text-align: center;
            margin-top: 1.25rem;
            font-size: .85rem;
            color: #a7f3d0;
        }
        .footer-link a {
            color: #34d399;
            text-decoration: none;
            font-weight: 600;
        }
        .footer-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="card">
    <h1>Create an account</h1>
    <p class="subtitle">Register to manage products.</p>

    <?php if (!empty($error)): ?>
        <div class="msg error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('register'); ?>">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" autocomplete="username" required autofocus>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" autocomplete="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" autocomplete="new-password" minlength="6" required>

        <button type="submit">Register</button>
    </form>

    <div class="footer-link">
        Already have an account? <a href="<?= base_url('login'); ?>">Log in</a>
    </div>
</div>
</body>
</html>
