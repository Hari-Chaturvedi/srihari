<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Ensure no output before headers
if (ob_get_level()) ob_end_clean();

// Set proper headers first
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require 'vendor/autoload.php'; // Path to PHPMailer autoload
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database configuration
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "subscription_data";
$port = 3306;

// Email configuration
$sender_email = $_ENV["SMTP_USERNAME"];
$sender_name = "SriHari Study Materials";

// Create response array
$response = ['success' => false, 'message' => ''];

try {
    // Create database connection
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Database connection failed");
    }

    // Only process POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Only POST requests are allowed");
    }

    // Get raw POST data
    $data = json_decode(file_get_contents('php://input'), true);

    // Fallback to form data if JSON parse fails
    if ($data === null) {
        $data = $_POST;
    }

    if (empty($data['email'])) {
        throw new Exception("Email is required");
    }

    $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email address");
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM subscribers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['message'] = 'You are already subscribed';
        echo json_encode($response);
        exit;
    }

    // Insert new subscriber
    $stmt = $conn->prepare("INSERT INTO subscribers (email, subscribed_at) VALUES (?, NOW())");
    $stmt->bind_param("s", $email);

    if (!$stmt->execute()) {
        throw new Exception("Failed to save subscription");
    }

    // Create PHPMailer instance
    $mail = new PHPMailer(true);

    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $sender_email;
    $mail->Password   = $_ENV['SMTP_PASSWORD']; // Mail App password of gmail
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
    $mail->CharSet    = 'UTF-8';
    // $mail->SMTPOptions = [
    //     'ssl' => [
    //         'verify_peer' => false,
    //         'verify_peer_name' => false,
    //         'allow_self_signed' => true
    //     ]
    // ];

    // Enable debugging (0 = off, 1 = client messages, 2 = client and server messages)
    $mail->SMTPDebug = 0;

    // Recipients
    $mail->setFrom($sender_email, $sender_name);
    $mail->addAddress($email);
    $mail->addReplyTo($sender_email, $sender_name);

    // Content
    $mail->isHTML(false); // Set to true if you want HTML email
    $mail->Subject = 'Welcome to SriHari Study Materials - Subscription Confirmed!';
    $mail->Body    = "Dear Subscriber,\n\nThank you for subscribing to SriHari Study Materials! We're delighted to welcome you to our growing community of learners and knowledge seekers.\n\nAs a valued subscriber, you now have access to the following benefits:\n✅ Immediate Access - Start exploring our wide range of high-quality study materials right away.\n🔔 Real-Time Updates - Get notified as soon as new materials and updates are added to our collection.\n🎓 Exclusive Tips & Resources - Receive curated learning tips, academic resources, and study strategies designed to help you succeed.\n\nIf you did not request this subscription, no action is required. You can simply ignore this email.\n\nWe look forward to supporting your learning journey. If you have any questions or need assistance, feel free to reach out to us at haribhuofficial@gmail.com .\n\nBest regards,\nThe SriHari Team\nEmpowering Learners, One Step at a Time";

    $mailSent = $mail->send();

    // Log email sending result
    error_log("Email send attempt to $email: " . ($mailSent ? 'Success' : 'Failed - ' . $mail->ErrorInfo));

    $response = [
        'success' => true,
        'message' => 'Subscription successful! ' .
            ($mailSent ? 'Check your email for confirmation.' :
                'Confirmation email could not be sent. Please check your spam folder.')
    ];
} catch (Exception $e) {
    error_log("Subscription error: " . $e->getMessage());
    $response['message'] = $e->getMessage();

    // If it's a PHPMailer exception, include the error info
    if (isset($mail)) {
        $response['message'] .= " Mailer Error: " . $mail->ErrorInfo;
    }
} finally {
    if (isset($conn)) $conn->close();

    // Ensure no output has been sent before
    if (headers_sent()) {
        error_log("Headers already sent when trying to output JSON");
    }

    echo json_encode($response);
    exit;
}
