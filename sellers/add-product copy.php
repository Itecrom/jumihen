<?php
session_start();
include '../includes/config.php';
include '../includes/resize.php';

if (!isset($_SESSION['seller_id'])) {
    header("Location: ../store.php");
    exit();
}

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $seller_id = $_SESSION['seller_id'];

    // Handle image
    $folder = date("Y") . "/" . date("m");
    $target_dir = "../uploads/" . $folder;
    if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

    $file = $_FILES['image']['tmp_name'];
    $filename = uniqid() . ".jpg";
    $full_path = "$target_dir/$filename";

    if (resizeImage($file, $full_path, 600)) {
        $db_path = "$folder/$filename";

        $stmt = $conn->prepare("INSERT INTO products (seller_id, title, description, price, image, approved) VALUES (?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("issds", $seller_id, $title, $desc, $price, $db_path);
        if ($stmt->execute()) {
            $msg = "Product submitted! Awaiting approval.";
        } else {
            $msg = "Failed to submit product.";
        }
    } else {
        $msg = "Image upload failed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Product</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="blue-black-theme">

<h2>Add New Product</h2>
<p style="color: yellow"><?= $msg ?></p>

<form method="POST" enctype="multipart/form-data">
    <label>Product Title</label>
    <input type="text" name="title" required>

    <label>Description</label>
    <textarea name="description" rows="4" required></textarea>

    <label>Price (MK)</label>
    <input type="number" name="price" step="0.01" required>

    <label>Product Image</label>
    <input type="file" name="image" accept="image/*" onchange="previewImage(event)" required>
    <img id="preview" style="max-width:200px; display:block; margin:10px 0;"/>

    <button type="submit" class="btn">Submit Product</button>
</form>

<script>
function previewImage(e) {
  const reader = new FileReader();
  reader.onload = function(){
    document.getElementById('preview').src = reader.result;
  }
  reader.readAsDataURL(e.target.files[0]);
}
</script>

</body>
</html>
