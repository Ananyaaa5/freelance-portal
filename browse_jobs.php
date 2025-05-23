<?php
// browse_jobs.php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'freelancer') {
    die("Access denied");
}

$sql = "SELECT jobs.*, users.name AS client_name FROM jobs 
        JOIN users ON jobs.client_id = users.id
        WHERE jobs.id NOT IN (
            SELECT job_id FROM bids WHERE freelancer_id = ?
        )"; // Jobs freelancer hasn't bid on yet

$stmt = $conn->prepare($sql);
$freelancer_id = $_SESSION['user_id'];
$stmt->bind_param("i", $freelancer_id);
$stmt->execute();
$result = $stmt->get_result();

$jobs = [];
while ($row = $result->fetch_assoc()) {
    $jobs[] = $row;
}

header('Content-Type: application/json');
echo json_encode($jobs);
?>
