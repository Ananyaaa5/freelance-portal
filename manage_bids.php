<?php
// manage_bids.php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    die("Access denied");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_SESSION['user_id'];
    $bid_id = intval($_POST['bid_id']);
    $action = $_POST['action']; // accept or reject

    // Verify bid belongs to a job posted by this client
    $stmt = $conn->prepare("SELECT bids.job_id FROM bids JOIN jobs ON bids.job_id = jobs.id WHERE bids.id = ? AND jobs.client_id = ?");
    $stmt->bind_param("ii", $bid_id, $client_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        die("Unauthorized action.");
    }

    if ($action === 'accept') {
        // Update bid status to accepted and reject others for the same job
        $conn->begin_transaction();

        $stmt1 = $conn->prepare("UPDATE bids SET status='accepted' WHERE id=?");
        $stmt1->bind_param("i", $bid_id);
        $stmt1->execute();

        $stmt2 = $conn->prepare("UPDATE bids SET status='rejected' WHERE job_id = (SELECT job_id FROM bids WHERE id=?) AND id != ?");
        $stmt2->bind_param("ii", $bid_id, $bid_id);
        $stmt2->execute();

        $conn->commit();

        echo "Bid accepted.";
    } elseif ($action === 'reject') {
        $stmt = $conn->prepare("UPDATE bids SET status='rejected' WHERE id=?");
        $stmt->bind_param("i", $bid_id);
        $stmt->execute();

        echo "Bid rejected.";
    } else {
        echo "Invalid action.";
    }
}
?>
