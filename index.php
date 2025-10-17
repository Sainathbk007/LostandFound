<?php
// Home page - shows links to pages
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lost & Found</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
  <a class="navbar-brand" href="index.php">Lost & Found</a>
    <div class="collapse navbar-collapse">
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

<div class="container py-5 white-cards">
  <h1>Welcome to the Lost & Found</h1>
  <p class="lead">Browse lost and found items, report a lost item, or request a found item.</p>
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Lost Items</h5>
          <p class="card-text">View items reported lost by others.</p>
          <a href="lost.php" class="btn btn-primary">View Lost</a>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Found Items</h5>
          <p class="card-text">View items someone found and offered for claim.</p>
          <a href="found.php" class="btn btn-primary">View Found</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>