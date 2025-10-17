<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $mysqli->query("UPDATE requests SET status='approved' WHERE id = $id");
    header('Location: manage_requests.php'); exit;
}
if (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);
    $mysqli->query("UPDATE requests SET status='rejected' WHERE id = $id");
    header('Location: manage_requests.php'); exit;
}

$rows = $mysqli->query("SELECT r.*, f.item_name FROM requests r LEFT JOIN found_items f ON r.found_item_id = f.id ORDER BY r.id DESC");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Requests</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'admin_nav.php'; ?>
<div class="container py-4">
  <h1>Manage Requests</h1>
  <table class="table">
    <thead><tr><th>ID</th><th>Found Item</th><th>Requester</th><th>Contact</th><th>Message</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      <?php while ($r = $rows->fetch_assoc()): ?>
        <tr>
          <td><?=htmlspecialchars($r['id'])?></td>
          <td><?=htmlspecialchars($r['item_name'])?></td>
          <td><?=htmlspecialchars($r['requester_name'])?></td>
          <td><?=htmlspecialchars($r['contact_info'])?></td>
          <td><?=nl2br(htmlspecialchars($r['message']))?></td>
          <td><?=htmlspecialchars($r['status'])?></td>
          <td>
            <a class="btn btn-sm btn-success" href="manage_requests.php?approve=<?=urlencode($r['id'])?>">Approve</a>
            <a class="btn btn-sm btn-danger" href="manage_requests.php?reject=<?=urlencode($r['id'])?>">Reject</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>