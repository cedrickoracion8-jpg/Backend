<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); 
$products = is_array($products ?? null) ? $products : []; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products | Product Desk</title>
    <style>
        :root {
            --bg: #000000; /* Black background */
            --panel: linear-gradient(135deg, #064e3b, #10b981); /* Dark green → Emerald gradient */
            --line: #065f46;
            --accent: #34d399;
            --danger: #dc2626;
            --text: #ecfdf5;
            --muted: #6ee7b7;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            font: 16px/1.5 "Segoe UI", Arial, sans-serif;
        }
        header, main { width: min(1100px, calc(100% - 40px)); margin: auto; }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 30px 0;
        }
        h1 {
            margin: 0;
            font-size: clamp(2rem, 5vw, 3.5rem);
            line-height: 1;
            color: #d1fae5;
        }
        .eyebrow {
            margin: 0 0 6px;
            color: var(--accent);
            font: 700 .78rem/1.2 Arial, sans-serif;
            letter-spacing: .12em;
            text-transform: uppercase;
        }
        a, button { font: 700 .9rem Arial, sans-serif; }
        a { color: inherit; }
        .button {
            display: inline-block;
            padding: 10px 14px;
            border-radius: 6px;
            text-decoration: none;
            background: linear-gradient(90deg, #047857, #34d399);
            color: #fff;
            transition: background 0.3s ease;
        }
        .button:hover { background: linear-gradient(90deg, #065f46, #10b981); }
        .ghost {
            background: transparent;
            border: 1px solid var(--line);
            color: var(--text);
        }
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }
        .user { color: var(--muted); }
        .logout { display: inline; }
        .logout button {
            padding: 0;
            border: 0;
            background: transparent;
            color: var(--muted);
            cursor: pointer;
        }
        .notice {
            margin-bottom: 18px;
            padding: 12px 14px;
            border-left: 4px solid #34d399;
            background: rgba(52,211,153,.15);
            color: #d1fae5;
            border-radius: 6px;
        }
        .table-wrap {
            overflow-x: auto;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: var(--panel);
            box-shadow: 0 12px 28px rgba(0,0,0,.6);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 720px;
            color: var(--text);
        }
        th, td {
            padding: 15px 16px;
            text-align: left;
            border-bottom: 1px solid var(--line);
        }
        th {
            color: #d1fae5;
            font: 700 .75rem Arial, sans-serif;
            letter-spacing: .08em;
            text-transform: uppercase;
            background: #065f46;
        }
        tr:last-child td { border-bottom: 0; }
        tbody tr:nth-child(even) { background: rgba(2,44,34,0.6); }
        tbody tr:hover { background: rgba(52,211,153,0.2); }
        .description { max-width: 330px; color: var(--muted); }
        .actions { white-space: nowrap; }
        .actions a {
            margin-right: 12px;
            color: var(--accent);
        }
        .delete { display: inline; }
        .delete button {
            padding: 0;
            border: 0;
            background: none;
            color: var(--danger);
            cursor: pointer;
        }
        .empty { padding: 38px; text-align: center; color: var(--muted); }
        @media (max-width: 600px) {
            header { align-items: flex-start; flex-direction: column; }
            .toolbar { align-items: flex-start; flex-direction: column; }
            main, header { width: min(100% - 28px, 1100px); }
        }
    </style>
</head>
<body>
<header>
    <div>
        <p class="eyebrow">Inventory</p>
        <h1>Products</h1>
    </div>
    <a class="button" href="<?= site_url('products/create'); ?>">Add product</a>
</header>
<main>
    <div class="toolbar">
        <span class="user">Signed in as <?= htmlspecialchars($_SESSION['username'] ?? 'user'); ?></span>
        <form class="logout" method="post" action="<?= site_url('logout'); ?>">
            <button type="submit">Sign out</button>
        </form>
    </div>
    <?php if (!empty($message)): ?>
        <div class="notice" role="status">Product <?= htmlspecialchars($message); ?>.</div>
    <?php endif; ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Name</th><th>Description</th><th>Price</th><th>Quantity</th><th>Created</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): foreach ($products as $product): $product = is_array($product) ? $product : []; ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($product['product_name'] ?? ''); ?></strong></td>
                        <td class="description"><?= htmlspecialchars($product['description'] ?? ''); ?></td>
                        <td>₱<?= number_format((float) ($product['price'] ?? 0), 2); ?></td>
                        <td><?= (int) ($product['quantity'] ?? 0); ?></td>
                        <td><?= htmlspecialchars($product['created_at'] ?? ''); ?></td>
                        <td class="actions">
                            <a href="<?= site_url('products/edit/' . (int) ($product['id'] ?? 0)); ?>">Edit</a>
                            <form class="delete" method="post" action="<?= site_url('products/delete/' . (int) ($product['id'] ?? 0)); ?>" onsubmit="return confirm('Delete this product?');">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td class="empty" colspan="6">No products yet. Add your first product to get started.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>
