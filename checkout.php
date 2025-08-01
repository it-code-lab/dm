<?php
// checkout.php
session_start();
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);



$name = trim($_POST['name']) ?? '';
$email = trim($_POST['email']) ?? '';
$plan = $_SESSION['plan'] ?? '';
$business_info = $_POST['business_info'] ?? '';
$primary_goals = $_POST['primary_goals'] ?? '';
$competitors = $_POST['competitors'] ?? '';
$duration = $_POST['duration'] ?? 1;

$addons = $_POST['addons'] ?? [];
$services_selected = $_POST['services'] ?? [];
$user_id = $_SESSION['user_id'] ?? 0;

// --- 2. Define pricing (match this with purchase.php) ---
$plan_prices = ['basic' => 300, 'advanced' => 500, 'pro' => 800];
$addon_prices = [
    'website_development' => 500,
    'website_redesign' => 1000
];

// --- 3. Calculate total price with discounts ---
function getDiscountFactor($months) {
    if ($months == 3) return 0.95;     // 5% off
    if ($months == 6) return 0.90;     // 10% off
    if ($months == 12) return 0.80;    // 20% off
    return 1.0;
}

$base_price = $plan_prices[$plan] ?? 0;
$plan_total = $base_price * (int)$duration * getDiscountFactor((int)$duration);

$addon_total = 0;
foreach ($addons as $addon) {
    if (isset($addon_prices[$addon])) {
        $addon_total += $addon_prices[$addon];
    }
}
$total_price = $plan_total + $addon_total;

// --- 4. Prepare detailed service information as JSON ---
$detailed_service_info = [];
$service_keys = [
    'onpage_url', 'onpage_keywords', 'onpage_location', 'onpage_previous_efforts',
    'ppc_budget', 'ppc_offerings', 'ppc_audience', 'ppc_conversion',
    'gmb_name', 'gmb_address', 'gmb_phone',
    'tech_platform', 'tech_access',
    'content_formats', 'content_voice', 'content_goals',
    'social_profiles', 'social_goals', 'social_messaging',
    'email_platform', 'email_goal', 'email_list_info',
    'website_purpose', 'website_features', 'website_examples',
    'redesign_url', 'redesign_goals', 'redesign_audience', 'redesign_cms', 'redesign_functionality', 'redesign_examples', 'redesign_content_status', 'redesign_notes'
];

foreach ($service_keys as $key) {
    if (isset($_POST[$key]) && !empty($_POST[$key])) {
        $detailed_service_info[$key] = $_POST[$key];
    }
}
$detailed_service_info_json = json_encode($detailed_service_info);

$stmt = $conn->prepare("INSERT INTO orders (user_id, name, email, plan, status, total_price, notes, primary_goals, competitors, detailed_service_info) VALUES (?, ?, ?, ?, 'initiated', ?, ?, ?, ?, ?)");
$notes = $business_info ? "$business_info" : '';
$stmt->bind_param("isssdssss", $user_id, $name, $email, $plan,  $total_price, $notes, $primary_goals, $competitors, $detailed_service_info_json);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

$all_services = [
    'onpage_seo' => 'On-Page SEO',
    'meta_ads' => 'PPC (Pay-Per-Click) Advertising (Ads)',
    'gmb' => 'Google My Business (Local SEO)',
    'technical_seo' => 'Technical SEO',
    'content_marketing' => 'Content Marketing',
    'social_media' => 'Social Media Marketing',
    'email_marketing' => 'Email Marketing'
];



// foreach ($services_selected as $service) {
//     $stmt = $conn->prepare("INSERT INTO order_items (order_id, service_name, quantity, unit_price) VALUES (?, ?, 1, 0)");
//     $stmt->bind_param("is", $order_id, $service);
//     $stmt->execute();
//     $stmt->close();
// }

foreach ($services_selected as $service_key) {
    // Check if the key exists in the $all_services array
    if (array_key_exists($service_key, $all_services)) {
        // If the key exists, get the full service name
        $service_name = $all_services[$service_key];
    } else {
        // If the key does not exist, use the key itself as the service name
        // You could also add logging here to alert you to an unknown service key
        $service_name = $service_key;
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, service_name, quantity, unit_price) VALUES (?, ?, 1, 0)");
    
    // Bind the parameters
    $stmt->bind_param("is", $order_id, $service_name);
    
    // Execute the statement
    $stmt->execute();
    
    // Close the statement
    $stmt->close();
}

// Your existing array for addons
$all_addons = [
    'website_development' => 'Website Development (Simple landing page)',
    'website_redesign' => 'Website Development (Website Redesign)'
];

// Loop through the selected addons
foreach ($addons as $addon_key) {
    // Check if the key exists in the $all_addons array
    if (array_key_exists($addon_key, $all_addons)) {
        // If the key exists, use the friendly name from the mapping
        $addon_name = $all_addons[$addon_key];
    } else {
        // If the key does not exist, use the key itself as the addon name
        $addon_name = $addon_key;
    }
    
    // Assuming $addon_prices is a separate array mapping keys to prices
    $price = $addon_prices[$addon_key];
    
    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, service_name, quantity, unit_price) VALUES (?, ?, 1, ?)");
    
    // Bind the parameters: order_id, the (now resolved) addon name, and the price
    $stmt->bind_param("isd", $order_id, $addon_name, $price);
    
    // Execute the statement
    $stmt->execute();
    
    // Close the statement
    $stmt->close();
}

// $all_addons = [
//     'website_development' => 'Website Development (Simple landing page)',
//     'website_redesign' => 'Website Development (Website Redesign)'
// ];

// foreach ($addons as $addon) {
//     $price = $addon_prices[$addon];
//     $stmt = $conn->prepare("INSERT INTO order_items (order_id, service_name, quantity, unit_price) VALUES (?, ?, 1, ?)");
//     $stmt->bind_param("isd", $order_id, $addon, $price);
//     $stmt->execute();
//     $stmt->close();
// }

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
