<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'freelancer') {
    header("Location: login.html");
    exit();
}

require 'db.php';

$user_id = $_SESSION['user_id'];

// Fetch bids made by freelancer (to show status)
$stmt = $conn->prepare("
    SELECT b.*, j.title, j.description, j.budget, u.name AS client_name
    FROM bids b
    JOIN jobs j ON b.job_id = j.id
    JOIN users u ON j.client_id = u.id
    WHERE b.freelancer_id = ?
    ORDER BY b.created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$bids_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Freelancer Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
  <nav class="bg-white shadow p-4 flex justify-between">
    <h1 class="font-bold text-xl">Freelancer Dashboard</h1>
    <div>
      <a href="profile.php" class="mr-4 text-blue-600 hover:underline">Profile</a>
      <a href="logout.php" class="text-red-600 hover:underline">Logout</a>
    </div>
  </nav>

  <main class="max-w-4xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-semibold">Your Bids</h2>
      <a href="browsejobs.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Browse Jobs</a>
    </div>

    <?php if ($bids_result->num_rows > 0): ?>
      <div class="space-y-4">
        <?php while ($bid = $bids_result->fetch_assoc()): ?>
          <div class="bg-white p-4 rounded shadow">
            <h3 class="text-xl font-semibold"><?= htmlspecialchars($bid['title']) ?></h3>
            <p class="text-gray-700 mt-1"><?= nl2br(htmlspecialchars($bid['description'])) ?></p>
            <p class="text-sm text-gray-500 mt-2">Budget: $<?= number_format($bid['budget'], 2) ?></p>
            <p class="text-sm text-gray-500">Client: <?= htmlspecialchars($bid['client_name']) ?></p>
            <p class="text-sm mt-2">
              Bid Amount: <strong>$<?= number_format($bid['bid_amount'], 2) ?></strong><br />
              Status: <span class="font-semibold"><?= htmlspecialchars(ucfirst($bid['status'])) ?></span>
            </p>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="text-gray-600">You have not placed any bids yet.</p>
    <?php endif; ?>
  </main>
</body>
</html>
