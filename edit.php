<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
require_once 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit;
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = trim($_POST['item_name']);
    $category  = trim($_POST['category']);
    $quantity  = intval($_POST['quantity']);
    $price     = floatval($_POST['price']);

    $stmt = $pdo->prepare("UPDATE items SET item_name = ?, category = ?, quantity = ?, price = ? WHERE id = ?");
    $stmt->execute([$item_name, $category, $quantity, $price, $id]);
    header("Location: dashboard.php");
    exit;
}

// Fetch item data
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container" style="max-width: 500px;">
        <div class="card shadow-sm p-4">
            <h3 class="mb-3">Edit Item</h3>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Item Name</label>
                    <input type="text" name="item_name" class="form-control" value="<?= htmlspecialchars($item['item_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($item['category']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control" value="<?= $item['quantity'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Price ($)</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="<?= $item['price'] ?>" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Update Item</button>
                <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>