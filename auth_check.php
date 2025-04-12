<?php
session_start();

if (!defined('ADMIN_ACCESS') || !isset($_SESSION['admin_logged_in'])) {
    header('HTTP/1.0 403 Forbidden');
    die('Direct access not permitted');
}
?>