<?php
// purchase.php
session_start();
require_once 'includes/db.php';
require_once 'includes/auth.php';

$plan = isset($_GET['plan']) ? strtolower(trim($_GET['plan'])) : '';
$_SESSION['plan'] = $plan;
$valid_plans = ['basic', 'advanced', 'pro', 'custom'];

if (!in_array($plan, $valid_plans)) {
    die("Invalid plan selected.");
}

$plan_details = [
    'basic' => ['price' => 300, 'label' => 'Basic Plan', 'services' => ['onpage_seo', 'meta_ads', 'gmb', 'social_media']],
    'advanced' => ['price' => 500, 'label' => 'Advanced Plan', 'services' => ['onpage_seo', 'meta_ads', 'gmb', 'technical_seo','social_media']],
    'pro' => ['price' => 800, 'label' => 'Pro Plan', 'services' => ['onpage_seo', 'meta_ads', 'gmb', 'technical_seo', 'reels', 'email_marketing', 'content_marketing', 'social_media']],
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
        .help-icon { cursor: pointer; color: #007bff; margin-left: 5px; }
        .help-text { font-size: 0.9em; color: #666; margin-top: 5px; padding: 20px; border-left: 2px solid #007bff; background-color: aliceblue; }
    </style>
    <style>
    .modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; }
    .modal-content { background: white; margin: 10% auto; padding: 20px; width: 400px; border-radius: 6px; }
    .close { float: right; font-size: 20px; cursor: pointer; }
    </style>    
</head>
<body>
    <?php include 'includes/header.php'; ?>
<div class="medium-container wide">
    <h2><?= htmlspecialchars($current_plan['label']) ?> - Service Request</h2>
    <form id="purchaseForm" action="checkout.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="plan" value="<?= htmlspecialchars($plan) ?>">
        <input type="hidden" id="basePrice" value="<?= $current_plan['price'] ?>">

        <label>Your Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($form_data['name'] ?? '') ?>" required>

        <label>Your Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($form_data['email'] ?? '') ?>" required>
        
        <label>Business Description & Website URL</label>
        <textarea maxlength="500" placeholder="Max 500 characters" name="business_info" rows="4" required><?= htmlspecialchars($form_data['business_info'] ?? '') ?></textarea>
        
        <label>Primary Business Goals (e.g., increase sales, generate leads)</label>
        <textarea maxlength="500" placeholder="Max 500 characters" name="primary_goals" rows="2"><?= htmlspecialchars($form_data['primary_goals'] ?? '') ?></textarea>

        <label>Top Competitors (Websites)</label>
        <textarea maxlength="200" placeholder="Max 200 characters" name="competitors" rows="2"><?= htmlspecialchars($form_data['competitors'] ?? '') ?></textarea>

        <label>Upload Brand Assets (logos, style guides, etc.)</label>
        <input type="file" name="assets[]" multiple>

        <h3>Select Services to Include:</h3>
        <div id="serviceList">
            <?php
            $all_services = [
                'onpage_seo' => 'On-Page SEO',
                'meta_ads' => 'PPC (Pay-Per-Click) Advertising (Ads)',
                'gmb' => 'Google My Business (Local SEO)',
                'technical_seo' => 'Technical SEO',
                'content_marketing' => 'Content Marketing',
                'social_media' => 'Social Media Marketing',
                'email_marketing' => 'Email Marketing'
            ];
            $current_plan_key = $plan; // use the plan string as the key
            $current_plan = $plan_details[$current_plan_key];
            $allowed_services = $current_plan['services'];

            foreach ($all_services as $key => $label) {
                if (!in_array($key, $allowed_services) && $current_plan_key != 'custom') { continue; } // skip if not in plan
                if (in_array($key, $form_data['services'] ?? [])) {
                    $checked = 'checked';
                } elseif (in_array($key, $allowed_services)) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                echo "<label><input type='checkbox' name='services[]' value='$key' class='service-toggle' $checked> $label</label><br>";
            }


            ?>
        </div>

        <div id="serviceDetails">
            <div id="onpage_seo" class="service-section hidden">
                <h4>On-Page SEO <span class="help-icon" onclick="toggleHelp('onpage_seo_help')">&#9432;</span></h4>
                <p id="onpage_seo_help" class="help-text" style="display: none;">
                    Optimizing individual web pages, including content, title tags, meta descriptions, and headers, to rank higher for specific keywords.
                </p>
                <label>Website URL</label>
                <input type="url" name="onpage_url" value="<?= htmlspecialchars($form_data['onpage_url'] ?? '') ?>">
                <label>Target Keywords (comma-separated)</label>
                <input type="text" name="onpage_keywords" value="<?= htmlspecialchars($form_data['onpage_keywords'] ?? '') ?>">
                <label>Target Location</label>
                <input type="text" name="onpage_location" value="<?= htmlspecialchars($form_data['onpage_location'] ?? '') ?>">
                 <label>Details of previous SEO efforts (if any)</label>
                <textarea name="onpage_previous_efforts" rows="2"><?= htmlspecialchars($form_data['onpage_previous_efforts'] ?? '') ?></textarea>
            </div>
            
            <div id="meta_ads" class="service-section hidden">
                <h4>PPC Advertising <span class="help-icon" onclick="toggleHelp('ppc_help')">&#9432;</span></h4>
                <p id="ppc_help" class="help-text" style="display: none;">
                    Managing paid advertising campaigns on platforms like Google, Facebook, and Instagram to drive targeted traffic to your website.
                </p>
                <label>Monthly Ad Spend Budget $(e.g., 500)</label>
                <input type="number" name="ppc_budget" value="<?= htmlspecialchars($form_data['ppc_budget'] ?? '') ?>">
                <label>Products/Services to Promote</label>
                <textarea name="ppc_offerings" rows="2"><?= htmlspecialchars($form_data['ppc_offerings'] ?? '') ?></textarea>
                <label>Target Audience (demographics, interests)</label>
                <input type="text" name="ppc_audience" value="<?= htmlspecialchars($form_data['ppc_audience'] ?? '') ?>">
                <label>Desired Conversion Action (e.g., "purchase", "form fill")</label>
                <input type="text" name="ppc_conversion" value="<?= htmlspecialchars($form_data['ppc_conversion'] ?? '') ?>">
            </div>
            
            <div id="gmb" class="service-section hidden">
                <h4>Google My Business <span class="help-icon" onclick="toggleHelp('gmb_help')">&#9432;</span></h4>
                <p id="gmb_help" class="help-text" style="display: none;">
                    Optimizing your business's online presence on Google Maps and Search to attract local customers and improve local search rankings.
                </p>
                <label>Business Name</label>
                <input type="text" name="gmb_name" value="<?= htmlspecialchars($form_data['gmb_name'] ?? '') ?>">
                <label>Business Address</label>
                <input type="text" name="gmb_address" value="<?= htmlspecialchars($form_data['gmb_address'] ?? '') ?>">
                <label>Phone Number</label>
                <input type="text" name="gmb_phone" value="<?= htmlspecialchars($form_data['gmb_phone'] ?? '') ?>">
            </div>
            
            <div id="technical_seo" class="service-section hidden">
                <h4>Technical SEO <span class="help-icon" onclick="toggleHelp('technical_seo_help')">&#9432;</span></h4>
                <p id="technical_seo_help" class="help-text" style="display: none;">
                    Ensuring your website meets the technical requirements of search engines for proper crawling, indexing, and mobile-friendliness.
                </p>
                <label>Website Platform (CMS)</label>
                <input type="text" name="tech_platform" value="<?= htmlspecialchars($form_data['tech_platform'] ?? '') ?>">
                <label>Access Details (if possible) / Link to access</label>
                <textarea name="tech_access"><?= htmlspecialchars($form_data['tech_access'] ?? '') ?></textarea>
            </div>
            
            <div id="content_marketing" class="service-section hidden">
                <h4>Content Marketing <span class="help-icon" onclick="toggleHelp('content_marketing_help')">&#9432;</span></h4>
                <p id="content_marketing_help" class="help-text" style="display: none;">
                    Creating and distributing valuable, relevant, and consistent content (like blogs, videos, and infographics) to attract and retain a clearly-defined audience.
                </p>
                <label>Target Content Formats (e.g., Blog posts, video, infographics)</label>
                <input type="text" name="content_formats" value="<?= htmlspecialchars($form_data['content_formats'] ?? '') ?>">
                <label>Brand Voice & Tone (e.g., professional, witty, casual)</label>
                <input type="text" name="content_voice" value="<?= htmlspecialchars($form_data['content_voice'] ?? '') ?>">
                <label>Primary Content Goals</label>
                <textarea name="content_goals" rows="2"><?= htmlspecialchars($form_data['content_goals'] ?? '') ?></textarea>
            </div>

            <div id="social_media" class="service-section hidden">
                <h4>Social Media Marketing <span class="help-icon" onclick="toggleHelp('social_media_help')">&#9432;</span></h4>
                <p id="social_media_help" class="help-text" style="display: none;">
                    Building brand awareness, engaging with customers, and driving traffic through platforms like Facebook, Instagram, LinkedIn, and more.
                </p>
                <label>Your Existing Social Media Profiles</label>
                <textarea name="social_profiles" rows="2"><?= htmlspecialchars($form_data['social_profiles'] ?? '') ?></textarea>
                <label>Primary Social Media Goals (e.g., brand awareness, community engagement)</label>
                <input type="text" name="social_goals" value="<?= htmlspecialchars($form_data['social_goals'] ?? '') ?>">
                <label>Key Messaging to communicate</label>
                <textarea name="social_messaging" rows="2"><?= htmlspecialchars($form_data['social_messaging'] ?? '') ?></textarea>
            </div>

            <div id="email_marketing" class="service-section hidden">
                <h4>Email Marketing <span class="help-icon" onclick="toggleHelp('email_marketing_help')">&#9432;</span></h4>
                <p id="email_marketing_help" class="help-text" style="display: none;">
                    Creating and managing email campaigns to nurture leads and build strong relationships with your customers.
                </p>
                <label>Email Platform (e.g., Mailchimp, Klaviyo)</label>
                <input type="text" name="email_platform" value="<?= htmlspecialchars($form_data['email_platform'] ?? '') ?>">
                <label>Objective</label>
                <input type="text" name="email_goal" value="<?= htmlspecialchars($form_data['email_goal'] ?? '') ?>">
                <label>Do you have an existing email list? (size and segmentation details)</label>
                <textarea name="email_list_info" rows="2"><?= htmlspecialchars($form_data['email_list_info'] ?? '') ?></textarea>
            </div>
            

            


        </div>

        <h3>Optional Add-ons:</h3>
        <div class="addon-section">
            <?php
            $addons = [
                'website_development' => ['label' => 'Website Development (Simple landing page)', 'price' => 500],
                'website_redesign' => ['label' => 'Website Development (Website Redesign)', 'price' => 1000]
            ];
            foreach ($addons as $key => $data) {
                $checked = (isset($form_data['addons']) && in_array($key, $form_data['addons'])) ? 'checked' : '';
                echo "<label><input type='checkbox' name='addons[]' class='service-toggle' value='{$key}' data-price='{$data['price']}' $checked> {$data['label']} (USD {$data['price']})</label><br>";
            }
            ?>
        </div>

        <div id="website_development" class="service-section hidden">
            <h4>Website Design & Development <span class="help-icon" onclick="toggleHelp('website_design_help')">&#9432;</span></h4>
            <p id="website_design_help" class="help-text" style="display: none;">
                Designing and building a professional, user-friendly, and mobile-optimized website that is the foundation of your online presence.
            </p>
            <label>Primary Purpose of the Website (e.g., eCommerce, lead generation, portfolio)</label>
            <input type="text" name="website_purpose" value="<?= htmlspecialchars($form_data['website_purpose'] ?? '') ?>">
            <label>Required Features (e.g., blog, contact form, booking system)</label>
            <textarea name="website_features" rows="2"><?= htmlspecialchars($form_data['website_features'] ?? '') ?></textarea>
            <label>Website examples you like</label>
            <textarea name="website_examples" rows="2"><?= htmlspecialchars($form_data['website_examples'] ?? '') ?></textarea>
        </div>

        <!-- Full Website Redesign -->
        <div id="website_redesign" class="service-section hidden">
                <h4>Full Website Redesign <span class="help-icon" onclick="toggleHelp('website_redesign_help')">&#9432;</span></h4>
                <p id="website_redesign_help" class="help-text" style="display: none;">
                    A redesign of your existing website, focusing on improved user experience, modern design, and optimized functionality.
                </p>
                <label>Existing Website URL</label>
                <input type="url" name="redesign_url" value="<?= htmlspecialchars($form_data['redesign_url'] ?? '') ?>">
                <label>Primary Goals for the New Website</label>
                <textarea name="redesign_goals" rows="2"><?= htmlspecialchars($form_data['redesign_goals'] ?? '') ?></textarea>
                <label>Target Audience Description</label>
                <textarea name="redesign_audience" rows="2"><?= htmlspecialchars($form_data['redesign_audience'] ?? '') ?></textarea>
                <label>Current CMS / Platform</label>
                <input type="text" name="redesign_cms" value="<?= htmlspecialchars($form_data['redesign_cms'] ?? '') ?>">
                <label>List of specific functionality needed (e.g., e-commerce, blog, booking system)</label>
                <textarea name="redesign_functionality" rows="3"><?= htmlspecialchars($form_data['redesign_functionality'] ?? '') ?></textarea>
                <label>URLs of websites you like for design inspiration</label>
                <textarea name="redesign_examples" rows="2"><?= htmlspecialchars($form_data['redesign_examples'] ?? '') ?></textarea>
                <label>Content Status</label>
                <select name="redesign_content_status">
                    <option value="">Select one...</option>
                    <option value="ready" <?= (isset($form_data['redesign_content_status']) && $form_data['redesign_content_status'] == 'ready') ? 'selected' : '' ?>>Content is ready</option>
                    <option value="in_progress" <?= (isset($form_data['redesign_content_status']) && $form_data['redesign_content_status'] == 'in_progress') ? 'selected' : '' ?>>Content is in progress</option>
                    <option value="need_help" <?= (isset($form_data['redesign_content_status']) && $form_data['redesign_content_status'] == 'need_help') ? 'selected' : '' ?>>Need help creating content</option>
                </select>
                <label>Any additional notes or design preferences</label>
                <textarea name="redesign_notes" rows="3"><?= htmlspecialchars($form_data['redesign_notes'] ?? '') ?></textarea>
        </div>

        <h4>Total: $<span id="totalAmount"><?= $current_plan['price'] ?></span></h4>

        <label for="planDuration">Select Duration:</label>
        <select id="planDuration" name="duration">
            <option value="1">1 Month (No Discount)</option>
            <option value="3">3 Months (5% Discount)</option>
            <option value="6">6 Months (10% Discount)</option>
            <option value="12">12 Months (20% Discount)</option>
        </select>

        <button type="submit" id="proceedToPaymentBtn">Proceed to Payment</button>


    </form>

</div>



<script>
const basePrice = parseFloat(document.getElementById('basePrice').value);
const totalAmountEl = document.getElementById('totalAmount');
const addonCheckboxes = document.querySelectorAll("input[type='checkbox'][data-price]");
const durationSelect = document.getElementById("planDuration");
const serviceToggles = document.querySelectorAll(".service-toggle");

function getDiscountFactor(months) {
    if (months === 3) return 0.95;     // 5% off
    if (months === 6) return 0.90;     // 10% off
    if (months === 12) return 0.80;    // 20% off
    return 1.0;                        // no discount
}

function updateTotal() {
    let duration = parseInt(durationSelect.value);
    let planTotal = basePrice * duration * getDiscountFactor(duration);
    let addonTotal = 0;
    addonCheckboxes.forEach(cb => {
        if (cb.checked) addonTotal  += parseFloat(cb.dataset.price);
    });
    const total = planTotal + addonTotal;
    totalAmountEl.textContent = total.toFixed(2);
}


addonCheckboxes.forEach(cb => cb.addEventListener('change', updateTotal));
durationSelect.addEventListener('change', updateTotal);
updateTotal();

serviceToggles.forEach(cb => {
    cb.addEventListener('change', () => {
        const section = document.getElementById(cb.value);
        if (section) section.classList.toggle('hidden', !cb.checked);
    });
    const section = document.getElementById(cb.value);
    if (section && cb.checked) section.classList.remove('hidden');
});

// New function to toggle help text visibility
function toggleHelp(id) {
    const helpText = document.getElementById(id);
    if (helpText.style.display === "none") {
        helpText.style.display = "block";
    } else {
        helpText.style.display = "none";
    }
}
</script>
<script>
    // Get the form and button elements
    const purchaseForm = document.getElementById('purchaseForm');
    const proceedBtn = document.getElementById('proceedToPaymentBtn');

    // Add a submit event listener to the form
    purchaseForm.addEventListener('submit', function(event) {
        // Disable the button and change its text
        proceedBtn.disabled = true;
        proceedBtn.textContent = 'Processing...';
    });

    // To handle the back button issue, re-enable the button when the page loads.
    // This is especially useful for browsers that cache the page state.
    window.addEventListener('pageshow', function(event) {
        // Check if the page was loaded from the cache
        if (event.persisted) {
            proceedBtn.disabled = false;
            proceedBtn.textContent = 'Proceed to Payment';
        }
    });
</script>
</body>
</html>