<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

require 'db.php';

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, email, phone, role, bio FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Your Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
  <nav class="bg-white shadow p-4 flex justify-between">
    <h1 class="font-bold text-xl">Your Profile</h1>
    <div>
      <?php if($user['role'] === 'client'): ?>
        <a href="dashclient.php" class="mr-4 text-blue-600 hover:underline">Dashboard</a>
      <?php else: ?>
        <a href="dashfreelancer.php" class="mr-4 text-blue-600 hover:underline">Dashboard</a>
      <?php endif; ?>
      <a href="logout.php" class="text-red-600 hover:underline">Logout</a>
    </div>
  </nav>

  <main class="max-w-xl mx-auto p-6 bg-white rounded shadow mt-8">
    <h2 class="text-2xl font-semibold mb-4"><?= htmlspecialchars($user['name']) ?></h2>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
    <p><strong>Role:</strong> <?= htmlspecialchars(ucfirst($user['role'])) ?></p>
    <p class="mt-4"><strong>Bio:</strong><br /><?= nl2br(htmlspecialchars($user['bio'])) ?></p>
  </main>
</body>
</html>
