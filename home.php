<?php 
session_start();
$file = 'includes/polowela.php';
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>JUMIHEN BUSSINESS ADDS</title>
    <style>
        body { font-family: Arial; background-color: white; margin:0; }
        header { background-color: blue; padding: 12px; color: white; display:flex; align-items:center; justify-content:space-between; }
        header a { color: white; margin: 0 8px; text-decoration:none; }
        .logo { font-size: 20px; font-weight:bold; }
        .search { margin: 20px; }
        .search input { padding:8px; width: 300px; }
        .item { border:1px solid #ddd; padding:10px; margin:10px; display:inline-block; width:200px; vertical-align:top; }
        .box img {
            width: 25px;
            margin-bottom: 15px;
        }
       footer {
            position: absolute;
            bottom: 5px;
            font-size: 13px;
            color: #ccc;
        }
    </style>
</head>

<header>
       <div class="box">
 <img src="images/logo.png" alt="logo.png">
</header>
<body>

<header>
    <div class="logo">JUMIHEN</div>
        <a href="home.php">🏠 Home</a>
        <a href="upload.php">⬆ Upload</a>
        <a href="about.php">ℹ About Us</a>
    </div>
</header>

<div class="search">
    <form method="get" action="home.php">
        <input type="text" name="q" placeholder="Search product...">
        <input type="submit" value="Search">
    </form>
</div>

<h2 style="margin-left:20px;">Recent Approved Items</h2>
<div style="margin:20px;">

</div>
<footer>© Jumihen Admin 2025</footer>

</body>
</html>
