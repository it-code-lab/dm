<?php
require 'vendor/autoload.php';
require_once 'includes/auth.php';
require_once 'includes/db.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$stripe = new \Stripe\StripeClient($_ENV['STRIPE_SECRET_KEY']);

try {
    $session_id = $_GET['session_id'];
    $session = $stripe->checkout->sessions->retrieve($session_id);

    if (!$session || $session->payment_status !== 'paid') {
        throw new Exception("Payment not completed.");
    }

    // Extract data from Stripe session
    $user_id = $_SESSION['user_id'] ?? null;
    $order_id = isset($session->metadata->order_id) ? (int)$session->metadata->order_id : 0;
    //$usd_price = isset($session->metadata->usd_price) ? (float)$session->metadata->usd_price : 0;
    // $converted_price = isset($session->metadata->converted_price) ? (float)$session->metadata->converted_price : 0;
    // $currency = strtoupper($session->currency);
    // $amount_paid = round($session->amount_total / 100, 2); // from Stripe

    // Validate the amount paid is close to the metadata's converted_price
    // if (abs($converted_price - $amount_paid) > 0.50) {
    //     throw new Exception("Payment amount does not match expected price. Contact support.");
    // }

    // Update status in DB
    $status = 'paid'; 
    $stmt = $conn->prepare("UPDATE orders SET status =  ? WHERE id = ?");
    $stmt->execute([$status, $order_id]);


    $stmt = $conn->prepare("UPDATE payments SET status =  ? WHERE id = ?");
    $stmt->execute([$status, $order_id]);
    


    // Show confirmation screen
    echo "<!DOCTYPE html>
    <html>
    <head>
      <title>Payment Successful</title>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
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
      </style>
    </head>
    <body>
      <?php include 'includes/header.php'; ?>
      <div class='confirmation'>
        <h1>🎉 Payment Successful!</h1>

        <?php if (isLoggedIn()): ?>
          <p>Your order has been placed successfully.</p>
          <a class='cta-button' href='dashboard.php'>Go to Dashboard</a>
        <?php else: ?>
          <p>Thank you for your order.</p>
          <p><a href='login.php' >Login/Create an account</a> to track your orders and add files.</p>
          
        <?php endif; ?>
      </div>
    </body>
    </html>";
    exit();

} catch (Exception $e) {
    echo "<p style='color:red; text-align:center;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p style='text-align:center;'><a href='dashboard.php'>← Back to Dashboard</a></p>";
}
?>
