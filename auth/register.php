<?php
//Apa ndekuti tapanga include kumene kuli ma login aku server kuti register athe kupita kukasiya zinthu ku Database
$file = '../includes/polowela.php';

// Check if the file exists before including it
if (file_exists($file)) {
    include($file);
} else {
    die("Required configuration file missing.");
}

// Start the session
session_start();

// Check if the user is already logged in
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO admins (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php?success=1");
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/logo.jpeg">
    <title>Admin Register</title>
</head>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Signup - Jumihen</title>
    <link rel="icon" type="image/png" href="../images/logo.jpeg">
    
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
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
    <image src="../images/logo.jpeg" alt="Logo">
    <h2>admin register</h2>

    <? // Display error message if any
      if (isset($error)) echo "<p style='color: #ff7373;'>$error</p>"; ?>

    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="picture">Picture:</label>
        <input type="file" id="picture" name="picture" accept="image/*"><br><br>

         <div class="btn-row">
            <button class="btn">Register</button>
            <span class="login-link">Already have an account? <a href="login.php">Login</a></span>
        </div>       
    </form>
</div>

<footer>© Jumihen Admin 2025</footer>

</body>
</html>