<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    die("Access denied");
}

// Handle Accept/Reject actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bid_id'], $_POST['action'])) {
    $client_id = $_SESSION['user_id'];
    $bid_id = intval($_POST['bid_id']);
    $action = $_POST['action']; // 'accept' or 'reject'

    // Verify bid belongs to a job posted by this client
    $stmt = $conn->prepare("SELECT bids.job_id FROM bids JOIN jobs ON bids.job_id = jobs.id WHERE bids.id = ? AND jobs.client_id = ?");
    $stmt->bind_param("ii", $bid_id, $client_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        die("Unauthorized action.");
    }

    if ($action === 'accept') {
        $conn->begin_transaction();

        $stmt1 = $conn->prepare("UPDATE bids SET status='accepted' WHERE id=?");
        $stmt1->bind_param("i", $bid_id);
        $stmt1->execute();

        $stmt2 = $conn->prepare("UPDATE bids SET status='rejected' WHERE job_id = (SELECT job_id FROM bids WHERE id=?) AND id != ?");
        $stmt2->bind_param("ii", $bid_id, $bid_id);
        $stmt2->execute();

        $conn->commit();

        $message = "Bid accepted.";
    } elseif ($action === 'reject') {
        $stmt = $conn->prepare("UPDATE bids SET status='rejected' WHERE id=?");
        $stmt->bind_param("i", $bid_id);
        $stmt->execute();

        $message = "Bid rejected.";
    } else {
        $message = "Invalid action.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Bids</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Manage Bids</h1>

        <?php if (isset($message)): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-800 border border-green-300 rounded">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php
        $client_id = $_SESSION['user_id'];
        $query = "SELECT bids.id AS bid_id, jobs.title, users.name AS freelancer_name, bids.bid_amount, bids.cover_letter, bids.status
                  FROM bids 
                  JOIN jobs ON bids.job_id = jobs.id 
                  JOIN users ON bids.freelancer_id = users.id 
                  WHERE jobs.client_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $client_id);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>

        <table class="w-full border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">Job Title</th>
                    <th class="px-4 py-2 border">Freelancer</th>
                    <th class="px-4 py-2 border">Amount</th>
                    <th class="px-4 py-2 border">Message</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="text-center">
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['title']) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['freelancer_name']) ?></td>
                        <td class="border px-4 py-2"><?= $row['bid_amount'] ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($row['cover_letter']) ?></td>
                        <td class="border px-4 py-2"><?= ucfirst($row['status']) ?></td>
                        <td class="border px-4 py-2">
                            <?php if ($row['status'] === 'pending'): ?>
                                <form method="POST" class="flex gap-2 justify-center">
                                    <input type="hidden" name="bid_id" value="<?= $row['bid_id'] ?>">
                                    <button type="submit" name="action" value="accept" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Accept</button>
                                    <button type="submit" name="action" value="reject" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Reject</button>
                                </form>
                            <?php else: ?>
                                <span class="text-gray-600"><?= ucfirst($row['status']) ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
