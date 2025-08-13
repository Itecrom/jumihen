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
        .logo { font-size: 25px; font-weight:bold; }
        .search { margin: 20px; }
        .search input { padding:8px; width: 300px; }
        .item { border:1px solid #ddd; padding:10px; margin:10px; display:inline-block; width:200px; vertical-align:top; }
        .box img {
            width: 100px;
            margin-bottom: 30px;
            float: left;
       .footer {
            position: absolute;
            bottom: 5px;
            font-size: 13px;
            color: #07021aff;
        }
    </style>
</head>

<header>
       <div class="box">
            <img src="images/logo.png" alt="logo.png">
        </div>
 
</header>
<body>

<header>
    <div class="logo">JUMIHEN</div>
        <a href="home.php">🏠 Home</a>
        <a href="sellers/add-prpduct.php">⬆ Upload</a>
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
