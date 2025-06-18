<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);
    $role = $_POST['role']; // 'client' or 'freelancer'
    $bio = trim($_POST['bio']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone, role, bio) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $hashed_password, $phone, $role, $bio);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['role'] = $role;

        // ✅ Use role-based redirect here
        if ($role === 'client') {
            header('Location: dashclient.php');
        } else {
            header('Location: dashfreelancer.php');
        }
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
