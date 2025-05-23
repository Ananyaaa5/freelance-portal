<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    die("Unauthorized.");
}

$job_id = intval($_POST['job_id']);
$title = $_POST['title'];
$description = $_POST['description'];
$budget = floatval($_POST['budget']);
$deadline = $_POST['deadline'];

$stmt = $conn->prepare("UPDATE jobs SET title = ?, description = ?, budget = ?, deadline = ? WHERE id = ? AND client_id = ?");
$stmt->bind_param("ssdsii", $title, $description, $budget, $deadline, $job_id, $_SESSION['user_id']);

if ($stmt->execute()) {
    header("Location: dashclient.php");
} else {
    echo "Error updating job.";
}
?>
