<?php
session_start();
require "includes/polowela.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$msg = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = $_POST["name"];
    $category = $_POST["category"];
    $price = $_POST["price"];

    $image = "uploads/products/".time()."_".basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $image);

    $status = "approved"; // admin uploads → auto approved

    $stmt = $conn->prepare(
        "INSERT INTO products (name,category,price,image,status,created_at)
         VALUES (?,?,?,?,?,NOW())"
    );
    $stmt->bind_param("ssdss",$name,$category,$price,$image,$status);

    $msg = $stmt->execute() ? "Product added successfully" : "Error adding product";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Product</title>
<style>
body{background:#001f3f;color:white;font-family:Arial;display:flex;justify-content:center}
form{background:#002b80;padding:25px;border-radius:12px;width:360px}
input,select{width:100%;padding:10px;margin:8px 0;border-radius:6px;border:none}
button{background:#0066ff;color:white;padding:10px;border:none;border-radius:6px}
</style>
</head>
<body>

<form method="POST" enctype="multipart/form-data">
<h2>Add Product</h2>
<p><?= $msg ?></p>

<input type="text" name="name" placeholder="Product name" required>
<input type="text" name="category" placeholder="Category" required>
<input type="number" step="0.01" name="price" placeholder="Price" required>

<label>Upload Image</label>
<input type="file" name="image" required>

<button type="submit">Save Product</button>
</form>

</body>
</html>
