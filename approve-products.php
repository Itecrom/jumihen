<?php
session_start();
require "includes/polowela.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Approve / Reject
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST["product_id"]);
    $action = $_POST["action"] === "approve" ? "approved" : "rejected";

    $stmt = $conn->prepare("UPDATE products SET status=? WHERE id=?");
    $stmt->bind_param("si", $action, $id);
    $stmt->execute();
}

$products = $conn->query("SELECT * FROM products WHERE status='pending'");
?>
<!DOCTYPE html>
<html>
<head>
<title>Approve Products</title>
<style>
body{background:#001f3f;color:white;font-family:Arial}
.table{width:95%;margin:20px auto;background:white;border-radius:8px;color:#000}
th{background:#144999;color:#fff;padding:10px}
td{padding:10px;border-bottom:1px solid #ddd}
button{padding:6px 12px;border:none;border-radius:5px;color:#fff;cursor:pointer}
.approve{background:#28a745}
.reject{background:#dc3545}
</style>
</head>
<body>

<h2 style="text-align:center">Pending Product Approvals</h2>

<table class="table">
<tr>
<th>Product</th>
<th>Seller</th>
<th>Category</th>
<th>Action</th>
</tr>

<?php while($p = $products->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($p['name']) ?></td>
<td><?= htmlspecialchars($p['seller_id']) ?></td>
<td><?= htmlspecialchars($p['category']) ?></td>
<td>
<form method="POST">
<input type="hidden" name="product_id" value="<?= $p['id'] ?>">
<button class="approve" name="action" value="approve">Approve</button>
<button class="reject" name="action" value="reject">Reject</button>
</form>
</td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
