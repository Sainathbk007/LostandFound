<?php
// migrate_add_lost_fields.php
// Run via CLI: C:\xampp\php\php.exe migrate_add_lost_fields.php
require __DIR__ . '/includes/db.php';

$added = [];
$errors = [];

// Check if student_college_id exists
$res = $mysqli->query("SHOW COLUMNS FROM lost_items LIKE 'student_college_id'");
if ($res && $res->num_rows == 0) {
    $sql = "ALTER TABLE lost_items ADD COLUMN student_college_id VARCHAR(100) NOT NULL AFTER contact_info";
    if ($mysqli->query($sql)) {
        $added[] = 'student_college_id';
    } else {
        $errors[] = $mysqli->error;
    }
}

// Check if image exists
$res2 = $mysqli->query("SHOW COLUMNS FROM lost_items LIKE 'image'");
if ($res2 && $res2->num_rows == 0) {
    $sql = "ALTER TABLE lost_items ADD COLUMN image VARCHAR(255) DEFAULT NULL AFTER student_college_id";
    if ($mysqli->query($sql)) {
        $added[] = 'image';
    } else {
        $errors[] = $mysqli->error;
    }
}

echo "Added columns: " . implode(', ', $added) . "\n";
if ($errors) {
    echo "Errors:\n" . implode("\n", $errors) . "\n";
}
if (empty($added) && empty($errors)) {
    echo "No changes needed.\n";
}

?>