<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'freelancer') {
    die("Unauthorized.");
}

$bid_id = intval($_POST['bid_id']);
$bid_amount = floatval($_POST['bid_amount']);
$message = $_POST['cover_letter'];

$stmt = $conn->prepare("UPDATE bids SET bid_amount = ?, cover_letter = ? WHERE id = ? AND freelancer_id = ?");
$stmt->bind_param("dsii", $bid_amount, $message, $bid_id, $_SESSION['user_id']);

if ($stmt->execute()) {
    header("Location: dashfreelancer.php");
} else {
    echo "Error updating bid.";
}
?>
