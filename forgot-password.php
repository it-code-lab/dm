<?php
// send-reset-link.php
session_start();
require_once 'includes/db.php';
require_once 'mailer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
    $stmt->bind_param("sss", $token, $expires, $email);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $reset_link = "https://vsnnetworks.com/reset-password.php?token=$token";
        // In production, send via email. Here, simulate it.
        // Send email
        sendPasswordResetEmail($email, $token, $user['first_name'] ?? 'User');
        //echo "<p><a href='$reset_link'>Click here to reset your password</a></p>";
        $success = "A reset link has been sent to your email";
        header("Location: forgot-password.php?success=1");
        $stmt->close();
        exit();
    } else {
        //$error = "Email not found.";
        header("Location: forgot-password.php?error=not_found");
        $stmt->close();
        exit();
    }
    
}
?>
<!DOCTYPE html>
<html><head><title>Forgot Password</title>
<?php include 'includes/head-main.html'; ?>
</head><body>
<?php include 'includes/header.php'; ?>
<div class="medium-container">
    <h2>Forgot Password</h2>

<?php if (isset($_GET['error']) && $_GET['error'] === 'not_found'): ?>
<div class="alert alert-error">
    ❌ No account found with this email. Please <a href="register.php">register</a>.
</div>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success">
    ✅ Password reset link has been sent to your email.

</div>
<?php endif; ?>
    <form method="post" >
        <label>Enter your registered email:</label>
        <input type="email" name="email" required><br>
        <button type="submit">Send Reset Link</button>
    </form>

</form>

<p><a href="login.php">Back to Login</a></p>
</div>
<?php include 'includes/footer.php'; ?>
</body></html>