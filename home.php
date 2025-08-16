<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = "junta"; // Demo user
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home - JUMIHEN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f5f7fa;
            color: #333;
        }
        .sidebar {
            background-color: #0d1b2a;
            color: white;
            width: 220px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background-color: #1b263b;
        }
        .main-content {
            margin-left: 220px;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .card h3 {
            color: #0d1b2a;
            font-size: 22px;
            margin-bottom: 5px;
        }
        .section {
            margin-top: 30px;
        }
        .box {
            background: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
        }
        .box h4 {
            margin-bottom: 10px;
            color: #1b263b;
        }
        .list-item {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        footer {
            margin-top: 40px;
            padding: 15px;
            text-align: center;
            background: #0d1b2a;
            color: white;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>JUMIHEN</h2>
    <a href="#">Home</a>
    <a href="#">My Ads</a>
    <a href="#">Categories</a>
    <a href="#">Messages</a>
    <a href="#">My Account</a>
    <a href="#">Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="header">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h1>
        <div>Today: <?php echo date("l, F j"); ?></div>
    </div>

    <!-- USER STATS -->
    <div class="cards">
        <div class="card"><h3>3</h3><p>My Active Ads</p></div>
        <div class="card"><h3>1</h3><p>Pending Ads</p></div>
        <div class="card"><h3>5</h3><p>Messages</p></div>
        <div class="card"><h3>2</h3><p>New Notifications</p></div>
    </div>

    <!-- SECTIONS -->
    <div class="section">
        <div class="box">
            <h4>Latest Listings</h4>
            <div class="list-item">🍔 Restaurant Offer - 20% Discount</div>
            <div class="list-item">💇 Salon Promo - Free Hair Treatment</div>
            <div class="list-item">🔌 Electrician Services Available</div>
        </div>

        <div class="box">
            <h4>Recommended Categories</h4>
            <div class="list-item">Restaurant</div>
            <div class="list-item">Salon</div>
            <div class="list-item">Electrician</div>
        </div>

        <div class="box">
            <h4>Notifications</h4>
            <div class="list-item">Your ad "Summer Promo" has been approved.</div>
            <div class="list-item">Message from "Best Salon" received.</div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        &copy; <?php echo date("Y"); ?> JUMIHEN. All rights reserved.
    </footer>
</div>

</body>
</html>
