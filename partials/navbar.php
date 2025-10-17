<?php
// Simple navbar included in pages
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/style.css" rel="stylesheet">
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container-fluid">
  <a class="navbar-brand" href="index.php">Lost & Found</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample" aria-controls="navbarsExample" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExample">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
  <li class="nav-item"><a class="nav-link" href="lost.php">Lost Items</a></li>
  <li class="nav-item"><a class="nav-link" href="found.php">Found Items</a></li>
  <li class="nav-item"><a class="nav-link" href="add_lost.php">Report Lost Item</a></li>
  <li class="nav-item"><a class="nav-link" href="add_found.php">Report Found Item</a></li>
  <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>
      <ul class="navbar-nav">
  <li class="nav-item"><a class="nav-link" href="admin/login.php">Admin</a></li>
      </ul>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
