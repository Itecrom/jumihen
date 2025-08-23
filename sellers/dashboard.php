<?php
// Check if the seller is logged in

session_start();
if (!isset($_SESSION['seller_id'])) {
    header("Location: ../auth/signin.php");
    exit;
}

include '../includes/polowela.php';

// Fetch seller info
$seller_id = $_SESSION['seller_id'];
$stmt = $conn->prepare("SELECT * FROM sellers WHERE id = ?");
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$name = $stmt->get_result()->fetch_assoc();



// Fetch seller's products
$stmt = $conn->prepare("SELECT * FROM products WHERE seller_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #333; color: white; }
        img.thumb { height: 50px; }
        .btn { padding: 6px 12px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; }
        .btn-danger { background: red; }
    </style>
</head>
<body class="blue-black-theme">

    <h2>Welcome, <?php echo htmlspecialchars($name['name']); ?> 👋</h2>
    <a href="add-product.php" class="btn">+ Add New Product</a>
    <a href="edit-product.php" class="btn">- Edit Product</a>
    <a href="delete-product.php" class="btn">- Delete Product</a>
    <a href="auth/logout.php" class="btn" style="float:right; margin-top:10px;">Logout</a>

    <h3>Your Products</h3>

    <?php if ($result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Thumbnail</th>
                <th>Title</th>
                <th>Category</th>
                <th>Price (MK)</th>
                <th>Status</th>
                <th>Views</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><img src="../uploads/<?php echo $row['image']; ?>" class="thumb" alt="Product"></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td><?php echo number_format($row['price'], 2); ?></td>
                <td><?php echo ucfirst($row['status']); ?></td>
                <td><?php echo (int)$row['views']; ?></td>
                <td>
                    <a href="edit-product.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                    <a href="delete-product.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>You have not added any products yet.</p>
    <?php endif; ?>

</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
