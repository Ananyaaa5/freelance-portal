<?php
// place_bid.php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'freelancer') {
    die("Access denied");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $freelancer_id = $_SESSION['user_id'];
    $job_id = intval($_POST['job_id']);
    $bid_amount = floatval($_POST['bid_amount']);
    $cover_letter = trim($_POST['cover_letter']);

    // Prevent duplicate bids on the same job by same freelancer
    $check = $conn->prepare("SELECT id FROM bids WHERE job_id = ? AND freelancer_id = ?");
    $check->bind_param("ii", $job_id, $freelancer_id);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        die("You have already placed a bid on this job.");
    }

    $stmt = $conn->prepare("INSERT INTO bids (job_id, freelancer_id, bid_amount, cover_letter, status, created_at) VALUES (?, ?, ?, ?, 'pending', NOW())");
    $stmt->bind_param("iids", $job_id, $freelancer_id, $bid_amount, $cover_letter);

    if ($stmt->execute()) {
        echo "Bid placed successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
