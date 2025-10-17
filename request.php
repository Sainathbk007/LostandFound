<?php
require_once __DIR__ . '/includes/db.php';
$found_id = intval($_GET['found_id'] ?? 0);
$message = null;

// Fetch the found item
$stmt = $mysqli->prepare("SELECT id, item_name, description FROM found_items WHERE id = ? AND status != 'deleted'");
$stmt->bind_param('i', $found_id);
$stmt->execute();
$res = $stmt->get_result();
$item = $res->fetch_assoc();
$stmt->close();

if (!$item) {
    die('Found item not found.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['requester_name'] ?? '');
    $contact = trim($_POST['contact_info'] ?? '');
    $message_text = trim($_POST['message'] ?? '');

    if ($name === '' || $contact === '') {
        $message = 'Please provide your name and contact info.';
    } else {
        $stmt = $mysqli->prepare("INSERT INTO requests (found_item_id, requester_name, contact_info, message, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->bind_param('isss', $found_id, $name, $contact, $message_text);
        $ok = $stmt->execute();
        $stmt->close();
        if ($ok) {
            $message = 'success';
        } else {
            $message = 'Failed to submit request.';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Request Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'partials/navbar.php'; ?>
<div class="container py-4">
  <h1>Request: <?=htmlspecialchars($item['item_name'])?></h1>
  <p><?=nl2br(htmlspecialchars($item['description']))?></p>

  <?php if ($message && $message !== 'success'): ?>
    <div class="alert alert-danger"><?=htmlspecialchars($message)?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label class="form-label">Your Name</label>
      <input name="requester_name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Contact Info</label>
      <input name="contact_info" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Message</label>
      <textarea name="message" class="form-control"></textarea>
    </div>
    <button class="btn btn-primary">Send Request</button>
  </form>
</div>

<!-- Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        Your request was submitted.
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
</script>
</body>
</html>