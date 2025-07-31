<?php
require_once("includes/db.php");

if (!isset($_GET['token'])) {
  die("Invalid link.");
}

$token = $_GET['token'];

$stmt = $conn->prepare("SELECT id FROM users WHERE verification_token = ? ");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
  $stmt = $conn->prepare("UPDATE users SET is_verified = 1, verification_token = NULL WHERE id = ?");
  $stmt->bind_param("i", $user['id']);
  $stmt->execute();
  header("Location: login.php?verified=1");
} else {
  echo "Invalid or expired token.";
}
?>
