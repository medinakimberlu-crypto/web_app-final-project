<?php
include_once 'header.php';
require_once 'db.php';

// Add Supplier
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_supplier'])) {
    $name = trim($_POST['name']);
    $contact = trim($_POST['contact_person']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    
    if (!empty($name)) {
        $stmt = $pdo->prepare("INSERT INTO suppliers (name, contact_person, phone, email) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $contact, $phone, $email]);
        header("Location: suppliers.php");
        exit;
    }
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM suppliers WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: suppliers.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM suppliers ORDER BY id DESC");
$suppliers = $stmt->fetchAll();
?>

<h2 class="fw-bold mb-4">Manage Suppliers</h2>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">Add Supplier</div>
            <div class="card-body">
                <form action="suppliers.php" method="post">
                    <div class="mb-3">
                        <label>Supplier Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Contact Person</label>
                        <input type="text" name="contact_person" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <button type="submit" name="add_supplier" class="btn btn-primary w-100">Save Supplier</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">Supplier List</div>
            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($suppliers as $row): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['contact_person']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td>
                                <a href="suppliers.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete supplier?')">Delete</a>
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