<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $budget = $_POST['budget'];
    $deadline = $_POST['deadline'];
    $client_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO jobs (title, description, budget, deadline, client_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsi", $title, $description, $budget, $deadline, $client_id);

    if ($stmt->execute()) {
        header("Location: dashclient.php?msg=Job+posted+successfully");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

