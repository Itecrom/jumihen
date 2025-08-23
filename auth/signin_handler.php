<?php
session_start();
include '../includes/polowela.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT * FROM sellers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (!password_verify($password, $row['password'])) {
        echo "Invalid password";
    } elseif ($row['status'] != 'approved') {
        echo "Account not approved yet.";
    } else {
        $_SESSION['seller_id'] = $row['id'];
        $_SESSION['seller_name'] = $row['name'];
        echo "success";
    }
} else {
    echo "Seller not found";
}
$stmt->close();
$conn->close();
?>