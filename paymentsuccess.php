<?php
require 'vendor/autoload.php';
require_once 'includes/auth.php';
require_once 'includes/db.php';

require_once 'mailer.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);

$success = false;
$error_message = '';
$is_logged_in = isLoggedIn();

try {
    $session_id = $_GET['session_id'] ?? null;
    if (!$session_id) throw new Exception("Session ID not provided.");

    $session = $stripe->checkout->sessions->retrieve($session_id);
    if (!$session || $session->payment_status !== 'paid') {
        throw new Exception("Payment not completed.");
    }

    $user_id = $_SESSION['user_id'] ?? null;
    $order_id = isset($session->metadata->order_id) ? (int)$session->metadata->order_id : 0;

    $status = 'paid';
    $stmt = $conn->prepare("UPDATE orders SET status =  ? WHERE id = ?");
    $stmt->execute([$status, $order_id]);

    $stmt = $conn->prepare("UPDATE payments SET status =  ? WHERE id = ?");
    $stmt->execute([$status, $order_id]);

    sendPaymentNotificationToAdmin($order_id);

    $success = true;

} catch (Exception $e) {
    $error_message = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Status</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include 'includes/head-main.html'; ?>
  <style>
    .confirmation {
      max-width: 600px;
      margin: 80px auto;
      text-align: center;
      padding: 40px;
      background: #f0fff0;
      border: 1px solid #c1eac5;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .confirmation h1 { color: #2e7d32; }
    .confirmation p { font-size: 18px; margin-top: 10px; }
    .cta-button {
      display: inline-block;
      margin-top: 30px;
      padding: 12px 24px;
      background-color: #4CAF50;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }
    .error {
      color: red;
      background: #fff0f0;
      border: 1px solid #e0b4b4;
    }
    a {
      color: #1e88e5;
      text-decoration: underline;
    }
    .medium-container {
      text-align: center;
    }
  </style>
</head>
<body>
  <?php include 'includes/header.php'; ?>
  <div class="medium-container <?= $success ? '' : 'error' ?>">
    <?php if ($success): ?>
      <h3>🎉 Payment Successful!</h3>
      <?php if ($is_logged_in): ?>
        <p>Your order has been placed successfully.</p>
        <a class="cta-button" href="dashboard.php">Go to Dashboard</a>
      <?php else: ?>
        <p>Thank you for your order.</p>
        <p><a href="login.php">Login/Create an account</a> to track your orders.</p>
      <?php endif; ?>
    <?php else: ?>
      <h3>❌ Payment Failed</h3>
      <p><?= htmlspecialchars($error_message) ?></p>
      <a class="cta-button" href="dashboard.php">← Back to Dashboard</a>
    <?php endif; ?>
  </div>
</body>
</html>
