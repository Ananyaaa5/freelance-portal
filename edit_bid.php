<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'freelancer') {
    die("Unauthorized.");
}

$bid_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM bids WHERE id = ? AND freelancer_id = ?");
$stmt->bind_param("ii", $bid_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Bid not found or unauthorized access.");
}

$bid = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Bid</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
  <h2 class="text-2xl mb-4 font-bold">Edit Bid</h2>
  <form action="update_bid.php" method="POST" class="space-y-4 bg-white p-6 rounded shadow max-w-xl">
    <input type="hidden" name="bid_id" value="<?= $bid_id ?>">
    <div>
      <label class="block mb-1">Bid Amount</label>
      <input type="number" name="bid_amount" value="<?= $bid['bid_amount'] ?>" required class="w-full border p-2 rounded">
    </div>
    <div>
      <label class="block mb-1">Message</label>
      <textarea name="message" required class="w-full border p-2 rounded"><?= htmlspecialchars($bid['cover_letter']) ?></textarea>
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Bid</button>
  </form>
</body>
</html>
