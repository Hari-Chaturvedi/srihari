<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "study_material";
$port = 3306;

try {
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
    $stmt = $conn->prepare("SELECT * FROM study_materials WHERE category = 'projects' ORDER BY created_at DESC LIMIT ?");
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $materials = [];
    while ($row = $result->fetch_assoc()) {
        $materials[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'category' => $row['category'],
            'level' => $row['level'],
            'type' => $row['type'],
            'duration' => $row['duration'],
            'file_url' => !empty($row['file_path']) ? 'https://yourdomain.com/'.$row['file_path'] : '#',
            'preview_link' => '#preview-'.$row['id']
        ];
    }

    echo json_encode([
        'success' => true,
        'data' => $materials
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}
?>