<?php
session_start();

// Include DB config
$configFile = '../includes/polowela.php';
if (!file_exists($configFile)) {
    die("Required configuration file missing.");
}
include($configFile);

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Handle image upload
    $picture = null;
    if (!empty($_FILES['picture']['name'])) {
        $uploadDir = '../uploads/admin/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('admin_') . "." . strtolower($ext);
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['picture']['tmp_name'], $targetFile)) {
            $picture = $filename;
        } else {
            $error = "Failed to upload profile picture.";
        }
    }

    if (!$error) {
        $stmt = $conn->prepare("INSERT INTO admin (username, email, password, picture) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password, $picture);

        if ($stmt->execute()) {
            header("Location: login.php?success=1");
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup - Jumihen</title>
    <link rel="icon" type="image/png" href="../images/logo.jpeg">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #144999ff, #1b2836);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: #ffffff;
            animation: fadeIn 1.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .box {
            background: #121e2a;
            padding: 30px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.4);
            text-align: center;
        }
        .box img {
            width: 70px;
            margin-bottom: 15px;
        }
        .box h2 {
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: #e9e9e9;
            font-size: 15px;
        }
        .btn-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        button.btn {
            background: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background: #0056b3;
        }
        .login-link {
            font-size: 14px;
        }
        .login-link a {
            color: #00cfff;
            text-decoration: none;
        }
        footer {
            position: absolute;
            bottom: 5px;
            font-size: 13px;
            color: #ccc;
        }
    </style>
</head>
<body>
<div class="box">
   <img src="images/logo.png" alt="logo.png">
    <h2>Admin Register</h2>

    <?php
    // Display error message if exists 
    if (!empty($error)): ?>
        <p style="color: #ff7373;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="file" name="picture" accept="image/*">
        
        <div class="btn-row">
            <button class="btn" type="submit">Register</button>
            <span class="login-link">Already have an account? <a href="login.php">Login</a></span>
        </div>
    </form>
</div>

<footer>© Jumihen Admin 2025</footer>
</body>
</html>
