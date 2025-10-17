<?php
require_once __DIR__ . '/includes/db.php';
$message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic validation and insert
    $item_name = trim($_POST['item_name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $date_found = trim($_POST['date_found'] ?? '');
  $location = trim($_POST['location'] ?? '');
  $contact_info = trim($_POST['contact_info'] ?? '');
  $student_college_id = trim($_POST['student_college_id'] ?? '');

  if ($item_name === '' || $contact_info === '' || $student_college_id === '') {
    $message = 'Please provide at least item name, contact info, and your college ID.';
    } else {
        $imageFilename = null;
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
      // server-side validation
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
      finfo_close($finfo);
      $allowed = ['image/png','image/jpeg','image/gif','image/webp'];
      if (!in_array($mime, $allowed, true) || $_FILES['image']['size'] > 2 * 1024 * 1024) {
        $message = 'Invalid image uploaded (type or size).';
      } else {
        $uploaddir = __DIR__ . '/uploads/';
        $orig = basename($_FILES['image']['name']);
        $ext = pathinfo($orig, PATHINFO_EXTENSION);
        $safe = preg_replace('/[^a-zA-Z0-9._-]/', '_', pathinfo($orig, PATHINFO_FILENAME));
        $imageFilename = uniqid() . '-' . $safe . ($ext ? '.' . $ext : '');
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir . $imageFilename)) {
          $imageFilename = null; // upload failed
        }
      }
    }

  $stmt = $mysqli->prepare("INSERT INTO found_items (item_name, description, date_found, location, contact_info, student_college_id, image, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'available')");
  $stmt->bind_param('sssssss', $item_name, $description, $date_found, $location, $contact_info, $student_college_id, $imageFilename);
        $ok = $stmt->execute();
        $stmt->close();
        if ($ok) {
            $message = 'success';
        } else {
            $message = 'Failed to submit. Please try again.';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Report Found Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'partials/navbar.php'; ?>
<div class="container py-4">
  <h1>Report Found Item</h1>
  <?php if ($message && $message !== 'success'): ?>
    <div class="alert alert-danger"><?=htmlspecialchars($message)?></div>
  <?php endif; ?>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Item Name</label>
      <input name="item_name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Date Found</label>
      <input type="date" name="date_found" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Location</label>
      <input name="location" class="form-control">
    </div>
    <div class="mb-3">
      <label class="form-label">Contact Info</label>
      <input name="contact_info" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Your College ID</label>
      <input name="student_college_id" id="student_college_id" class="form-control" required placeholder="e.g. 2025ABC123">
    </div>
    <div class="mb-3">
      <label class="form-label">Image (optional)</label>
      <input type="file" id="imageInput" name="image" accept="image/*" class="form-control">
      <div class="mt-2"><img id="preview" style="max-width:200px; display:none; border:1px solid #ddd; padding:6px; background:#fff"></div>
    </div>
    <button class="btn btn-primary">Submit</button>
  </form>
</div>

<!-- Toast for success -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        Your found item report was submitted.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
<?php if ($message === 'success'): ?>
  var toastEl = document.getElementById('successToast');
  var toast = new bootstrap.Toast(toastEl);
  toast.show();
<?php endif; ?>
// client-side validation and preview
const input = document.getElementById('imageInput');
const preview = document.getElementById('preview');
if (input) {
  input.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (!file) { preview.style.display = 'none'; return; }
    const allowed = ['image/png','image/jpeg','image/gif','image/webp'];
    if (!allowed.includes(file.type)) {
      alert('Only PNG/JPEG/GIF/WEBP images are allowed.');
      e.target.value = '';
      preview.style.display = 'none';
      return;
    }
    const max = 2 * 1024 * 1024; // 2MB
    if (file.size > max) {
      alert('File too large. Max 2MB.');
      e.target.value = '';
      preview.style.display = 'none';
      return;
    }
    const reader = new FileReader();
    reader.onload = function(ev) { preview.src = ev.target.result; preview.style.display = 'block'; }
    reader.readAsDataURL(file);
  });
}
</script>
</body>
</html>
