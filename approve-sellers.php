<?php
session_start();
include 'includes/polowela.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: auth/signin.php");
    exit();
}

// Approve user
if (isset($_GET['approve'])) {
    $user_id = intval($_GET['approve']);
    $stmt = $conn->prepare("UPDATE sellers SET status = 'Approved' WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    header("Location: approve-sellers.php?msg=approved");
    exit();
}

// Delete user
if (isset($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    header("Location: approve-sellers.php?msg=deleted");
    exit();
}

// Search filter
$filter = '';
$params = [];
if (!empty($_GET['search'])) {
    $filter = "AND (name LIKE ? OR email LIKE ?)";
    $searchTerm = '%' . $_GET['search'] . '%';
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

// Pagination logic
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Count total records
$countQuery = "SELECT COUNT(*) FROM sellers WHERE status = 'pending'";
$countStmt = $conn->prepare($countQuery);
if (!empty($params)) $countStmt->bind_param("ss", ...$params);
$countStmt->execute();
$countResult = $countStmt->get_result();
$total = $countResult->fetch_row()[0];
$totalPages = ceil($total / $limit);

// Fetch paginated users
$query = "SELECT * FROM sellers WHERE status = 'pending' ORDER BY created_at DESC LIMIT ?, ?";
$params[] = $offset;
$params[] = $limit;
$types = str_repeat('s', count($params) - 2) . "ii"; // string for search terms, int for limit/offset

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approve Sellers - Admin Panel</title>

    <a href="ggpc.php" class="btn btn-primary" style="margin: 10px 0; display: inline-block;">
    ← Back to Dashboard </a>

    <link rel="icon" type="image/png" href="images/logo.jpeg">
    <style>
        :root {
            --bg-light: #f1f1f1;
            --bg-dark: #121212;
            --text-light: #333;
            --text-dark: #eee;
            --container-bg-light: #fff;
            --container-bg-dark: #1e1e1e;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-light);
            padding: 20px;
            transition: 0.3s ease;
        }

        .dark-mode {
            background-color: var(--bg-dark);
            color: var(--text-dark);
        }

        .container {
            background: var(--container-bg-light);
            padding: 25px;
            border-radius: 8px;
            max-width: 1000px;
            margin: 0 auto;
            transition: 0.3s ease;
        }

        .dark-mode .container {
            background: var(--container-bg-dark);
        }

        h2 {
            margin-bottom: 20px;
        }

        .controls {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        input[type="text"] {
            padding: 8px;
            width: 60%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button.toggle-btn {
            padding: 8px 12px;
            background: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #2a3f54;
            color: white;
        }

        tr:hover {
            background: #f9f9f9;
        }

        .dark-mode tr:hover {
            background: #2c2c2c;
        }

        a.btn {
            padding: 6px 12px;
            text-decoration: none;
            color: #fff;
            border-radius: 5px;
            font-size: 14px;
        }

        .approve-btn {
            background: #28a745;
        }

        .delete-btn {
            background: #dc3545;
        }

        .msg {
            padding: 10px;
            background: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
            margin-bottom: 20px;
        }

        .dark-mode .msg {
            background: #204c2a;
            color: #cde5d1;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Pending Sellers Approval</h2>

    <div class="controls">
        <form method="get" style="margin:0; flex: 1;">
            <input type="text" name="search" oninput="this.form.submit()" placeholder="Search by name or email" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        </form>
        <button class="toggle-btn" onclick="toggleDarkMode()">🌓 Toggle Dark Mode</button>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="msg">
            User <?= htmlspecialchars($_GET['msg']) ?> successfully.
        </div>
    <?php endif; ?>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registered At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= date("M d, Y", strtotime($row['created_at'])) ?></td>
                    <td>
                        <a href="?approve=<?= $row['id'] ?>" class="btn approve-btn" onclick="return confirm('Approve this user?')">Approve</a>
                        <a href="?delete=<?= $row['id'] ?>" class="btn delete-btn" onclick="return confirm('Delete this user?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No users waiting for approval.</p>
    <?php endif; ?>

    <?php if ($totalPages > 1): ?>
    <div style="margin-top: 20px;">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($_GET['search'] ?? '') ?>"
               style="margin-right: 5px; padding: 6px 12px; background: <?= $i == $page ? '#2a3f54' : '#ccc' ?>; color: white; text-decoration: none; border-radius: 4px;">
               <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

</div>

<script>
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
}
</script>

</body>
</html>
