<?php
// send-reset-link.php
session_start();
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
    $stmt->bind_param("sss", $token, $expires, $email);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $reset_link = "https://vsnnetworks.com/reset-password.php?token=$token";
        // In production, send via email. Here, simulate it.
        echo "<p>A reset link has been sent to your email.</p>";
        echo "<p><a href='$reset_link'>Click here to reset your password</a></p>";
    } else {
        echo "<p>Email not found or error occurred.</p>";
    }
    $stmt->close();
}
?>