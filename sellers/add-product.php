<?php
session_start();
include("includes/polowela.php"); // DB connection

$message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $description = trim($_POST['description']);
    $contact = trim($_POST['contact']);
    $category = trim($_POST['category']);

    $photoName = "";
    $videoName = "";

    // Handle Photo
    if (!empty($_FILES['photo']['name'])) {
        $photoName = time() . "_" . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . $photoName);
    }

    // Handle Video
    if (!empty($_FILES['video']['name'])) {
        $videoName = time() . "_" . basename($_FILES['video']['name']);
        move_uploaded_file($_FILES['video']['tmp_name'], "uploads/" . $videoName);
    }

    // Insert into products
    $stmt = $conn->prepare("INSERT INTO products (description, photo, video, contact, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("ssss", $description, $photoName, $videoName, $contact);
    if ($stmt->execute()) {
        // Insert category into product_views
        $productId = $stmt->insert_id;
        $stmt2 = $conn->prepare("INSERT INTO product_views (product_id, category) VALUES (?, ?)");
        $stmt2->bind_param("is", $productId, $category);
        $stmt2->execute();
        $stmt2->close();

        $message = "✅ Upload successful! Waiting for admin approval.";
    } else {
        $message = "❌ Failed to upload. Try again.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload - Jumihen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f4f8ff;
        }
        header {
            background: linear-gradient(90deg, #002b55, #004c99);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 40px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }
        header img {
            height: 55px;
        }
        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            transition: 0.3s;
        }
        nav a i {
            margin-right: 6px;
        }
        nav a:hover {
            color: #ffcc00;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        }
        h2 {
            text-align: center;
            color: #003366;
            margin-bottom: 20px;
        }
        form label {
            font-weight: bold;
            color: #004c99;
            display: block;
            margin-top: 15px;
        }
        form input, form textarea, form select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
        }
        form button {
            background: #004c99;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        form button:hover {
            background: #003366;
        }
        .msg {
            text-align: center;
            margin-top: 15px;
            font-size: 16px;
        }
        footer {
            text-align: center;
            background: #002b55;
            color: white;
            padding: 15px;
            margin-top: 40px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header>
        <img src="../images/logo.png" alt="Logo">
        <nav>
            <a href="../home.php"><i class="fa fa-home"></i> Home</a>
            <a href="add-product.php"><i class="fa fa-upload"></i> Upload</a>
            <a href="../about us.php"><i class="fa fa-info-circle"></i> About Us</a>
        </nav>
    </header>

    <!-- CONTENT -->
    <div class="container">
        <h2><i class="fa fa-upload"></i> Upload Your Product</h2>
        <?php if ($message): ?>
            <p class="msg"><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Description:</label>
            <textarea name="description" required></textarea>

            <label>Contact:</label>
            <input type="text" name="contact" placeholder="+265 999 000 000" required>

            <label>Category:</label>
            <select name="category" required>
                <option value="">-- Select Category --</option>
                <option>Food</option>
                <option>Clothes</option>
                <option>Electronics</option>
                <option>School</option>
            </select>

            <label>Upload Photo:</label>
            <input type="file" name="photo" accept="image/*">

            <label>Upload Video:</label>
            <input type="file" name="video" accept="video/*">

            <button type="submit"><i class="fa fa-cloud-upload-alt"></i> Submit for Approval</button>
        </form>
    </div>

    <!-- FOOTER -->
    <footer>
        ©jumihen 2025
    </footer>
</body>
</html>