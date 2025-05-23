<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'freelancer') {
    header("Location: login.html");
    exit();
}

require 'db.php';

$user_id = $_SESSION['user_id'];

// Fetch all jobs that freelancer has NOT already bid on
$stmt = $conn->prepare("
    SELECT j.*, u.name AS client_name
    FROM jobs j
    JOIN users u ON j.client_id = u.id
    WHERE j.id NOT IN (
      SELECT job_id FROM bids WHERE freelancer_id = ?
    )
    ORDER BY j.created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$jobs_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Browse Jobs</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
  <nav class="bg-white shadow p-4 flex justify-between">
    <h1 class="font-bold text-xl">Browse Jobs</h1>
    <div>
      <a href="dashfreelancer.php" class="mr-4 text-blue-600 hover:underline">Dashboard</a>
      <a href="logout.php" class="text-red-600 hover:underline">Logout</a>
    </div>
  </nav>

  <main class="max-w-5xl mx-auto p-6">
    <?php if ($jobs_result->num_rows > 0): ?>
      <div class="space-y-6">
        <?php while ($job = $jobs_result->fetch_assoc()): ?>
          <div class="bg-white p-5 rounded shadow">
            <h2 class="text-xl font-semibold"><?= htmlspecialchars($job['title']) ?></h2>
            <p class="text-gray-700 mt-1"><?= nl2br(htmlspecialchars($job['description'])) ?></p>
            <p class="text-sm text-gray-500 mt-2">Client: <?= htmlspecialchars($job['client_name']) ?></p>
            <p class="text-sm text-gray-500">Budget: $<?= number_format($job['budget'], 2) ?></p>

            <form action="bid.php" method="POST" class="mt-4 flex items-center space-x-4">
              <input type="hidden" name="job_id" value="<?= $job['id'] ?>" />
              <label for="bid_amount_<?= $job['id'] ?>" class="font-semibold">Your Bid ($):</label>
              <input type="number" name="bid_amount" id="bid_amount_<?= $job['id'] ?>" min="0" step="0.01" required
                     class="border border-gray-300 rounded px-3 py-1 w-32" />
              <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700 transition">
                Place Bid
              </button>
            </form>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-gray-600 text-center">No new jobs available to bid on.</p>
    <?php endif; ?>
  </main>
</body>
</html>
