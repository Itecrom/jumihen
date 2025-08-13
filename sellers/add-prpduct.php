<?php 
session_start();
$file = 'includes/polowela.php';
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Item</title>
    <style>
        body { font-family: Arial; background-color: white; margin:0; }
        header { background-color: blue; padding: 15px; color: white; }
        header a { color: white; margin: 0 10px; text-decoration:none; }
        form { background: #f5f5f5; padding:20px; margin:20px auto; width:400px; border-radius:5px; }
        .footer {
            position: absolute;
            bottom: 5px;
            font-size: 13px;
            color: #ccc;
        }
        input, textarea, select { width:100%; padding:8px; margin:5px 0; }
        button { background: blue; color: white; padding:10px; border:none; cursor:pointer; }
    </style>
</head>
<body>

<header>
    <div class="logo">JUMIHEN</div>
        <a href="../home.php">🏠 Home</a>
        <a href="sellers/add-prpduct.php">⬆ Upload</a>
        <a href="about.php">ℹ About Us</a>
    </div>
</header>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $cat = $_POST['category'];
    $contact = $_POST['contact'];

    $photo = $_FILES['photo']['name'];
    $video = $_FILES['video']['name'];

    move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/".$photo);
    move_uploaded_file($_FILES['video']['tmp_name'], "uploads/".$video);

    $sql = "INSERT INTO uploads (title, description, category, photo, video, contact) 
            VALUES ('$title', '$desc', '$cat', '$photo', '$video', '$contact')";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;text-align:center;'>Upload sent for admin approval!</p>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <select name="category" required>
        <option value="">-- Select Category --</option>
        <option value="Food">Food</option>
        <option value="Clothes">Clothes</option>
        <option value="Electronics">Electronics</option>
        <option value="School">School</option>
    </select>
    <input type="text" name="contact" placeholder="Contact Info" required>
    <label>Photo:</label>
    <input type="file" name="photo" accept="image/*">
    <label>Video:</label>
    <input type="file" name="video" accept="video/*">
    <button type="submit">Submit for Approval</button>
</form>
<footer>© Jumihen Admin 2025</footer>
</body>
</html>

