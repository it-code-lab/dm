<?php
// purchase.php
session_start();
require_once 'includes/db.php';
require_once 'includes/auth.php';

$plan = isset($_GET['plan']) ? strtolower(trim($_GET['plan'])) : '';
$valid_plans = ['basic', 'advanced', 'pro', 'custom'];

if (!in_array($plan, $valid_plans)) {
    die("Invalid plan selected.");
}

$plan_details = [
    'basic' => ['price' => 300, 'label' => 'Basic Plan', 'services' => ['onpage_seo', 'meta_ads', 'gmb']],
    'advanced' => ['price' => 500, 'label' => 'Advanced Plan', 'services' => ['onpage_seo', 'meta_ads', 'gmb', 'technical_seo']],
    'pro' => ['price' => 800, 'label' => 'Pro Plan', 'services' => ['onpage_seo', 'meta_ads', 'gmb', 'technical_seo', 'reels', 'email_marketing']],
    'custom' => ['price' => 0, 'label' => 'Custom Plan (we will review your request)', 'services' => []]
];

$current_plan = $plan_details[$plan];
$form_data = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']); // clear after use
?>

<!DOCTYPE html>
<html>
<head>
    <title>Purchase - <?= htmlspecialchars($current_plan['label']) ?></title>
    <?php include 'includes/head-main.html'; ?>
    <style>
        .service-section, .addon-section { margin: 15px 0; padding: 10px; border: 1px solid #ccc; }
        .hidden { display: none; }
    </style>
    <style>
    .modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; }
    .modal-content { background: white; margin: 10% auto; padding: 20px; width: 400px; border-radius: 6px; }
    .close { float: right; font-size: 20px; cursor: pointer; }
    </style>    
</head>
<body>
    <?php include 'includes/header.php'; ?>
<div class="medium-container">
    <h2><?= htmlspecialchars($current_plan['label']) ?> - Service Request</h2>
    <form id="purchaseForm" action="checkout.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="plan" value="<?= htmlspecialchars($plan) ?>">
        <input type="hidden" id="basePrice" value="<?= $current_plan['price'] ?>">

        <label>Your Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($form_data['name'] ?? '') ?>" required>

        <label>Your Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($form_data['email'] ?? '') ?>" required>

        <label>Website / Business Info</label>
        <textarea name="business_info" rows="4" required><?= htmlspecialchars($form_data['business_info'] ?? '') ?></textarea>

        <label>Upload Brand Assets</label>
        <input type="file" name="assets[]" multiple>

        <h3>Select Services to Include:</h3>
        <div id="serviceList">
            <?php
            $all_services = [
                'onpage_seo' => 'On-Page SEO',
                'meta_ads' => 'Meta Ads',
                'gmb' => 'Google My Business',
                'technical_seo' => 'Technical SEO',
                'reels' => 'Reels',
                'email_marketing' => 'Email Marketing'
            ];
            foreach ($all_services as $key => $label) {
                $checked = in_array($key, $form_data['services'] ?? $current_plan['services']) ? 'checked' : '';
                echo "<label><input type='checkbox' name='services[]' value='$key' class='service-toggle' $checked> $label</label><br>";
            }
            ?>
        </div>

        <div id="serviceDetails">
            <div id="onpage_seo" class="service-section hidden">
                <h4>On-Page SEO</h4>
                <label>Website URL</label>
                <input type="url" name="onpage_url" value="<?= htmlspecialchars($form_data['onpage_url'] ?? '') ?>">
                <label>Target Keywords</label>
                <input type="text" name="onpage_keywords" value="<?= htmlspecialchars($form_data['onpage_keywords'] ?? '') ?>">
                <label>Target Location</label>
                <input type="text" name="onpage_location" value="<?= htmlspecialchars($form_data['onpage_location'] ?? '') ?>">
            </div>
            <div id="meta_ads" class="service-section hidden">
                <h4>Meta Ads</h4>
                <label>Ad Type</label>
                <select name="meta_ad_type">
                    <option value="traffic" <?= ($form_data['meta_ad_type'] ?? '') == 'traffic' ? 'selected' : '' ?>>Traffic</option>
                    <option value="leads" <?= ($form_data['meta_ad_type'] ?? '') == 'leads' ? 'selected' : '' ?>>Leads</option>
                    <option value="conversions" <?= ($form_data['meta_ad_type'] ?? '') == 'conversions' ? 'selected' : '' ?>>Conversions</option>
                </select>
                <label>Target Audience</label>
                <input type="text" name="meta_audience" value="<?= htmlspecialchars($form_data['meta_audience'] ?? '') ?>">
            </div>
            <div id="gmb" class="service-section hidden">
                <h4>Google My Business</h4>
                <label>Business Name</label>
                <input type="text" name="gmb_name" value="<?= htmlspecialchars($form_data['gmb_name'] ?? '') ?>">
                <label>Address</label>
                <input type="text" name="gmb_address" value="<?= htmlspecialchars($form_data['gmb_address'] ?? '') ?>">
                <label>Phone</label>
                <input type="text" name="gmb_phone" value="<?= htmlspecialchars($form_data['gmb_phone'] ?? '') ?>">
            </div>
            <div id="technical_seo" class="service-section hidden">
                <h4>Technical SEO</h4>
                <label>Website Platform (CMS)</label>
                <input type="text" name="tech_platform" value="<?= htmlspecialchars($form_data['tech_platform'] ?? '') ?>">
                <label>Access Details / Link</label>
                <textarea name="tech_access"><?= htmlspecialchars($form_data['tech_access'] ?? '') ?></textarea>
            </div>
            <div id="reels" class="service-section hidden">
                <h4>Reels</h4>
                <label>Topic/Niche</label>
                <input type="text" name="reels_topic" value="<?= htmlspecialchars($form_data['reels_topic'] ?? '') ?>">
                <label>Do you have your own content?</label>
                <select name="reels_content">
                    <option value="yes" <?= ($form_data['reels_content'] ?? '') == 'yes' ? 'selected' : '' ?>>Yes</option>
                    <option value="no" <?= ($form_data['reels_content'] ?? '') == 'no' ? 'selected' : '' ?>>No, please create</option>
                </select>
            </div>
            <div id="email_marketing" class="service-section hidden">
                <h4>Email Marketing</h4>
                <label>Email Platform (e.g. Mailchimp)</label>
                <input type="text" name="email_platform" value="<?= htmlspecialchars($form_data['email_platform'] ?? '') ?>">
                <label>Objective</label>
                <input type="text" name="email_goal" value="<?= htmlspecialchars($form_data['email_goal'] ?? '') ?>">
            </div>
        </div>

        <h3>Optional Add-ons:</h3>
        <div class="addon-section">
            <?php
            $addons = [
                'extra_ads' => 50,
                'seo_audit' => 70,
                'landing_page' => 90
            ];
            foreach ($addons as $key => $price) {
                $checked = (isset($form_data['addons']) && in_array($key, $form_data['addons'])) ? 'checked' : '';
                echo "<label><input type='checkbox' name='addons[]' value='$key' data-price='$price' $checked> $key ($$price)</label><br>";
            }
            ?>
        </div>

        <h4>Total: $<span id="totalAmount"><?= $current_plan['price'] ?></span></h4>


        <button type="submit">Proceed to Payment</button>


    </form>

</div>



<script>
const basePrice = parseFloat(document.getElementById('basePrice').value);
const totalAmountEl = document.getElementById('totalAmount');
const addonCheckboxes = document.querySelectorAll("input[type='checkbox'][data-price]");
const serviceToggles = document.querySelectorAll(".service-toggle");

function updateTotal() {
    let total = basePrice;
    addonCheckboxes.forEach(cb => {
        if (cb.checked) total += parseFloat(cb.dataset.price);
    });
    totalAmountEl.textContent = total.toFixed(2);
}
addonCheckboxes.forEach(cb => cb.addEventListener('change', updateTotal));
updateTotal();

serviceToggles.forEach(cb => {
    cb.addEventListener('change', () => {
        const section = document.getElementById(cb.value);
        if (section) section.classList.toggle('hidden', !cb.checked);
    });
    const section = document.getElementById(cb.value);
    if (section && cb.checked) section.classList.remove('hidden');
});
</script>
</body>
</html>
