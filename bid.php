<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'freelancer') {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $job_id = intval($_POST['job_id']);
    $bid_amount = floatval($_POST['bid_amount']);
    $freelancer_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO bids (job_id, freelancer_id, bid_amount, status, created_at) VALUES (?, ?, ?, 'pending', NOW())");
    $stmt->bind_param("iid", $job_id, $freelancer_id, $bid_amount);

    if ($stmt->execute()) {
        header("Location: dashfreelancer.php");
    } else {
        echo "Error submitting bid: " . $stmt->error;
    }
}
?>
