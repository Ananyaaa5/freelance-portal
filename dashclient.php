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
<body class="min-h-screen font-sans">
<div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
    <div
      class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#f5f5dc] to-[#d2b48c] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
      style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
    </div>
  </div>
  <!-- Navbar -->
  <nav class="bg-white/90 shadow-md py-4 px-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Client Dashboard</h1>
    <div>
      <a href="profile.php" class="text-green-700 font-medium hover:underline mr-4">Profile</a>
      <a href="logout.php" class="text-red-600 font-medium hover:underline">Logout</a>
    </div>
  </nav>

  <!-- Main content -->
  <main class="w-full max-w-5xl mx-auto px-6 mt-10">
    <div class="flex justify-between items-center mb-8">
      <h2 class="text-3xl font-semibold text-gray-800">Your Posted Jobs</h2>
      <a href="postjob.html" class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition">
        + Post a Job
      </a>
    </div>

    <?php if ($jobs->num_rows > 0): ?>
      <?php while ($job = $jobs->fetch_assoc()): ?>
        <div class="border border-beige-300 rounded-xl p-6 bg-white/80 backdrop-blur-sm mb-6 shadow-sm">
          <h3 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($job['title']) ?></h3>
          <p class="text-gray-700 whitespace-pre-line mb-2"><?= nl2br(htmlspecialchars($job['description'])) ?></p>
          <p class="text-sm text-gray-600">
            <span class="font-medium">Budget:</span> $<?= number_format($job['budget'], 2) ?> |
            <span class="font-medium">Deadline:</span> <?= htmlspecialchars($job['deadline']) ?>
          </p>
          <div class="mt-3 space-x-4">
            <a href="manage_bids.php?job_id=<?= $job['id'] ?>" class="text-blue-600 hover:underline">Manage Bids</a>
            <a href="edit_job.php?id=<?= $job['id'] ?>" class="text-yellow-600 hover:underline">Edit Job</a>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-gray-700 text-lg">You haven't posted any jobs yet.</p>
    <?php endif; ?>
  </main>
<div
    class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
    aria-hidden="true">
    <div
      class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#c1a374] to-[#a2c9a7] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
      style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
    </div>
  </div>
</body>
</html>
