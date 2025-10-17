<?php
require_once __DIR__ . '/includes/db.php';

// Fetch found items
$sql = "SELECT id, item_name, description, date_found, location, contact_info, image, status FROM found_items WHERE status != 'deleted' ORDER BY date_found DESC";
$result = $mysqli->query($sql);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Found Items</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'partials/navbar.php'; ?>
<div class="container py-4 found-page">
  <h1>Found Items</h1>
  <?php if ($result && $result->num_rows > 0): ?>
    <div class="row g-3">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-md-4">
          <div class="card">
            <?php if (!empty($row['image'])): ?>
              <img src="uploads/<?=htmlspecialchars($row['image'])?>" class="card-img-top" alt="<?=htmlspecialchars($row['item_name'])?>">
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?=htmlspecialchars($row['item_name'])?></h5>
              <p class="card-text"><?=nl2br(htmlspecialchars($row['description']))?></p>
              <p class="card-text"><small class="text-muted">Found: <?=htmlspecialchars($row['date_found'])?> at <?=htmlspecialchars($row['location'])?></small></p>
              <a href="request.php?found_id=<?=urlencode($row['id'])?>" class="btn btn-primary">Request</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <p>No found items available.</p>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>