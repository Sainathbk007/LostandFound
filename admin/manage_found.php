<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $mysqli->query("DELETE FROM found_items WHERE id = $id");
    header('Location: manage_found.php'); exit;
}
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $mysqli->query("UPDATE found_items SET status='available' WHERE id = $id");
    header('Location: manage_found.php'); exit;
}

$rows = $mysqli->query("SELECT * FROM found_items ORDER BY date_found DESC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Found Items</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'admin_nav.php'; ?>
<div class="container py-4">
  <h1>Manage Found Items</h1>
  <a class="btn btn-sm btn-primary mb-2" href="add_found.php">Add Found Item</a>
  <table class="table">
    <thead><tr><th>ID</th><th>Item</th><th>College ID</th><th>Date</th><th>Image</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      <?php while ($r = $rows->fetch_assoc()): ?>
        <tr>
          <td><?=htmlspecialchars($r['id'])?></td>
          <td><?=htmlspecialchars($r['item_name'])?></td>
          <td><?php $id = $r['student_college_id'] ?? ''; echo $id ? '***'.htmlspecialchars(substr($id, -4)) : ''; ?></td>
          <td><?=htmlspecialchars($r['date_found'])?></td>
          <td><?php if (!empty($r['image'])): ?><img src="../uploads/<?=htmlspecialchars($r['image'])?>" style="max-width:80px;"><?php endif; ?></td>
          <td><?=htmlspecialchars($r['status'])?></td>
          <td>
            <a class="btn btn-sm btn-secondary" href="edit_found.php?id=<?=urlencode($r['id'])?>">Edit</a>
            <a class="btn btn-sm btn-success" href="manage_found.php?approve=<?=urlencode($r['id'])?>">Approve</a>
            <a class="btn btn-sm btn-danger" href="manage_found.php?delete=<?=urlencode($r['id'])?>" onclick="return confirm('Delete?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>