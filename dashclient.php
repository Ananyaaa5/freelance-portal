<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: login.html");
    exit();
}

require 'db.php';

$user_id = $_SESSION['user_id'];

// Fetch jobs posted by client
$stmt = $conn->prepare("SELECT * FROM jobs WHERE client_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
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
      <a href="postjob.html" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Post a Job</a>
    </div>

    <?php if ($result->num_rows > 0): ?>
      <div class="space-y-4">
        <?php while ($job = $result->fetch_assoc()): ?>
          <div class="bg-white p-4 rounded shadow">
            <h3 class="text-xl font-semibold"><?= htmlspecialchars($job['title']) ?></h3>
            <p class="text-gray-700 mt-1"><?= nl2br(htmlspecialchars($job['description'])) ?></p>
            <p class="text-sm text-gray-500 mt-2">Budget: $<?= number_format($job['budget'], 2) ?></p>
            <p class="text-sm text-gray-500">Posted on: <?= date("M d, Y", strtotime($job['created_at'])) ?></p>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-gray-600">You haven't posted any jobs yet.</p>
    <?php endif; ?>
  </main>
</body>
</html>
