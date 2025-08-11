<?php
session_start();
$file = 'includes/polowela.php';
if (file_exists($file)) {
    include($file);
} else {
    die("Required configuration file missing.");
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch admin info
$admin_id = $_SESSION['admin_id'];
$stmt = $conn->prepare("SELECT * FROM admin WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();


// Approve user via form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve_user'])) {
    $userId = intval($_POST['user_id']);
    $conn->query("UPDATE sellers SET status = 'approved' WHERE id = $userId");
}

// Notifications, apapa ndipamene pazitolera ma Notification mukakhala kuti mwaponya chinthu kapena seller waponya chinthu
$newsellers = $conn->query("SELECT COUNT(*) AS total FROM sellers WHERE status = 'pending'")->fetch_assoc()['total'];
$newProducts = $conn->query("SELECT COUNT(*) AS total FROM products WHERE status = 'pending'")->fetch_assoc()['total'];
$recentAdmins = $conn->query("SELECT COUNT(*) AS total FROM admin WHERE created_at >= NOW() - INTERVAL 7 DAY")->fetch_assoc()['total'];
$recentSignups = $conn->query("SELECT COUNT(*) AS total FROM sellers WHERE created_at >= NOW() - INTERVAL 7 DAY")->fetch_assoc()['total'];
$recentProductPosts = $conn->query("SELECT COUNT(*) AS total FROM products WHERE created_at >= NOW() - INTERVAL 7 DAY")->fetch_assoc()['total'];

// Prepare daily trends data
$days = [];
for ($i = 6; $i >= 0; $i--) {
    $days[] = date('Y-m-d', strtotime("-$i days"));
}

// Fetch categories for daily trends, izizi zizichokera mu table ya product_views
$categories = [];
$catRes = $conn->query("SELECT DISTINCT category FROM product_views");
while ($cat = $catRes->fetch_assoc()) {
    $categories[] = $cat['category'];
}

// Prepare datasets for each category
$datasets = [];
foreach ($categories as $cat) {
    $dataPoints = [];
    foreach ($days as $day) {
        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM product_views WHERE category = ? AND DATE(viewed_at) = ?");
        $stmt->bind_param("ss", $cat, $day);
        $stmt->execute();
        $count = $stmt->get_result()->fetch_assoc()['total'];
        $dataPoints[] = $count;
    }
    $color = sprintf("rgba(%d,%d,%d,0.8)", rand(50,200), rand(50,200), rand(50,200));
    $datasets[] = [
        "label" => $cat,
        "data" => $dataPoints,
        "fill" => false,
        "borderColor" => $color,
        "tension" => 0.3
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Admin Dashboard for Jumihen - Manage sellers, products, and view analytics.">
    <meta name="keywords" content="admin, dashboard, jumihen, sellers, products, analytics">
    <meta name="author" content="Gladys Junta, Getrude Mission, Promise Henderson, Christina Nkawihe">

    <title>Admin Dashboard - Jumihen</title>
    <link rel="icon" href="images/logo.jpeg" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/admin.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>

<div class="sidebar">
    <div class="logo">
        <img src="images/logo.png" alt="Logo">
        <h4>Jumihen Inc.</h4>
    </div>
    <nav>
        <a href="ggpc.php"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="approve-sellers.php"><i class="fas fa-user-check"></i> Approve sellers</a>
        <a href="approve-products.php"><i class="fas fa-box-open"></i> Approve Products</a>
        <a href="add-product.php"><i class="fas fa-plus"></i> Add Product</a>
        <a href="admins.php"><i class="fas fa-users-cog"></i> Manage Admins</a>
        <a href="edit-profile.php"><i class="fas fa-user-edit"></i> Edit Profile</a>
        <a href="store.php"><i class="fas fa-store"></i> View Store</a>
        
        <a href="auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
    <div class="version">Version 1.0.0</div>
</div>

<div class="main">
    <header>
        <div class="notifications">
            <i class="fas fa-bell"></i>
            <span class="count"><?= $newsellers + $newProducts ?></span>
        </div>
        <div class="admin-menu" tabindex="0">


            <img src="uploads/adminprofiles/<?= htmlspecialchars($admin['photo'] ?? 'default.png') ?>" alt="Admin">
            <div class="dropdown">
                <a href="edit-profile.php"><i class="fas fa-user-edit"></i> Edit Profile</a>
                <a href="auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </header>

    <div class="content">
        <h2>Welcome, <?= htmlspecialchars($admin['username']) ?> 👋</h2>
        <div class="cards">
            <div class="card"><h3>New User Signups</h3><p><?= $newsellers ?> pending</p></div>
            <div class="card"><h3>New Product Submissions</h3><p><?= $newProducts ?> pending</p></div>
            <div class="card"><h3>Admins</h3><p><?= $recentAdmins ?></p></div>
            <div class="card"><h3>Recent User Signups</h3><p><?= $recentSignups ?></p></div>
            <div class="card"><h3>Recent Product Posts</h3><p><?= $recentProductPosts ?></p></div>
        </div>

    <h3>Pending User Approvals</h3>
<table style="width:100%; background:white; border-collapse:collapse; margin-top:20px;">
    <thead>
        <tr style="background:#144999; color:#fff;">
            <th style="padding:10px;">Name</th>
            <th style="padding:10px;">Email</th>
            <th style="padding:10px;">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $pendingsellers = $conn->query("SELECT id, name, email FROM sellers WHERE status = 'pending'");
        while ($u = $pendingsellers->fetch_assoc()):
        ?>
        <tr style="border-bottom:1px solid #ccc;">
            <td style="padding:10px;"><?= htmlspecialchars($u['name']) ?></td>
            <td style="padding:10px;"><?= htmlspecialchars($u['email']) ?></td>
            <td style="padding:10px;">
                <form method="POST" style="margin:0;">
                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                    <button name="approve_user" style="background:#28a745; color:white; padding:5px 10px; border:none; border-radius:4px;">
                        Approve
                    </button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$result = $conn->query("SELECT * FROM sellers WHERE status='pending'");
echo "<h3>Pending Approvals</h3>";
while ($row = $result->fetch_assoc()) {
    echo "<p>{$row['name']} ({$row['email']}) 
        <a href='approve-sellers.php?id={$row['id']}'>Approve</a></p>";
}
?>


    </div>

    <div class="chart-container">
        <h3>Daily Product Views by Category (Last 7 Days)</h3>
        <canvas id="dailyTrendsChart"></canvas>
    </div>

    <footer>
        &copy; Jumihen Inc. 2025 | Developed by Gladys Junta, Getrude Mission, Promise Henderson, and Christina Nkawihe.<br>
        Powered by ITEC ICT E-SOLUTIONS.
    </footer>
</div>

<script>
const ctx = document.getElementById('dailyTrendsChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($days) ?>,
        datasets: <?= json_encode($datasets) ?>
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: { mode: 'index', intersect: false },
            legend: { display: true, position: 'bottom' }
        },
        interaction: { mode: 'nearest', axis: 'x', intersect: false },
        scales: {
            x: { title: { display: true, text: 'Date' }, ticks: { color: '#333' } },
            y: { beginAtZero: true, title: { display: true, text: 'Views' }, ticks: { color: '#333' } }
        }
    }
});
</script>

</body>
</html>