<?php
include '../includes/polowela.php';

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$contact = $_POST['contact'] ?? '';

if (empty($name) || empty($email) || empty($password) || empty($contact)) {
    echo "All fields required";
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$profilePic = $_FILES['profile_pic'];
$targetDir = '../uploads/profiles/';
$filename = time() . '-' . basename($profilePic['name']);
$targetFile = $targetDir . $filename;

if (!move_uploaded_file($profilePic['tmp_name'], $targetFile)) {
    echo "Profile upload failed";
    exit;
}

$stmt = $conn->prepare("INSERT INTO sellers (name, email, password, contact, profile_pic, status) VALUES (?, ?, ?, ?, ?, 'pending')");
$stmt->bind_param("sssss", $name, $email, $hashed, $contact, $filename);
if ($stmt->execute()) {
    echo "success";
} else {
    echo "Signup failed: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>