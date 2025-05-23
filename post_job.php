<?php
// post_job.php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    die("Access denied");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $budget = floatval($_POST['budget']);
    $deadline = $_POST['deadline'];  // format: YYYY-MM-DD

    $stmt = $conn->prepare("INSERT INTO jobs (client_id, title, description, budget, deadline, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("issds", $client_id, $title, $description, $budget, $deadline);

    if ($stmt->execute()) {
        header('Location: dashclient.php?job_posted=1');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
