<?php
// reset-password.php
session_start();
require_once 'includes/db.php';

$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE reset_token = ? AND reset_expires > NOW()");
    $stmt->bind_param('ss', $new_password, $token);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        // echo "<p>Password reset successful. <a href='login.php'>Login now</a></p>";
        header("Location: login.php?pwreset=1");
    } else {
        //echo "<p>Invalid or expired token.</p>";
        header("Location: reset-password.php?error=invexp");
        exit();
}
    $stmt->close();
    exit();
}
?>

<!DOCTYPE html>
<html><head><title>Reset Password</title><?php include 'includes/head-main.html'; ?></head><body>
    <?php include 'includes/header.php'; ?>
<div class="medium-container">
<h2>Reset Your Password</h2>

<?php if (isset($_GET['error']) && $_GET['error'] === 'invexp'): ?>
<div class="alert alert-error">
    ⚠ Invalid or expired token.
</div>
<?php endif; ?>

<form method="post">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
    <label>New Password:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Reset Password</button>
</form>
</div>
</body></html>