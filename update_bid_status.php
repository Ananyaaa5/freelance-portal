<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bid_id = $_POST['bid_id'];
    $status = $_POST['action']; // 'accepted' or 'rejected'

    if (!in_array($status, ['accepted', 'rejected'])) {
        die("Invalid action.");
    }

    $stmt = $conn->prepare("UPDATE bids SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $bid_id);

    if ($stmt->execute()) {
        header("Location: manage_bids.php");
    } else {
        echo "Error updating bid status.";
    }
}
