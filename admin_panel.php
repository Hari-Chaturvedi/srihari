<?php

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'admin');
define('DB_PORT', 3306);

// Redirect to login if not authenticated
// Replace the initial session check in admin_panel.php with:
if (!isset($_SESSION['admin_logged_in'])) {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        // AJAX request - return JSON instead of redirect
        header('Content-Type: application/json');
        echo json_encode(['redirect' => 'admin_login.php']);
        exit();
    } else {
        // Normal request - redirect
        header('Location: admin_login.php');
        exit();
    }
}

// Validate session against database
function validateAdminSession($userId, $username) {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    
    $stmt = $conn->prepare("SELECT id FROM admin_users WHERE id = ? AND username = ? AND is_active = 1");
    $stmt->bind_param("is", $userId, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $valid = $result->num_rows === 1;
    
    $stmt->close();
    $conn->close();
    
    return $valid;
}

// Check if session is still valid
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username']) || 
    !validateAdminSession($_SESSION['user_id'], $_SESSION['username'])) {
    session_unset();
    session_destroy();
    header('Location: admin_login.php?session=expired');
    exit();
}

// Validate session to prevent hijacking
if (isset($_SESSION['user_ip']) && $_SESSION['user_ip'] !== $_SERVER['REMOTE_ADDR']) {
    session_unset();
    session_destroy();
    header('Location: admin_login.php?hijack=1');
    exit();
}

if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    session_unset();
    session_destroy();
    header('Location: admin_login.php?hijack=1');
    exit();
}

// Set session timeout (30 minutes)
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600)) {
    session_unset();
    session_destroy();
    header('Location: admin_login.php?timeout=1');
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");

// Regenerate session ID periodically to prevent fixation
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['CREATED'] = time();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SriHari: Admin Panel</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin_panel.css">
</head>

<body>
    <div class="admin-container">
        <div class="admin-header">
            <h2><i class="fas fa-user-shield"></i> Study Materials Admin Panel</h2>
            <div class="container-btn">
                <a href="study_material.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> View in Site
                </a>
                <a href="logout.php" class="btn btn-outline-danger ml-2">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <form id="materialForm" action="save_material.php" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="title">Material Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="category">Category</label>
                    <select class="custom-select" id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="python">Python</option>
                        <option value="sql">SQL</option>
                        <option value="statistics">Statistics</option>
                        <option value="visualization">Data Visualization</option>
                        <option value="ml">Machine Learning</option>
                        <option value="projects">Projects</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="level">Difficulty Level</label>
                    <select class="custom-select" id="level" name="level" required>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="type">Material Type</label>
                    <select class="custom-select" id="type" name="type" required>
                        <option value="PDF">PDF</option>
                        <option value="SQL Files">SQL Files</option>
                        <option value="Jupyter Notebook">Jupyter Notebook</option>
                        <option value="Video Course">Video Course</option>
                        <option value="Zip File">Zip File</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="duration">Duration (minutes)</label>
                    <input type="number" class="form-control" id="duration" name="duration" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="file">File Upload</label>
                    <input type="file" class="form-control-file" id="file" name="file">
                </div>
                <div class="form-group col-md-3">
                    <label for="thumbnail">Thumbnail Upload</label>
                    <input type="file" class="form-control-file" id="thumbnail" name="thumbnail">
                </div>
                <div class="form-group col-md-3">
                    <label for="git">Git-Url</label>
                    <input type="url" class="form-control-file" id="git" name="git">
                </div>
            </div>

            <div class="form-group">
                <label for="tags">Tags (comma separated)</label>
                <input type="text" class="form-control" id="tags" name="tags" placeholder="python, data-analysis, pandas">
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="notifySubscribers" name="notifySubscribers">
                <label class="form-check-label" for="notifySubscribers">Notify subscribers about this new material</label>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Material
            </button>

            <div id="formMessage" class="alert mt-3" style="display: none;"></div>
        </form>

        <div class="material-list">
            <h4><i class="fas fa-list"></i> Existing Materials</h4>
            <div id="materialsContainer">
                <!-- Materials will be loaded here via AJAX -->
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="admin_panel.js"></script>
</body>

</html>