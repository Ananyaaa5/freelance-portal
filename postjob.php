<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $budget = floatval($_POST['budget']);
    $client_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO jobs (title, description, budget, client_id, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssdi", $title, $description, $budget, $client_id);

    if ($stmt->execute()) {
        header("Location: dashclient.php");
    } else {
        echo "Error posting job: " . $stmt->error;
    }
}
?>
