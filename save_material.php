<?php



//  Add this right after opening PHP tag
ob_start(); // Start output buffering
register_shutdown_function(function () {
    // Ensure any unexpected output doesn't corrupt our JSON
    if (ob_get_length()) ob_end_clean();
});

// Your existing code...
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

ini_set('upload_max_filesize', '200M');
ini_set('post_max_size', '210M');
ini_set('max_execution_time', 300);
ini_set('max_input_time', 300);
ini_set('memory_limit', '256M');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set headers to prevent caching
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode([
        'success' => false,
        'message' => 'Only POST requests allowed',
        'received_method' => $_SERVER['REQUEST_METHOD']
    ]));
}

// Database configuration
$config = [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'name' => 'study_material',
    'port' => 3306,
    'sub_db' => 'subscription_data'
];

// Email configuration
$emailConfig = [
    'sender_email' => $_ENV['SMTP_USERNAME'],
    'sender_name' => 'SriHari Study Materials',
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587, // Correct port
    'smtp_secure' => PHPMailer::ENCRYPTION_STARTTLS,
    'smtp_auth' => true,
    'smtp_username' => $_ENV['SMTP_USERNAME'],
    'smtp_password' => $_ENV['SMTP_PASSWORD'],
    'timeout' => 20
];

// Create standardized JSON response
function jsonResponse($success, $message, $extra = [])
{
    $response = ['success' => $success, 'message' => $message];
    if ($extra) $response = array_merge($response, $extra);
    echo json_encode($response);
    exit;
}

// Connect to main database
try {
    $conn = new mysqli(
        $config['host'],
        $config['user'],
        $config['pass'],
        $config['name'],
        $config['port']
    );

    if ($conn->connect_error) {
        jsonResponse(false, 'Database connection failed', [
            'error' => $conn->connect_error,
            'error_code' => $conn->connect_errno
        ]);
    }
} catch (Exception $e) {
    jsonResponse(false, 'Database error', ['error' => $e->getMessage()]);
}

// Process only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Invalid request method');
}

// Enable error logging for debugging
error_log('Received data: ' . print_r($_REQUEST, true));
error_log('Files data: ' . print_r($_FILES, true));

// Get all input data (works for both form-data and x-www-form-urlencoded)
$inputData = $_POST;
if (
    empty($_POST) && !empty($_SERVER['CONTENT_TYPE']) &&
    strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== false
) {
    parse_str(file_get_contents('php://input'), $inputData);
}

// Debug logging
error_log('Input data: ' . print_r($inputData, true));
error_log('Files data: ' . print_r($_FILES, true));

// Validate required fields
$required = ['title', 'description', 'category', 'level', 'type', 'duration'];
$missing = [];
foreach ($required as $field) {
    if (empty($inputData[$field])) {
        $missing[] = $field;
    }
}

if (!empty($missing)) {
    jsonResponse(false, "Missing required fields: " . implode(', ', $missing), [
        'input_data' => $inputData,
        'files_data' => $_FILES
    ]);
}

// Process data
// Process data using $inputData instead of $_POST
$data = [
    'title' => $conn->real_escape_string($inputData['title']),
    'description' => $conn->real_escape_string($inputData['description']),
    'category' => $conn->real_escape_string($inputData['category']),
    'level' => $conn->real_escape_string($inputData['level']),
    'type' => $conn->real_escape_string($inputData['type']),
    'duration' => (int)$inputData['duration'],
    'tags' => !empty($inputData['tags']) ? $conn->real_escape_string($inputData['tags']) : null,
    'file_path' => null,
    'thumbnail_path' => null,
    'git' => isset($inputData['git']) ? $conn->real_escape_string($inputData['git']) : null,
    'notify_subscribers' => isset($inputData['notifySubscribers']) && $inputData['notifySubscribers'] === 'on'
];

// Handle file upload
if (!empty($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
        jsonResponse(false, 'Failed to create upload directory');
    }

    $fileName = uniqid() . '_' . basename($_FILES['file']['name']);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
        $data['file_path'] = $targetPath;
    }
}

// Handle thumbnail file
if (!empty($_FILES['thumbnail']['tmp_name']) && is_uploaded_file($_FILES['thumbnail']['tmp_name'])) {
    $thumbDir = 'thumbnail/';
    if (!is_dir($thumbDir) && !mkdir($thumbDir, 0755, true)) {
        jsonResponse(false, 'Failed to create upload directory');
    }

    $thumbfileName = uniqid() . '_' . basename($_FILES['thumbnail']['name']);
    $thumbtargetPath = $thumbDir . $thumbfileName;

    if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbtargetPath)) {
        $data['thumbnail_path'] = $thumbtargetPath;
    }
}

// Insert into database
try {
    $stmt = $conn->prepare("INSERT INTO study_materials
        (title, description, category, level, type, duration, tags, file_path, thumbnail_path, Git_url, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    $stmt->bind_param(
        "sssssissss",  // 10 specifiers
        $data['title'],
        $data['description'],
        $data['category'],
        $data['level'],
        $data['type'],
        $data['duration'],
        $data['tags'],
        $data['file_path'],
        $data['thumbnail_path'],
        $data['git']
    );

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    $materialId = $stmt->insert_id;
    $stmt->close();

    // Notify subscribers if requested
    $notificationResult = null;
    if ($data['notify_subscribers']) {
        $notificationResult = notifySubscribersWithPHPMailer(
            $materialId,
            $data['title'],
            $data['description'],
            $config,
            $emailConfig
        );
    }


    // Return success response
    jsonResponse(true, 'Material saved successfully', [
        'material_id' => $materialId,
        'title' => $data['title'],
        'notified_subscribers' => $data['notify_subscribers'],
        'notification_result' => $notificationResult
    ]);
} catch (Exception $e) {
    jsonResponse(false, 'Database operation failed', [
        'error' => $e->getMessage(),
        'error_code' => $e->getCode()
    ]);
}

/**
 * Notify subscribers using PHPMailer
 */
function notifySubscribersWithPHPMailer($materialId, $title, $description, $dbConfig, $emailConfig)
{
    try {
        // Connect to subscribers database
        $subConn = new mysqli(
            $dbConfig['host'],
            $dbConfig['user'],
            $dbConfig['pass'],
            $dbConfig['sub_db'],
            $dbConfig['port']
        );

        if ($subConn->connect_error) {
            throw new Exception("Subscriber DB connection failed: " . $subConn->connect_error);
        }

        // Get active subscribers
        $result = $subConn->query("SELECT email FROM subscribers WHERE is_active = TRUE");
        if ($result->num_rows === 0) {
            $subConn->close();
            return ['success' => true, 'message' => 'No active subscribers to notify'];
        }

        // Initialize PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $emailConfig['smtp_host'];
        $mail->Port = $emailConfig['smtp_port'];
        $mail->SMTPSecure = $emailConfig['smtp_secure'];
        $mail->SMTPAuth = $emailConfig['smtp_auth'];
        $mail->Username = $emailConfig['smtp_username'];
        $mail->Password = $emailConfig['smtp_password'];
        $mail->CharSet = 'UTF-8';
        $mail->Timeout = 60; // Increase timeout to 20 seconds
        $mail->SMTPDebug = 0; // Set to 2 for debugging, 0 for production
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        // Set common email properties
        $mail->setFrom($emailConfig['sender_email'], $emailConfig['sender_name']);
        $mail->Subject = "New Study Material: $title";

        $materialUrl = "http://" . $_SERVER['HTTP_HOST'] . "/study_material.php?id=$materialId";

        // Counters for results
        $successCount = 0;
        $failedRecipients = [];

        while ($row = $result->fetch_assoc()) {
            try {
                $mail->clearAddresses(); // Clear previous recipients
                $mail->addAddress($row['email']);

                // HTML email content
                $mail->isHTML(true);
                $mail->Body = "
                    <html>
                    <body>
                        <h2>New Study Material Available</h2>
                        <p>Dear Subscriber,</p>
                        <p>A new study material has been added to our collection:</p>
                        <h3>$title</h3>
                        <p>$description</p>
                        <p><a href='$materialUrl'>View this material</a></p>
                        <p>Best regards,<br>{$emailConfig['sender_name']}</p>
                    </body>
                    </html>
                ";

                // Plain text alternative
                $mail->AltBody = "New Study Material: $title\n\n$description\n\nView: $materialUrl";

                if ($mail->send()) {
                    $successCount++;
                } else {
                    $failedRecipients[] = $row['email'];
                }
            } catch (Exception $e) {
                $failedRecipients[] = $row['email'];
                error_log("Failed to send to {$row['email']}: " . $mail->ErrorInfo);
            }
        }

        $subConn->close();

        return [
            'success' => true,
            'sent_count' => $successCount,
            'failed_count' => count($failedRecipients),
            'failed_recipients' => $failedRecipients
        ];
    } catch (Exception $e) {
        error_log("Notification system error: " . $e->getMessage());
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        if (ob_get_length()) {
            ob_clean();
        }
        echo json_encode([
            'success' => false,
            'message' => 'A server error occurred',
            'error' => $error['message'],
            'file' => $error['file'],
            'line' => $error['line']
        ]);
    }
});
