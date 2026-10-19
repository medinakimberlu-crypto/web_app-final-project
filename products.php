<?php
include_once 'header.php';
require_once 'db.php';

// Add Product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $category_id = intval($_POST['category_id']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);

    if (!empty($name)) {
        $stmt = $pdo->prepare("INSERT INTO products (name, category_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $category_id, $quantity, $price]);
        header("Location: products.php");
        exit;
    }
}

// Delete Product
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: products.php");
    exit;
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$products = $pdo->query("SELECT products.*, categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id ORDER BY products.id DESC")->fetchAll();
?>

<h2 class="fw-bold mb-4">Manage Products</h2>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">Add Product</div>
            <div class="card-body">
                <form action="products.php" method="post">
                    <div class="mb-3">
                        <label>Product Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Quantity</label>
                        <input type="number" name="quantity" class="form-control" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label>Price (₱)</label>
                        <input type="number" step="0.01" name="price" class="form-control" min="0" required>
                    </div>
                    <button type="submit" name="add_product" class="btn btn-primary w-100">Save Product</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">Product List</div>
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $row): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['category_name'] ?? 'Uncategorized'); ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td>₱<?php echo number_format($row['price'], 2); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="products.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete product?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>