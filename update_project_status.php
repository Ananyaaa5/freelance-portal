<?php
// update_project_status.php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'freelancer') {
    die("Access denied");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $freelancer_id = $_SESSION['user_id'];
    $job_id = intval($_POST['job_id']);
    $status = $_POST['status'];  // started, in_progress, completed
    $start_date = $_POST['start_date'] ?? null;
    $end_date = $_POST['end_date'] ?? null;

    // Verify freelancer has accepted bid for this job
    $stmt = $conn->prepare("SELECT id FROM bids WHERE job_id=? AND freelancer_id=? AND status='accepted'");
    $stmt->bind_param("ii", $job_id, $freelancer_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        die("You are not assigned to this job.");
    }

    // Insert or update project status in projects table
    $stmt_check = $conn->prepare("SELECT id FROM projects WHERE job_id=?");
    $stmt_check->bind_param("i", $job_id);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows === 0) {
        $stmt_insert = $conn->prepare("INSERT INTO projects (job_id, status, start_date, end_date) VALUES (?, ?, ?, ?)");
        $stmt_insert->bind_param("isss", $job_id, $status, $start_date, $end_date);
        $stmt_insert->execute();
    } else {
        $stmt_update = $conn->prepare("UPDATE projects SET status=?, start_date=?, end_date=? WHERE job_id=?");
        $stmt_update->bind_param("sssi", $status, $start_date, $end_date, $job_id);
        $stmt_update->execute();
    }

    echo "Project status updated.";
}
?>
