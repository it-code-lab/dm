<?php
// register.php
session_start();
require_once 'includes/db.php';
require_once 'mailer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // use try catch for error handling
    try {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(16));



        $stmt = $conn->prepare("INSERT INTO users (name, email, password,verification_token) VALUES (?, ?, ?,?)");
        $stmt->bind_param("ssss", $name, $email, $password, $token);
        $stmt->execute();
        sendVerificationEmail($email, $name, $token);
        // Registration successful
        //$success = "Registration successful. Please check your email to verify your account.";
        header("Location: register.php?success=1");
        exit();
    } catch (Exception $e) {
        $error = "Email already exists.";
        header("Location: register.php?error=user_exists");
        exit();
    }



    // if ($stmt) {
    //     // $_SESSION['user_id'] = $conn->insert_id;
    //     // $_SESSION['user_name'] = $name;
    //     // header('Location: dashboard.php');
    //     // exit();
    // } else {
    //     $error = "Email already exists.";
    // }
}
?>
<!DOCTYPE html>
<html><head><title>Register</title>
<?php include 'includes/head-main.html'; ?> 
</head><body>
    <?php include 'includes/header.php'; ?>
<div class="medium-container">
<h2>Register</h2>

<?php if (isset($_GET['error']) && $_GET['error'] === 'user_exists'): ?>
<div class="alert alert-error">
    ❌ An account with this email already exists. Please <a href="login.php">log in</a>.
</div>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success">
    ✅ Registration successful. Please check your email to verify your account.
</div>
<?php endif; ?>
<form method="post">
    <label>Name:</label><input type="text" name="name" required><br>
    <label>Email:</label><input type="email" name="email" required><br>
    <label>Password:</label><input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>


<p>Already have an account? <a href="login.php">Login</a></p>
</div>  
<?php include 'includes/footer.php'; ?>
</body></html>
