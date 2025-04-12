<?php

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', $_ENV['SMTP_PASSWORD']);
define('DB_NAME', 'admin');
define('DB_PORT', 3306);

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_panel.php');
    exit;
}

// Brute force protection
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

// if ($_SESSION['login_attempts'] > 5) {
//     die("Too many login attempts. Please try again later.");
// }

// Database connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password";
    } else {
        try {
            $stmt = $conn->prepare("SELECT id, username, password_hash FROM admin_users WHERE username = ? LIMIT 1");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("s", $username);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                // Verify password
                if (password_verify($password, $user['password_hash'])) {;

                    // Check if hash needs rehashing
                    if (password_needs_rehash($user['password_hash'], PASSWORD_BCRYPT)) {
                        $newHash = password_hash($password, PASSWORD_BCRYPT);
                        $update = $conn->prepare("UPDATE admin_users SET password_hash = ? WHERE id = ?");
                        $update->bind_param("si", $newHash, $user['id']);
                        $update->execute();
                        echo "<span style='color:blue;'>Password hash updated</span><br>";
                    }

                    // Successful login
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['login_attempts'] = 0;
                    $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
                    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

                    // Regenerate session ID
                    session_regenerate_id(true);

                    echo "<script>window.location.href = 'admin_panel.php';</script>";
                    exit;
                } else {
                    echo "<span style='color:red;'>Password verification FAILED</span><br>";
                    $_SESSION['login_attempts']++;
                    $error = "Invalid credentials";
                }
                echo "</div>";
            } else {
                $_SESSION['login_attempts']++;
                $error = "Invalid credentials";
            }

            $stmt->close();
        } catch (Exception $e) {
            $error = "System error. Please try again.";
            error_log("Login error: " . $e->getMessage());
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .debug-info {
            background: #f8f9fa;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2 class="text-center mb-4">Admin Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required
                    value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>
</body>

</html>