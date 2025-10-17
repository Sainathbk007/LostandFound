<?php
// Admin navigation bar
session_start();
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="manage_lost.php">Manage Lost</a></li>
  <li class="nav-item"><a class="nav-link" href="manage_found.php">Manage Found</a></li>
        <li class="nav-item"><a class="nav-link" href="manage_requests.php">Manage Requests</a></li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>