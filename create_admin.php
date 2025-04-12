<?php
require_once 'auth_check.php'; // Your existing admin auth check

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database configuration
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "admin";
$port = 3306;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $fullName = $_POST['full_name'];
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    $stmt = $conn->prepare("INSERT INTO admin_users (username, password_hash, full_name) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $fullName);

    if ($stmt->execute()) {
        echo "Admin user created successfully";
    } else {
        echo "Error creating admin user";
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- Simple form to create new admin users -->
<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="text" name="full_name" placeholder="Full Name">
    <button type="submit">Create Admin</button>
</form>