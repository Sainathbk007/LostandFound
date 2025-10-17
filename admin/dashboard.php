<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Stats
$total_lost = $mysqli->query("SELECT COUNT(*) AS c FROM lost_items")->fetch_assoc()['c'];
$total_found = $mysqli->query("SELECT COUNT(*) AS c FROM found_items")->fetch_assoc()['c'];
$total_requests = $mysqli->query("SELECT COUNT(*) AS c FROM requests WHERE status = 'pending'")->fetch_assoc()['c'];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'admin_nav.php'; ?>
<div class="container py-4">
  <h1>Dashboard</h1>
  <div class="row">
    <div class="col-md-4">
      <div class="card text-bg-primary mb-3">
        <div class="card-body">
          <h5 class="card-title">Total Lost</h5>
          <p class="card-text"><?=htmlspecialchars($total_lost)?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-bg-success mb-3">
        <div class="card-body">
          <h5 class="card-title">Total Found</h5>
          <p class="card-text"><?=htmlspecialchars($total_found)?></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-bg-warning mb-3">
        <div class="card-body">
          <h5 class="card-title">Pending Requests</h5>
          <p class="card-text"><?=htmlspecialchars($total_requests)?></p>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>