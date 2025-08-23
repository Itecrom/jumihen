<?php
include '../includes/polowela.php';
$email = $_GET['email'] ?? '';
if (empty($email)) {
    echo "Email is required";
    exit;
}
$stmt = $conn->prepare("SELECT id FROM sellers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
echo $result->num_rows > 0 ? "Email already taken" : "Email available";
$stmt->close();
$conn->close();
?>