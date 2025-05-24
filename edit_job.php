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
<body class="p-6 bg-gray-100 min-h-screen flex flex-col items-center justify-center px-4">
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
    <div
      class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#f5f5dc] to-[#d2b48c] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
      style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
    </div>
  </div>
  <h2 class="text-2xl mb-4 font-bold">Edit Job</h2>
  <form action="update_job.php" method="POST" class="space-y-4 bg-white p-6 rounded shadow max-w-2xl">
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
