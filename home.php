<<<<<<< HEAD
<<<<<<< HEAD

=======
<?php 
=======
<?php
>>>>>>> 784eb90aa1aa6379843944486bcb0aab6a82f3b4
session_start();
include("includes/polowela.php"); // database connection

// Fetch approved products with categories
$query = "
    SELECT p.id, p.description, p.photo, p.video, p.contact, pv.category
    FROM products p
    LEFT JOIN product_views pv ON p.id = pv.product_id
    WHERE p.status = 'approved'
    ORDER BY p.created_at DESC
";
$result = $conn->query($query);
$items = [];
while ($row = $result->fetch_assoc()) {
    $category = $row['category'] ? $row['category'] : 'Uncategorized';
    $items[$category][] = $row;
}

// Ma examples okonzedwa kale ngati palibe data mu DB
$examples = [
    "Food" => [
        [
            "photo" => "examples/food1.jpg",
            "video" => "",
            "contact" => "+265 999 123 456",
            "description" => "Fresh mangoes available at a good price!"
        ],
        [
            "photo" => "examples/food2.jpg",
            "video" => "",
            "contact" => "+265 888 222 333",
            "description" => "Delicious homemade cakes for your events."
        ]
    ],
    "Clothes" => [
        [
            "photo" => "examples/clothes1.jpg",
            "video" => "",
            "contact" => "+265 991 444 555",
            "description" => "Trendy jackets available in all sizes."
        ]
    ],
    "Electronics" => [
        [
            "photo" => "",
            "video" => "examples/electronics1.mp4",
            "contact" => "+265 880 555 666",
            "description" => "Affordable smartphone with high performance."
        ]
    ],
    "School" => [
        [
            "photo" => "examples/school1.jpg",
            "video" => "",
            "contact" => "+265 887 777 888",
            "description" => "Quality school uniforms at reasonable prices."
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Homepage - Jumihen</title>
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
            position: sticky;
            top: 0;
            z-index: 1000;
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
            padding: 30px;
            max-width: 1100px;
            margin: auto;
        }
        h2 {
            color: #003366;
            border-left: 6px solid #0055aa;
            padding-left: 10px;
            margin-top: 40px;
            font-size: 22px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
            padding: 15px;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card img, .card video {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .card p {
            margin: 6px 0;
            color: #333;
        }
        .card strong {
            color: #004c99;
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
        <img src="images/logo.png" alt="Logo">
        <nav>
            <a href="index.php"><i class="fa fa-home"></i> Home</a>
            <a href="sellers/add-product.php"><i class="fa fa-upload"></i> Upload</a>
            <a href="about us.php"><i class="fa fa-info-circle"></i> About Us</a>
        </nav>
    </header>

    <!-- CONTENT -->
    <div class="container">
        <?php if (!empty($items)): ?>
            <?php foreach ($items as $category => $products): ?>
                <h2><?php echo htmlspecialchars($category); ?></h2>
                <div class="grid">
                    <?php foreach ($products as $product): ?>
                        <div class="card">
                            <?php if (!empty($product['photo'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($product['photo']); ?>" alt="">
                            <?php endif; ?>
                            <?php if (!empty($product['video'])): ?>
                                <video controls>
                                    <source src="uploads/<?php echo htmlspecialchars($product['video']); ?>" type="video/mp4">
                                </video>
                            <?php endif; ?>
                            <p><strong>Contact:</strong> <?php echo htmlspecialchars($product['contact']); ?></p>
                            <p><?php echo htmlspecialchars($product['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Show Examples if no approved products -->
            <?php foreach ($examples as $category => $products): ?>
                <h2><?php echo htmlspecialchars($category); ?> (Examples)</h2>
                <div class="grid">
                    <?php foreach ($products as $product): ?>
                        <div class="card">
                            <?php if (!empty($product['photo'])): ?>
                                <img src="<?php echo htmlspecialchars($product['photo']); ?>" alt="">
                            <?php endif; ?>
                            <?php if (!empty($product['video'])): ?>
                                <video controls>
                                    <source src="<?php echo htmlspecialchars($product['video']); ?>" type="video/mp4">
                                </video>
                            <?php endif; ?>
                            <p><strong>Contact:</strong> <?php echo htmlspecialchars($product['contact']); ?></p>
                            <p><?php echo htmlspecialchars($product['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<<<<<<< HEAD
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
<div>
<footer>© Jumihen Admin 2025</footer>
</div>

>>>>>>> 34a02bb3668f42de357e3843f48b91409908d879
=======
>>>>>>> 784eb90aa1aa6379843944486bcb0aab6a82f3b4

    <!-- FOOTER -->
    <footer>
        ©jumihen 2025
    </footer>
</body>
</html>