<?php
// checkout.php
session_start();
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);



$name = trim($_POST['name']);
$email = trim($_POST['email']);
$plan = $_POST['plan'];
$business_info = $_POST['business_info'];
$addons = $_POST['addons'] ?? [];
$services_selected = $_POST['services'] ?? [];
$user_id = $_SESSION['user_id'] ?? 0;

$plan_prices = ['basic' => 199, 'advanced' => 399, 'pro' => 699, 'custom' => 0];
$addon_prices = ['extra_ads' => 50, 'seo_audit' => 70, 'landing_page' => 90];
$total_price = $plan_prices[$plan] ?? 0;
foreach ($addons as $addon) {
    if (isset($addon_prices[$addon])) {
        $total_price += $addon_prices[$addon];
    }
}

$stmt = $conn->prepare("INSERT INTO orders (user_id, plan, status, total_price, notes) VALUES (?, ?, 'initiated', ?, ?)");
$notes = "Business Info: $business_info";
$stmt->bind_param("isds", $user_id, $plan, $total_price, $notes);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

foreach ($services_selected as $service) {
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, service_name, quantity, unit_price) VALUES (?, ?, 1, 0)");
    $stmt->bind_param("is", $order_id, $service);
    $stmt->execute();
    $stmt->close();
}

foreach ($addons as $addon) {
    $price = $addon_prices[$addon];
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, service_name, quantity, unit_price) VALUES (?, ?, 1, ?)");
    $stmt->bind_param("isd", $order_id, $addon, $price);
    $stmt->execute();
    $stmt->close();
}

$upload_dir = 'uploads/';
foreach ($_FILES['assets']['tmp_name'] as $key => $tmp_name) {
    if ($_FILES['assets']['error'][$key] === UPLOAD_ERR_OK) {
        $file_name = basename($_FILES['assets']['name'][$key]);
        $target_path = $upload_dir . time() . "_" . $file_name;
        move_uploaded_file($tmp_name, $target_path);

        $stmt = $conn->prepare("INSERT INTO uploads (order_id, file_name, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $order_id, $file_name, $target_path);
        $stmt->execute();
        $stmt->close();
    }
}

$checkout_session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'usd',
            'product_data' => ['name' => ucfirst($plan) . ' Plan from VSN Networks'],
            'unit_amount' => $total_price * 100
        ],
        'quantity' => 1
    ]],
    'mode' => 'payment',
    'success_url' => 'https://vsnnetworks.com/paymentsuccess.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => 'https://vsnnetworks.com/purchase.php?plan=' . $plan . '&cancelled=true',
    'customer_email' => $email,
    'metadata' => [
        'order_id' => $order_id,
        'user_id' => $user_id,
        'plan' => $plan
    ]
]);

$stmt = $conn->prepare("INSERT INTO payments (order_id, stripe_payment_id, amount, status) VALUES (?, ?, ?, 'pending')");
$stripe_id = $checkout_session->id;
$stmt->bind_param("isd", $order_id, $stripe_id, $total_price);
$stmt->execute();
$stmt->close();

header("Location: " . $checkout_session->url);
exit();
