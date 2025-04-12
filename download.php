<?php
header('Content-Type: application/json');

// Security checks
if (!isset($_GET['file']) || empty($_GET['file'])) {
    http_response_code(400);
    die(json_encode(['error' => 'File parameter missing']));
}

$requestedFile = urldecode($_GET['file']);
$basePath = 'http//192.168.117.243/srihari/'; // Change to your server's document root
$fullPath = realpath($basePath . $requestedFile);

// Validate path
if (!$fullPath || !file_exists($fullPath)) {
    http_response_code(404);
    die(json_encode(['error' => 'File not found']));
}

// Check if within document root
if (strpos($fullPath, $basePath) !== 0) {
    http_response_code(403);
    die(json_encode(['error' => 'Access denied']));
}

// Get file info
$filename = basename($fullPath);
$filesize = filesize($fullPath);
$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

// Set appropriate headers
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . $filesize);
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

// Clear output buffer
flush();
readfile($fullPath);
exit;
?>