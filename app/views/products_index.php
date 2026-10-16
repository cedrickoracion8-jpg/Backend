<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

$is_admin = (($_SESSION['role'] ?? null) === 'admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | Product Manager</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #000; /* Black background */
            color: #ecfdf5;
            min-height: 100vh;
            padding: 2.5rem 1.5rem;
        }
        .wrap { max-width: 1000px; margin: 0 auto; }
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        h1 { font-size: 1.6rem; color: #d1fae5; }
        .actions { display: flex; gap: .6rem; align-items: center; }
        .btn {
            display: inline-block;
            padding: .55rem 1rem;
            border-radius: 8px;
            font-size: .85rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(90deg, #047857, #34d399);
            color: #fff;
        }
        .btn-primary:hover { background: linear-gradient(90deg, #065f46, #10b981); }
        .btn-muted { background: #022c22; color: #d1fae5; border: 1px solid #065f46; }
        .btn-muted:hover { background: #065f46; }
        .btn-danger { background: #dc2626; color: #fff; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-sm { padding: .4rem .75rem; font-size: .8rem; }
        .msg {
            padding: .7rem .9rem;
            border-radius: 8px;
            font-size: .85rem;
            margin-bottom: 1.25rem;
        }
        .msg.success { background: #dcfce7; color: #166534; }
        .msg.error { background: #fee2e2; color: #991b1b; }
        .panel {
            background: linear-gradient(135deg, #064e3b, #10b981);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
            overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; color: #ecfdf5; }
        th, td { padding: .85rem 1.1rem; text-align: left; font-size: .9rem; }
        th {
            background: #065f46;
            color: #d1fae5;
            font-weight: 600;
        }
        tbody tr:nth-child(even) { background: rgba(2,44,34,0.6); }
        tbody tr:hover { background: rgba(52,211,153,0.2); }
        td { border-bottom: 1px solid #065f46; }
        td.desc { max-width: 260px; color: #a7f3d0; }
        td.numeric { text-align: right; white-space: nowrap; }
        .row-actions { display: flex; gap: .5rem; }
        .empty { padding: 2rem; text-align: center; color: #6ee7b7; }
        form.inline { display: inline; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="topbar">
        <h1>Products</h1>
        <div class="actions">
            <span style="font-size:.85rem;color:#6ee7b7;">
                Signed in as <strong><?= htmlspecialchars($_SESSION['username'] ?? ''); ?></strong>
                <?php if (!$is_admin): ?>
                    <span style="background:#022c22;color:#a7f3d0;padding:.15rem .5rem;border-radius:6px;font-size:.75rem;margin-left:.4rem;">view only</span>
                <?php endif; ?>
            </span>
            <?php if ($is_admin): ?>
                <a class="btn btn-primary" href="<?= base_url('products/create'); ?>">+ Add Product</a>
            <?php endif; ?>
            <a class="btn btn-muted" href="<?= base_url('logout'); ?>">Logout</a>
        </div>
    </div>

    <?php if (!empty($success)): ?>
        <div class="msg success"><?= htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="msg error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="panel">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Created</th>
                    <?php if ($is_admin): ?><th>Actions</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($product['id']); ?></td>
                            <td><?= htmlspecialchars($product['product_name']); ?></td>
                            <td class="desc"><?= htmlspecialchars($product['description']); ?></td>
                            <td class="numeric">₱<?= number_format((float) $product['price'], 2); ?></td>
                            <td class="numeric"><?= htmlspecialchars($product['quantity']); ?></td>
                            <td><?= htmlspecialchars($product['created_at'] ?? ''); ?></td>
                            <?php if ($is_admin): ?>
                            <td>
                                <div class="row-actions">
                                    <a class="btn btn-muted btn-sm" href="<?= base_url('products/edit/' . $product['id']); ?>">Edit</a>
                                    <form class="inline" method="post" action="<?= base_url('products/delete/' . $product['id']); ?>" onsubmit="return confirm('Delete this product?');">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="<?= $is_admin ? 7 : 6; ?>" class="empty">
                        <?= $is_admin ? 'No products yet. Click "Add Product" to create one.' : 'No products yet.'; ?>
                    </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
