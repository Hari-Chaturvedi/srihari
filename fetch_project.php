<?php
header('Content-Type: text/plain'); // Change to text/plain for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database connection
$servername = "localhost";
$username = "root"; // Change to your DB username
$password = ""; // Change to your DB password
$dbname = "study_material";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Fetch projects where category is 'projects'
$sql = "SELECT * FROM study_materials WHERE category = 'projects'";
$result = $conn->query($sql);

$projects = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $projects]);
} else {
    echo json_encode(['success' => false, 'message' => 'No projects found']);
}

$conn->close();
?>