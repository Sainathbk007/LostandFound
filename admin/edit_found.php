<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; }

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: manage_found.php'); exit; }

// Fetch item
$stmt = $mysqli->prepare("SELECT * FROM found_items WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$item = $res->fetch_assoc();
$stmt->close();
if (!$item) { header('Location: manage_found.php'); exit; }

$message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['item_name'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $date_found = trim($_POST['date_found'] ?? '');
  $location = trim($_POST['location'] ?? '');
  $contact = trim($_POST['contact_info'] ?? '');
  $student_college_id = trim($_POST['student_college_id'] ?? '');
  $status = trim($_POST['status'] ?? 'available');

  $filename = $item['image'];
  if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // server-side validation
    $allowed = ['image/png','image/jpeg','image/gif','image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
    finfo_close($finfo);
    if (!in_array($mime, $allowed, true) || $_FILES['image']['size'] > 2 * 1024 * 1024) {
      $message = 'Invalid image uploaded (type or size).';
    } else {
      $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
      $safe = uniqid() . '.' . $ext;
      if (move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../uploads/' . $safe)) {
        $filename = $safe;
      } else {
        $message = 'Failed to move uploaded file.';
      }
    }
  }

  $stmt = $mysqli->prepare("UPDATE found_items SET item_name = ?, description = ?, date_found = ?, location = ?, contact_info = ?, student_college_id = ?, image = ?, status = ? WHERE id = ?");
  $stmt->bind_param('ssssssssi', $name, $desc, $date_found, $location, $contact, $student_college_id, $filename, $status, $id);
    $ok = $stmt->execute();
    $stmt->close();
    $message = $ok ? 'Saved' : 'Failed';

    // refresh
    $stmt = $mysqli->prepare("SELECT * FROM found_items WHERE id = ? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $item = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Found Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'admin_nav.php'; ?>
<div class="container py-4">
  <h1>Edit Found Item #<?=htmlspecialchars($item['id'])?></h1>
  <?php if ($message): ?><div class="alert alert-info"><?=htmlspecialchars($message)?></div><?php endif; ?>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3"><label class="form-label">Item Name</label><input name="item_name" class="form-control" value="<?=htmlspecialchars($item['item_name'])?>" required></div>
    <div class="mb-3"><label class="form-label">Student College ID</label><input name="student_college_id" class="form-control" value="<?=htmlspecialchars($item['student_college_id'] ?? '')?>" required></div>
    <div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control"><?=htmlspecialchars($item['description'])?></textarea></div>
    <div class="mb-3"><label class="form-label">Date Found</label><input type="date" name="date_found" class="form-control" value="<?=htmlspecialchars($item['date_found'])?>"></div>
    <div class="mb-3"><label class="form-label">Location</label><input name="location" class="form-control" value="<?=htmlspecialchars($item['location'])?>"></div>
    <div class="mb-3"><label class="form-label">Contact Info</label><input name="contact_info" class="form-control" value="<?=htmlspecialchars($item['contact_info'])?>"></div>
    <div class="mb-3"><label class="form-label">Image</label><input type="file" id="imageInput" name="image" class="form-control"></div>
    <?php if (!empty($item['image'])): ?>
      <div class="mb-3"><img id="existingImage" src="../uploads/<?=htmlspecialchars($item['image'])?>" style="max-width:200px"></div>
    <?php endif; ?>
    <div class="mb-3"><label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="available" <?=($item['status']=='available'?'selected':'')?>>available</option>
        <option value="claimed" <?=($item['status']=='claimed'?'selected':'')?>>claimed</option>
        <option value="removed" <?=($item['status']=='removed'?'selected':'')?>>removed</option>
      </select>
    </div>
    <button class="btn btn-primary">Save</button>
  </form>
</div>
</body>
</html>
<script>
// preview for admin edit found page
const adminImageInput = document.getElementById('imageInput');
const existingImage = document.getElementById('existingImage');
if (adminImageInput) {
  adminImageInput.addEventListener('change', (e) => {
    const f = e.target.files[0];
    if (!f) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
      if (existingImage) existingImage.src = ev.target.result;
    }
    reader.readAsDataURL(f);
  });
}
</script>