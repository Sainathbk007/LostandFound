<?php
// Database connection using MySQLi
// Load credentials from includes/config.php if present to avoid committing secrets
if (file_exists(__DIR__ . '/config.php')) {
    include __DIR__ . '/config.php';
} else {
    // Fallback values (update or create includes/config.php from includes/config.example.php)
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'lost_and_found';
}

// Create connection
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($mysqli->connect_errno) {
    // In production, you'd handle this more gracefully
    die('Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Set charset
$mysqli->set_charset('utf8mb4');

// Usage: global $mysqli; then use $mysqli->prepare(...) in other files.
?>