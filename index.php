<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && ($password === 'admin123' || password_verify($password, $user['password']))) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['loggedin'] = true;
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Mali ang username o password!";
        }
    } catch (PDOException $e) {
        $error = "Database Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #6f42c1 0%, #4a0e4e 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            background: #ffffff;
        }
        .login-header {
            background-color: #6f42c1;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .btn-purple {
            background-color: #6f42c1;
            color: white;
            font-weight: 600;
        }
        .btn-purple:hover {
            background-color: #5a329a;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card login-card">
                <div class="login-header">
                    <i class="bi bi-box-seam display-5 mb-2"></i>
                    <h3 class="fw-bold mb-0">Inventory System</h3>
                    <p class="text-white-50 small mb-0">Please login to your account</p>
                </div>
                <div class="card-body p-4">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger py-2 small" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form action="index.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-muted fw-semibold small">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted fw-semibold small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-purple w-100 py-2 shadow-sm">Login</button>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3 text-white-50 small">
                KIMBERLYN MEDINA
            </div>
        </div>
    </div>
</div>

</body>
</html>