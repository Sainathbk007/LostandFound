<?php
// archived migration: migrate_add_lost_fields.php
// original content archived
require __DIR__ . '/../../includes/db.php';

$added = [];
$errors = [];

$res = $mysqli->query("SHOW COLUMNS FROM lost_items LIKE 'student_college_id'");
if ($res && $res->num_rows == 0) {
    $sql = "ALTER TABLE lost_items ADD COLUMN student_college_id VARCHAR(100) NOT NULL AFTER contact_info";
    if ($mysqli->query($sql)) {
        $added[] = 'student_college_id';
    } else {
        $errors[] = $mysqli->error;
    }
}

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
