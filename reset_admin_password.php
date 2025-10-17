<?php
// reset_admin_password.php
// Usage: run from CLI or visit from localhost to reset admin password to '12345'.
// WARNING: delete this file after use.

// Allow only CLI or localhost web access
if (php_sapi_name() !== 'cli') {
    $allowed = ['127.0.0.1', '::1', 'localhost'];
    $remote = $_SERVER['REMOTE_ADDR'] ?? '';
    if (!in_array($remote, $allowed, true)) {
        http_response_code(403);
        echo "Forbidden\n";
        exit;
    }
}

require __DIR__ . '/includes/db.php';

$newHash = password_hash('12345', PASSWORD_DEFAULT);
$stmt = $mysqli->prepare("UPDATE admin SET password = ? WHERE username = 'admin'");
$stmt->bind_param('s', $newHash);
$stmt->execute();
if ($stmt->affected_rows) {
    echo "Admin password reset to '12345' (hashed)\n";
} else {
    // If no rows updated, maybe admin row doesn't exist — insert one.
    $stmt2 = $mysqli->prepare("INSERT INTO admin (username, password) VALUES ('admin', ?) ON DUPLICATE KEY UPDATE password = VALUES(password)");
    $stmt2->bind_param('s', $newHash);
    $stmt2->execute();
    echo "Admin user created/updated and password set to '12345' (hashed)\n";
    $stmt2->close();
}
$stmt->close();

?>