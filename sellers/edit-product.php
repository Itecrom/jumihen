<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['seller_id'])) {
    header("Location: ../store.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];
$product_id = $_GET['id'] ?? 0;
$message = '';

// Fetch product
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND seller_id = ?");
$stmt->bind_param("ii", $product_id, $seller_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found or unauthorized.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $img_name = $product['image'];

    // Check if new image uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $img_name = uniqid() . '_' . basename($_FILES['image']['name']);
        $target_dir = "../uploads/";
        $target_file = $target_dir . $img_name;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $message = "Error uploading new image.";
        }
    }

    if (!$message) {
        $stmt = $conn->prepare("UPDATE products SET title = ?, description = ?, price = ?, category = ?, image = ? WHERE id = ? AND seller_id = ?");
        $stmt->bind_param("ssdssii", $title, $description, $price, $category, $img_name, $product_id, $seller_id);
        if ($stmt->execute()) {
            $message = "Product updated successfully.";
        } else {
            $message = "Error updating product.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head><title>Edit Product</title></head>
<body>
<h2>Edit Product</h2>
<?php if($message): ?><p><?= htmlspecialchars($message) ?></p><?php endif; ?>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?= htmlspecialchars($product['title']) ?>" required><br>
    <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea><br>
    <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($product['price']) ?>" required><br>
    <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" required><br>
    <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" width="100" alt="Current Image"><br>
    <input type="file" name="image" accept="image/*"><br>
    <button type="submit">Update Product</button>
</form>
<a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
