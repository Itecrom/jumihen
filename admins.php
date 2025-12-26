<?php
session_start();
require "includes/polowela.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Delete admin
if(isset($_GET["delete"])){
    $id = intval($_GET["delete"]);
    $conn->query("DELETE FROM admin WHERE id=$id");
}

$admins = $conn->query("SELECT * FROM admin");
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Admins</title>
<style>
body{background:#001f3f;color:white;font-family:Arial}
.table{width:95%;margin:20px auto;background:white;border-radius:8px;color:#000}
th{background:#144999;color:#fff;padding:10px}
td{padding:10px;border-bottom:1px solid #ddd}
a.btn{padding:5px 10px;border-radius:5px;text-decoration:none;color:#fff}
.edit{background:#0066ff}
.del{background:#dc3545}
</style>
</head>
<body>

<h2 style="text-align:center">Manage Admin Accounts</h2>

<table class="table">
<tr>
<th>Name</th>
<th>Email</th>
<th>Actions</th>
</tr>

<?php while($a = $admins->fetch_assoc()): ?>
<tr>
<td><?= htmlspecialchars($a['username']) ?></td>
<td><?= htmlspecialchars($a['email']) ?></td>
<td>
<a class="btn edit" href="edit-profile-admin.php?id=<?= $a['id'] ?>">Edit</a>
<a class="btn del" href="?delete=<?= $a['id'] ?>" onclick="return confirm('Delete admin?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>

</body>
</html>
