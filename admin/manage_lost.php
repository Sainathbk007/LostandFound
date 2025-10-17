<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

// simple delete/approve via GET for brevity (could be POSTed instead)
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $mysqli->query("DELETE FROM lost_items WHERE id = $id");
    header('Location: manage_lost.php');
    exit;
}
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $mysqli->query("UPDATE lost_items SET status='resolved' WHERE id = $id");
    header('Location: manage_lost.php');
    exit;
}

$rows = $mysqli->query("SELECT * FROM lost_items ORDER BY date_lost DESC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Lost Items</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'admin_nav.php'; ?>
<div class="container py-4">
  <h1>Manage Lost Items</h1>
  <a class="btn btn-sm btn-primary mb-2" href="add_lost.php">Add Lost Item</a>
  <table class="table">
    <thead><tr><th>ID</th><th>Item</th><th>College ID</th><th>Date</th><th>Image</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      <?php while ($r = $rows->fetch_assoc()): ?>
        <tr>
          <td><?=htmlspecialchars($r['id'])?></td>
          <td><?=htmlspecialchars($r['item_name'])?></td>
          <td><?php $id = $r['student_college_id'] ?? ''; echo $id ? '***'.htmlspecialchars(substr($id, -4)) : ''; ?></td>
          <td><?=htmlspecialchars($r['date_lost'])?></td>
          <td><?php if (!empty($r['image'])): ?><img src="../uploads/<?=htmlspecialchars($r['image'])?>" style="max-width:80px;"><?php endif; ?></td>
          <td><?=htmlspecialchars($r['status'])?></td>
          <td>
            <a class="btn btn-sm btn-secondary" href="edit_lost.php?id=<?=urlencode($r['id'])?>">Edit</a>
            <a class="btn btn-sm btn-success" href="manage_lost.php?approve=<?=urlencode($r['id'])?>">Approve</a>
            <a class="btn btn-sm btn-danger" href="manage_lost.php?delete=<?=urlencode($r['id'])?>" onclick="return confirm('Delete?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>