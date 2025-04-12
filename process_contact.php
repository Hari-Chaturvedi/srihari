<?php

header('Content-Type: application/json');

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database configuration
$server = "localhost";
$username = "root";
$password = "";
$database = "contact_form_db";
$port = 3306;

// Create connection
$con = mysqli_connect($server, $username, $password, $database, $port);

// Check connection
if (!$con) {
    echo json_encode([
        'success' => false,
        'error' => 'Database connection failed: ' . mysqli_connect_error()
    ]);
    exit;
}

// Get form data
$name = mysqli_real_escape_string($con, $_POST['name'] ?? '');
$email = mysqli_real_escape_string($con, $_POST['email'] ?? '');
$subject = mysqli_real_escape_string($con, $_POST['subject'] ?? '');
$message = mysqli_real_escape_string($con, $_POST['message'] ?? '');

// Validate required fields
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode([
        'success' => false,
        'error' => 'All required fields must be filled'
    ]);
    exit;
}

// Insert into database
$sql = "INSERT INTO contacts (name, email, subject, message) 
        VALUES ('$name', '$email', '$subject', '$message')";

if (mysqli_query($con, $sql)) {
    echo json_encode([
        'success' => true,
        'message' => 'Thank you for contacting us! We will get back to you soon.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . mysqli_error($con)
    ]);
}

mysqli_close($con);
