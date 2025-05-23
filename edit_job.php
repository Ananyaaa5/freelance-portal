<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header('Location: login.html');
    exit();
}

$job_id = intval($_GET['id']);
$client_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ? AND client_id = ?");
$stmt->bind_param("ii", $job_id, $client_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Job not found or unauthorized access.");
}

$job = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Job</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
  <h2 class="text-2xl mb-4 font-bold">Edit Job</h2>
  <form action="update_job.php" method="POST" class="space-y-4 bg-white p-6 rounded shadow max-w-xl">
    <input type="hidden" name="job_id" value="<?= $job_id ?>">
    <div>
      <label class="block mb-1">Title</label>
      <input type="text" name="title" value="<?= htmlspecialchars($job['title']) ?>" required class="w-full border p-2 rounded">
    </div>
    <div>
      <label class="block mb-1">Description</label>
      <textarea name="description" required class="w-full border p-2 rounded"><?= htmlspecialchars($job['description']) ?></textarea>
    </div>
    <div>
      <label class="block mb-1">Budget</label>
      <input type="number" name="budget" value="<?= $job['budget'] ?>" required class="w-full border p-2 rounded">
    </div>
    <div>
      <label class="block mb-1">Deadline</label>
      <input type="date" name="deadline" value="<?= $job['deadline'] ?>" required class="w-full border p-2 rounded">
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Job</button>
  </form>
</body>
</html>
