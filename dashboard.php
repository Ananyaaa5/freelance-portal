<?php
// dashboard.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

$role = $_SESSION['role'];
if ($role === 'client') {
    header('Location: dashclient.php');  // Client dashboard page
} else if ($role === 'freelancer') {
    header('Location: dashfreelancer.php');  // Freelancer dashboard page
} else {
    echo "Invalid user role.";
}
exit();
?>
