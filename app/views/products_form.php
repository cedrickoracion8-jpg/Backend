<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

$product = is_array($product ?? null) ? $product : [];
$is_edit = ($mode === 'edit');
$form_action = $is_edit ? base_url('products/edit/' . ($product['id'] ?? 0)) : base_url('products/create');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $is_edit ? 'Edit Product' : 'Add Product'; ?> | Product Manager</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #000; /* Black background */
            color: #ecfdf5;
            min-height: 100vh;
            padding: 2.5rem 1.5rem;
            display: flex;
            justify-content: center;
        }
        .card {
            background: linear-gradient(135deg, #064e3b, #10b981); /* Dark green → Emerald gradient */
            width: 100%;
            max-width: 520px;
            padding: 2rem;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
            height: fit-content;
            color: #fff;
        }
        .topline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        h1 { font-size: 1.4rem; color: #d1fae5; }
        a.back {
            font-size: .85rem;
            color: #34d399;
            text-decoration: none;
            font-weight: 600;
        }
        a.back:hover { text-decoration: underline; }
        label {
            display: block;
            font-size: .85rem;
            font-weight: 600;
            margin-bottom: .35rem;
            color: #ecfdf5;
        }
        input, textarea {
            width: 100%;
            padding: .65rem .8rem;
            border: 1px solid #065f46;
            border-radius: 8px;
            font-size: .95rem;
            margin-bottom: 1rem;
            font-family: inherit;
            background: #022c22;
            color: #d1fae5;
        }
        textarea { resize: vertical; min-height: 90px; }
        input:focus, textarea:focus {
            outline: none;
            border-color: #34d399;
            box-shadow: 0 0 6px #34d399;
        }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        button {
            padding: .7rem 1.4rem;
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
        .msg.success {
            padding: .7rem .9rem;
            border-radius: 8px;
            font-size: .85rem;
            margin-bottom: 1rem;
            background: #dcfce7;
            color: #166534;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="topline">
        <h1><?= $is_edit ? 'Edit Product' : 'Add Product'; ?></h1>
        <a class="back" href="<?= base_url('products'); ?>">&larr; Back to list</a>
    </div>

    <?php if (!empty($error)): ?>
        <div class="msg error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="msg success"><?= htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="post" action="<?= $form_action; ?>">
        <label for="product_name">Product Name</label>
        <input type="text" id="product_name" name="product_name" maxlength="100" required
               value="<?= htmlspecialchars($product['product_name'] ?? ''); ?>" autofocus>

        <label for="description">Description</label>
        <textarea id="description" name="description"><?= htmlspecialchars($product['description'] ?? ''); ?></textarea>

        <div class="row">
            <div>
                <label for="price">Price</label>
                <input type="number" id="price" name="price" step="0.01" min="0" required
                       value="<?= htmlspecialchars($product['price'] ?? ''); ?>">
            </div>
            <div>
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" step="1" min="0" required
                       value="<?= htmlspecialchars($product['quantity'] ?? ''); ?>">
            </div>
        </div>

        <button type="submit"><?= $is_edit ? 'Save Changes' : 'Add Product'; ?></button>
    </form>
</div>
</body>
</html>
