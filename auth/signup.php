<?php
session_start();

// Include DB config
$configFile = '../includes/polowela.php';
if (!file_exists($configFile)) {
    die("Required configuration file missing.");
}
include($configFile);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email    = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    $sql = "INSERT INTO sellers (username,email,password) VALUES ('$username','$email','$password')";
    
    if (mysqli_query($conn, $sql)) {
        $message = "Account created successfully. Please sign in.";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Seller Signup</title>
<style>
body{
    background:#001f3f;
    font-family:Arial;
    display:flex;
    align-items:center;
    justify-content:center;
    height:100vh;
    color:white;
}
.form-box{
    background:#002b80;
    padding:25px;
    border-radius:10px;
    width:320px;
}
input{
    width:100%;
    padding:10px;
    margin:8px 0;
    border:none;
    border-radius:6px;
}
.box {
            background: #000000ff;
            padding: 30px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(124, 122, 122, 0.4);
            text-align: center;
        }
        .box img {
            width: 70px;
            margin-bottom: 15px;
        }
        .box h2 {
            margin-bottom: 20px;
        }
button{
    width:100%;
    padding:10px;
    border:none;
    border-radius:6px;
    background:#0066ff;
    color:white;
    font-weight:bold;
}
a{color:#aee2ff;}
</style>
</head>
<body>
<div class="box">
    
 <img src="../images/logo.png" alt="logo.png">
    <h2>Seller signup</h2>


<form method="POST">
<input type="text" name="username" placeholder="Username" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<input type="file" name="picture" accept="image/*">
<button type="submit">Signup</button>
</form>

<p>Already have an account? <a href="signin.php">Sign In</a></p>
</div>

</body>
</html>
