<?php
$file = '../includes/polowela.php';
if (file_exists($file)) {
    include($file);
} else {
    die("Required configuration file missing.");
}
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST["email"];
    $password = $_POST["password"];

    $query = mysqli_query($conn, "SELECT * FROM sellers WHERE email='$email' LIMIT 1");
    $user  = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["seller_id"] = $user["id"];
        header("Location: ../home.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Seller Signin</title>
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
    <h2>Seller Signin</h2>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
        </head>
        <body>
            
        </body>
        </html>
 <img src="../images/logo.png" alt="logo.png">
<p><?php echo $error; ?></p>
<form method="POST">
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit">Signin</button>
</form>

<p>Don’t have an account? <a href="signup.php">Create one</a></p>
</div>

</body>
</html>
