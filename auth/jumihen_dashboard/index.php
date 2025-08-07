<?php
$file = '../includes/polowela.php';
if (file_exists($file)) {
    include($file);
} else {
    die("Required configuration file missing.");
}
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header("Location: ../ggpc.php"); // Change this if your dashboard is somewhere else
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JUMIHEN Dashboard</title>
</head>
<head>
  <style>
    {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', sans-serif;
}

body {
  background-color: #f2f8ff;
  color: #333;
}

.container {
  display: flex;
  min-height: 100vh;
}

/* Sidebar */
.sidebar {
  width: 220px;
  background-color: #007bff;
  color: white;
  padding: 20px;
}

.logo {
  font-size: 24px;
  margin-bottom: 30px;
}

.sidebar ul {
  list-style: none;
}

.sidebar ul li {
  padding: 10px;
  cursor: pointer;
  border-radius: 5px;
}

.sidebar ul li:hover,
.sidebar ul .active {
  background-color: #0056b3;
}

/* Main Content */
.main-content {
  flex-grow: 1;
  padding: 20px;
  background-color: #fff;
}

header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

header h1 {
  color: #007bff;
}

.admin {
  background-color: #f0f0f0;
  padding: 5px 10px;
  border-radius: 4px;
}

/* Stats */
.stats {
  display: flex;
  gap: 15px;
  margin-bottom: 20px;
}

.card {
  flex: 1;
  background-color: #e6f0ff;
  padding: 20px;
  border-left: 5px solid #007bff;
  border-radius: 5px;
  font-weight: bold;
}

.card span {
  font-size: 14px;
  color: #555;
}

/* Panels */
.panels {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 20px;
}

.panel {
  background-color: #f9f9f9;
  padding: 15px;
  border-radius: 6px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.panel h3 {
  color: #007bff;
  margin-bottom: 10px;
}

.panel ul {
  margin-bottom: 10px;
}

.panel input[type="text"] {
  width: 100%;
  padding: 6px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.panel button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 6px 10px;
  margin: 5px 5px 5px 0;
  border-radius: 4px;
  cursor: pointer;
}

.panel button:hover {
  background-color: #0056b3;
}

.panel a {
  display: inline-block;
  margin-top: 8px;
  color: #007bff;
  text-decoration: none;
}

.panel a:hover {
  text-decoration: underline;
}

table {
  width: 100%;
}

table td {
  padding: 5px;
}
 .footer {
            position: absolute;
            bottom: 5px;
            font-size: 13px;
            color: #ccc;
        }
  </style>
</head>
<body>
  <div class="container">
    <aside class="sidebar">
      <h2 class="logo">JUMIHEN</h2>
      <nav>
        <ul>
          <li class="active">Dashboard</li>
          <li>Manage</li>
          <li>Users</li>
          <li>Ancage</li>
          <li>Console</li>
        </ul>
      </nav>
    </aside>

    <main class="main-content">
      <header>
        <h1>Dashboard</h1>
        <div class="admin">Admin ▾</div>
      </header>

      <section class="stats">
        <div class="card">1,320<br /><span>Total Ads</span></div>
        <div class="card">980<br /><span>Total Users</span></div>
        <div class="card">12<br /><span>Total Categories</span></div>
        <div class="card">86<br /><span>Active Listings Today</span></div>
        <div class="card">14<br /><span>Pending Approvals</span></div>
      </section>

      <section class="panels">
        <div class="panel">
          <h3>Manage Ads</h3>
          <input type="text" placeholder="Search Ads by Name / ID / User" />
          <button>Approve</button>
          <button>Reject</button>
        </div>

        <div class="panel">
          <h3>Manage Categories</h3>
          <ul>
            <li>Restaurant - <span>Sdlo</span></li>
            <li>Salon - <span>Sellet</span></li>
            <li>Electrician - <span>Tutor</span></li>
          </ul>
          <button>Edit</button>
          <button>Delete</button>
          <a href="#">Add New Category</a>
        </div>

        <div class="panel">
          <h3>Manage Users</h3>
          <table>
            <tr><td>Restaurant</td><td>Active</td><td><button>Suspend</button></td></tr>
            <tr><td>Salon</td><td>Active</td><td><button>Restore</button></td></tr>
            <tr><td>Electrician</td><td>Tutor, etc</td><td><button>Add</button></td></tr>
          </table>
          <a href="#">Add New Category</a>
        </div>

        <div class="panel">
          <h3>User Feedback & Testimonials</h3>
          <ul>
            <li>View feedback submitted</li>
            <li>Approve for public display</li>
            <li>Delete inappropriate feedback</li>
          </ul>
        </div>

        <div class="panel">
          <h3>Platform Settings</h3>
          <ul>
            <li>Site Appearance</li>
            <li>Security Settings</li>
            <li>Ad Approval Settings</li>
            <li>Notification Settings</li>
          </ul>
          <h4>Billing & Payments</h4>
          <ul><li>Ad Payments History</li></ul>
        </div>
      </section>
    </main>
  </div>
    <footer>© Jumihen Admin 2025</footer>
</body>
</html>
