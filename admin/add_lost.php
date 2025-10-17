<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

$message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['item_name'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $date_lost = trim($_POST['date_lost'] ?? '');
  $location = trim($_POST['location'] ?? '');
  $contact = trim($_POST['contact_info'] ?? '');
  $student_college_id = trim($_POST['student_college_id'] ?? '');

  $stmt = $mysqli->prepare("INSERT INTO lost_items (item_name, description, date_lost, location, contact_info, student_college_id, status) VALUES (?, ?, ?, ?, ?, ?, 'open')");
  $stmt->bind_param('ssssss', $name, $desc, $date_lost, $location, $contact, $student_college_id);
    $ok = $stmt->execute();
    $stmt->close();
    $message = $ok ? 'Saved' : 'Failed';
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Lost Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'admin_nav.php'; ?>
<div class="container py-4">
  <h1>Add Lost Item</h1>
  <?php if ($message): ?><div class="alert alert-info"><?=htmlspecialchars($message)?></div><?php endif; ?>
  <form method="post">
    <div class="mb-3"><label class="form-label">Item Name</label><input name="item_name" class="form-control" required></div>
    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control"></textarea></div>
    <div class="mb-3"><label class="form-label">Date Lost</label><input type="date" name="date_lost" class="form-control"></div>
    <div class="mb-3"><label class="form-label">Location</label><input name="location" class="form-control"></div>
  <div class="mb-3"><label class="form-label">Contact Info</label><input name="contact_info" class="form-control"></div>
  <div class="mb-3"><label class="form-label">Student College ID</label><input name="student_college_id" class="form-control" required></div>
  <button class="btn btn-primary">Save</button>
  </form>
</div>
</body>
</html>