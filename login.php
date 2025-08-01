<?php
// login.php
session_start();
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, is_verified, name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $user = $stmt->get_result();

    if ($user->num_rows > 0) {
        $user = $user->fetch_assoc();   
        if (password_verify($password, $user['password'])) {

            if (!$user['is_verified']) {
                header("Location: login.php?error=unverified");
                exit();
            }   
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $email;
            if ($user['role'] === 'admin') {
                $_SESSION['is_admin'] = true;
            }
            $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'dashboard.php';
            header("Location: $redirect");
            exit();
        } else {
            //$error = "loginerror";
            header("Location: login.php?error=loginerror");
            exit();
        }
    } else {
        header("Location: login.php?error=loginerror");
        exit();
    }
}
?>
<!DOCTYPE html>
<html><head>
  <?php include 'includes/head-main.html'; ?>    
<title>Login</title></head>

<body>
    <?php include 'includes/header.php'; ?>
    <div class="medium-container">
<h2>Login</h2>
<?php if (isset($_GET['error']) && $_GET['error'] === 'unverified'): ?>
<div class="alert alert-error">
    ⚠ Please verify your email before logging in.
</div>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] === 'loginerror'): ?>
<div class="alert alert-error">
    ⚠ Email id or password is incorrect.
</div>
<?php endif; ?>


<?php if (isset($_GET['verified'])): ?>
<div class="alert alert-success">
    ✅ Your email has been verified. Please log in.
</div>
<?php endif; ?>

<?php if (isset($_GET['pwreset'])): ?>
<div class="alert alert-success">
    ✅ Your password has been reset successfully. Please log in.
</div>
<?php endif; ?>

<form method="post">
    <label>Email:</label><input type="email" name="email" required><br>
    <label>Password:</label><input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>

<p>Don't have an account? <a href="register.php">Register</a></p>
<p><a href="forgot-password.php">Forgot Password?</a></p>
</div>
<!--  include ?includes/footer.php?;-->

<?php include 'includes/footer.php'; ?>
</body></html>