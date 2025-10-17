<?php
// Simple test page to verify uploads are served and writable
$uploadsDir = __DIR__ . '/uploads';
$writable = is_writable($uploadsDir) ? 'writable' : 'not writable';
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Uploads test</title>
  <link href="assets/style.css" rel="stylesheet">
</head>
<body class="p-4">
  <h1>Uploads Test</h1>
  <p>Uploads directory is: <strong><?=htmlspecialchars($writable)?></strong></p>
  <div>
    <h2>Sample image (uploads/sample.svg)</h2>
    <img src="uploads/sample.svg" alt="sample" style="max-width:300px; border:1px solid #ddd; padding:8px; background:#fff">
  </div>
</body>
</html>