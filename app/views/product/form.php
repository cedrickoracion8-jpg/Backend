<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); 
$product = is_array($product ?? null) ? $product : []; 
$editing = !empty($product['id']); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $editing ? 'Edit' : 'Add'; ?> product | Product Desk</title>
    <style>
        :root {
            --bg: #000000; /* Black background */
            --panel: linear-gradient(135deg, #064e3b, #10b981); /* Dark green → Emerald gradient */
            --line: #065f46;
            --accent: #34d399;
            --text: #ecfdf5;
            --muted: #6ee7b7;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            padding: 44px 20px;
            background: var(--bg);
            color: var(--text);
            font: 16px/1.5 "Segoe UI", Arial, sans-serif;
        }
        main { width: min(100%, 680px); margin: auto; }
        h1 {
            margin: 0 0 26px;
            font-size: clamp(2rem, 6vw, 3.2rem);
            color: #d1fae5;
        }
        .back {
            color: var(--accent);
            font: 700 .9rem Arial, sans-serif;
            text-decoration: none;
        }
        .back:hover { text-decoration: underline; }
        form {
            padding: 28px;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: var(--panel);
            box-shadow: 0 12px 28px rgba(0,0,0,.6);
        }
        label {
            display: block;
            margin: 18px 0 7px;
            font-weight: 700;
            color: var(--text);
        }
        label:first-child { margin-top: 0; }
        input, textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--line);
            border-radius: 6px;
            background: #022c22;
            color: var(--text);
            font: inherit;
        }
        textarea { min-height: 130px; resize: vertical; }
        input:focus, textarea:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 6px var(--accent);
        }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .error {
            margin-bottom: 18px;
            padding: 11px 13px;
            border-left: 4px solid #b42318;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 6px;
        }
        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 26px;
        }
        .button {
            padding: 11px 16px;
            border: 0;
            border-radius: 6px;
            background: linear-gradient(90deg, #047857, #34d399);
            color: #fff;
            cursor: pointer;
            font: 700 .9rem Arial, sans-serif;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        .button:hover { background: linear-gradient(90deg, #065f46, #10b981); }
        .cancel {
            background: transparent;
            border: 1px solid var(--line);
            color: var(--text);
        }
        .cancel:hover { background: #065f46; }
        @media (max-width: 560px) {
            .grid { grid-template-columns: 1fr; gap: 0; }
        }
    </style>
</head>
<body>
<main>
    <a class="back" href="<?= site_url('products'); ?>">&larr; Back to products</a>
    <h1><?= $editing ? 'Edit product' : 'Add product'; ?></h1>

    <?php if (!empty($error)): ?>
        <div class="error" role="alert"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="<?= site_url($editing ? 'products/edit/' . (int) ($product['id'] ?? 0) : 'products'); ?>">
        <label for="product_name">Product name</label>
        <input id="product_name" name="product_name" maxlength="100" required value="<?= htmlspecialchars($product['product_name'] ?? ''); ?>">

        <label for="description">Description</label>
        <textarea id="description" name="description"><?= htmlspecialchars($product['description'] ?? ''); ?></textarea>

        <div class="grid">
            <div>
                <label for="price">Price</label>
                <input id="price" name="price" type="number" min="0" step="0.01" required value="<?= htmlspecialchars($product['price'] ?? ''); ?>">
            </div>
            <div>
                <label for="quantity">Quantity</label>
                <input id="quantity" name="quantity" type="number" min="0" step="1" required value="<?= htmlspecialchars($product['quantity'] ?? ''); ?>">
            </div>
        </div>

        <div class="actions">
            <a class="button cancel" href="<?= site_url('products'); ?>">Cancel</a>
            <button class="button" type="submit"><?= $editing ? 'Save changes' : 'Create product'; ?></button>
        </div>
    </form>
</main>
</body>
</html>
