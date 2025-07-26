<?php
$blogDir = __DIR__ . '/blogs';
$blogUrlBase = '/blogs'; // Adjust if your blogs folder is elsewhere

$blogFiles = glob($blogDir . '/*.php');
$blogFiles = array_merge($blogFiles, glob($blogDir . '/*.html'));

function formatTitle($filename) {
    $name = basename($filename, '.php');
    $name = basename($name, '.html');
    $name = str_replace(['-', '_'], ' ', $name);
    return ucwords($name);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Our Blog Articles | CleanPix</title>
  <?php include 'includes/head-main.html'; ?>
  <style>

    h1 {
      color: #333;
    }
    ul {
      list-style-type: none;
      padding: 0;
    }
    li.blogs-item {
      background: white;
      margin: 10px 0;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    a {
      text-decoration: none;
      color: #0077cc;
    }
    a:hover {
      text-decoration: underline;
    }
    .blogContainer{
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }
  </style>
</head>
<body>
    <?php include("includes/header.php"); ?>
    <div class="blogContainer">
  <h1>Explore Our Blog Articles</h1>
  <ul>
    <?php foreach ($blogFiles as $file): ?>
      <li class="blogs-item">
        <a href="<?= $blogUrlBase . '/' . basename($file) ?>">
          <?= formatTitle($file) ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
</body>
</html>
