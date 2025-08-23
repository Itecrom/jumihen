<?php
session_start();
include '../includes/polowela.php';

if (!isset($_SESSION['seller_id'])) {
    header("Location: ../store.php");
    exit();
}

$seller_id = $_SESSION['seller_id'];
$product_id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM products WHERE id = ? AND seller_id = ?");
$stmt->bind_param("ii", $product_id, $seller_id);
$stmt->execute();

header("Location: dashboard.php");
exit();
