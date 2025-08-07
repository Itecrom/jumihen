<?php
// Include configuration file
session_start();
$file = 'includes/polowela.php';
if (file_exists($file)) {
    include($file);
} else {
    die("Required configuration file missing.");
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: auth/login.php");
    exit();
}

// Fetch admin info
$admin_id = $_SESSION['admin_id'];
$stmt = $conn->prepare("SELECT * FROM admin WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Jumihen</title>
    <link rel="icon" href="images/logo.jpeg" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="sidebar">
    <div class="logo">
        <img src="images/logo.png" alt="Logo">
        <h4>Jumihen Inc.</h4>
    </div>
    <nav>
        <a href="admin/ggpc.php"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="admin/approve-sellers.php"><i class="fas fa-user-check"></i> Approve sellers</a>
        <a href="admin/approve-products.php"><i class="fas fa-box-open"></i> Approve Products</a>
        <a href="admin/add-product.php"><i class="fas fa-plus"></i> Add Product</a>
        <a href="admin/admins.php"><i class="fas fa-users-cog"></i> Manage Admins</a>
        <a href="admin/edit-profile.php"><i class="fas fa-user-edit"></i> Edit Profile</a>
        <a href="home.php"><i class="fas fa-store"></i> View Store</a>
        
        <a href="auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
    <div class="version">Version 1.0.0</div>
</div>

<div class="main">
    <header>
        <div class="notifications">
            <i class="fas fa-bell"></i>
        </div>
        <div class="admin-menu" tabindex="0">
            <img src="uploads/admin/<?= htmlspecialchars($admin['photo'] ?? 'default.png') ?>" alt="Admin">
            <div class="dropdown">
                <a href="edit-profile.php"><i class="fas fa-user-edit"></i> Edit Profile</a>
                <a href="auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </header>


<footer>
    &copy; Jumihen Inc. 2025 | Developed by Gladys Junta, Getrude Mission, Promise Henderson, and Christina Nkawihe.<br>
        Powered by ITEC ICT E-SOLUTIONS.
</footer>
</div>

</body>
</html>
