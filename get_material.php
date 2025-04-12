<?php

header('Content-Type: application/json');

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database configuration - move these to a config file in production
$servername = $_ENV["DB_HOST"];
$username = $_ENV["DB_USERNAME"];
$password = "";
$dbname = $_ENV["DB_NAME1"];
$port = $_ENV["DB_PORT"];

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }

    // Get all materials (since your frontend isn't passing an ID)
    $stmt = $conn->prepare("SELECT * FROM study_materials ORDER BY created_at DESC");

    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $materials = [];

    while ($row = $result->fetch_assoc()) {
        // Format tags as array
        $row['tags'] = !empty($row['tags']) ? explode(',', $row['tags']) : [];

        // Add full file URL if path exists
        if (!empty($row['file_path'])) {
            $row['file_url'] = 'https://192.168.117.243/srihari/'.$row['file_path'];
        }

        $materials[] = $row;
    }
    
    // Return success response
    echo json_encode([
        'success' => true,
        'data' => $materials
    ]);
} catch (Exception $e) {
    // Return error response
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} finally {
    // Close connections if they exist
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}
