<?php
require_once __DIR__ . '/includes/db.php';

// Fetch all lost items
$sql = "SELECT id, item_name, description, date_lost, location, contact_info, status FROM lost_items ORDER BY date_lost DESC";
$result = $mysqli->query($sql);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lost Items</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'partials/navbar.php'; ?>
<div class="container py-4 white-cards">
  <h1>Lost Items</h1>
  <a href="add_lost.php" class="btn btn-success mb-3">Report Lost Item</a>
  <?php if ($result && $result->num_rows > 0): ?>
    <div class="list-group">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="list-group-item">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"><?=htmlspecialchars($row['item_name'])?></h5>
            <small><?=htmlspecialchars($row['date_lost'])?></small>
          </div>
          <p class="mb-1"><?=nl2br(htmlspecialchars($row['description']))?></p>
          <small>Location: <?=htmlspecialchars($row['location'])?> • Contact: <?=htmlspecialchars($row['contact_info'])?> • Status: <?=htmlspecialchars($row['status'])?></small>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p>No lost items found.</p>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>