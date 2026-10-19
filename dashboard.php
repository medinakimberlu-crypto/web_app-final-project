<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

require_once 'db.php';

$total_products = 0;
$total_categories = 0;
$total_suppliers = 0;
$total_stock = 0;

try {
    $stmt1 = $pdo->query("SELECT COUNT(*) FROM products");
    $total_products = $stmt1->fetchColumn();

    $stmt2 = $pdo->query("SELECT COUNT(*) FROM categories");
    $total_categories = $stmt2->fetchColumn();

    $stmt3 = $pdo->query("SELECT COUNT(*) FROM suppliers");
    $total_suppliers = $stmt3->fetchColumn();

    $stmt4 = $pdo->query("SELECT SUM(quantity) FROM products");
    $total_stock = $stmt4->fetchColumn() ?: 0;
} catch (Exception $e) {
  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .stat-card {
            background-color: #6f42c1;
            color: white;
            border-radius: 8px;
            padding: 20px;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="dashboard.php">Inventory System</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="suppliers.php">Suppliers</a></li>
                </ul>
                <div class="d-flex align-items-center text-white">
                    <span class="me-3">Hello, <strong><?php echo htmlspecialchars($_SESSION['username'] ?? 'admin'); ?></strong></span>
                    <a href="index.php" class="btn btn-outline-light btn-sm">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <h2 class="fw-bold">Dashboard</h2>
        <p class="text-muted">Welcome to your Inventory Management System dashboard.</p>

        <div class="row g-4 mt-2">
            <div class="col-md-3">
                <div class="stat-card shadow-sm">
                    <h6 class="text-uppercase fw-semibold" style="font-size: 0.85rem;">Total Products</h6>
                    <h2 class="fw-bold mb-0"><?php echo $total_products; ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card shadow-sm">
                    <h6 class="text-uppercase fw-semibold" style="font-size: 0.85rem;">Total Categories</h6>
                    <h2 class="fw-bold mb-0"><?php echo $total_categories; ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card shadow-sm">
                    <h6 class="text-uppercase fw-semibold" style="font-size: 0.85rem;">Total Suppliers</h6>
                    <h2 class="fw-bold mb-0"><?php echo $total_suppliers; ?></h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card shadow-sm">
                    <h6 class="text-uppercase fw-semibold" style="font-size: 0.85rem;">Total Stock Qty</h6>
                    <h2 class="fw-bold mb-0"><?php echo $total_stock; ?></h2>
                </div>
            </div>
        </div>

        <div class="card mt-5 shadow-sm border-0">
            <div class="card-body">
                <h4 class="fw-bold">Quick Navigation</h4>
                <p class="text-muted">Use the menu above to add, update, or delete products, categories, and suppliers.</p>
            </div>
        </div>
    </div>

    <footer class="text-center text-muted my-4" style="font-size: 0.9rem;">
        KIMBERLYN MEDINA
    </footer>

</body>
</html>