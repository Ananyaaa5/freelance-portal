<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $bio = $_POST['bio'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ?, bio = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $phone, $bio, $userId);
    $stmt->execute();
    $stmt->close();

    $_SESSION['name'] = $name; // update session if needed
}

$stmt = $conn->prepare("SELECT name, email, phone, bio FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($name, $email, $phone, $bio);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Profile</title>
</head>
<body class="bg-gray-100">
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
    <div
      class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#f5f5dc] to-[#d2b48c] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
      style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
    </div>
  </div>
  <div class="min-h-screen flex flex-col items-center justify-center py-12">
    <div class="bg-white shadow-md rounded-2xl p-8 w-full max-w-2xl">
      <h1 class="text-3xl font-bold text-center text-black-700 mb-6">Your Profile</h1>
      <form method="POST" class="space-y-6">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
          <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email (read-only)</label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" readonly
            class="mt-1 block w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg">
        </div>
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
          <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
        </div>
        <div>
          <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
          <textarea id="bio" name="bio" rows="3"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"><?= htmlspecialchars($bio) ?></textarea>
        </div>
        <div class="text-center">
          <button type="submit"
            class="inline-flex justify-center rounded-md bg-green-600 px-6 py-2 text-white font-semibold hover:bg-green-700 shadow">
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
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
