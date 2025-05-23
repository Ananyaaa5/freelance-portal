<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: login.html");
    exit();
}
require 'db.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM jobs WHERE client_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$jobs = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Client Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
  <nav class="bg-white shadow p-4 flex justify-between">
    <h1 class="font-bold text-xl">Client Dashboard</h1>
    <div>
      <a href="profile.php" class="mr-4 text-blue-600 hover:underline">Profile</a>
      <a href="logout.php" class="text-red-600 hover:underline">Logout</a>
    </div>
  </nav>

  <main class="max-w-4xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-semibold">Your Posted Jobs</h2>
      <a href="postjob.html" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Post a Job</a>
    </div>

    <?php if ($jobs->num_rows > 0): ?>
      <?php while ($job = $jobs->fetch_assoc()): ?>
        <div class="bg-white p-4 rounded shadow mb-4">
          <h3 class="text-xl font-bold"><?= htmlspecialchars($job['title']) ?></h3>
          <p class="text-gray-700"><?= nl2br(htmlspecialchars($job['description'])) ?></p>
          <p class="text-sm text-gray-500 mt-1">Budget: $<?= number_format($job['budget'], 2) ?> | Deadline: <?= htmlspecialchars($job['deadline']) ?></p>
          <div class="mt-2 space-x-2">
            <a href="manage_bids.php?job_id=<?= $job['id'] ?>" class="text-blue-600 hover:underline">Manage Bids</a>
            <a href="edit_job.php?id=<?= $job['id'] ?>" class="text-yellow-600 hover:underline">Edit Job</a>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-gray-600">No jobs posted yet.</p>
    <?php endif; ?>
  </main>
</body>
</html>
