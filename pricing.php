<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Pricing | VSN Networks</title>
  <?php include 'includes/head-main.html'; ?>
  <meta name='description' content='Check out different plans for digital marketing and their pricing'> 
   <meta property='og:title' content='Pricing | VSN Networks'> 
   <meta property='og:description' content='Check out different plans for digital marketing and their pricing'>
   <meta property='og:url' content='vsnnetworks.com/pricing.php'>
   <meta name='author' content='VSN Networks'>
   <link rel='canonical' href='https://vsnnetworks.com/pricing.php'>

</head>
<body>

  <?php include 'includes/header.php'; ?> <!-- Optional if you're modularizing header -->

<section class="page-hero">
  <div class="container">
    <h2>Choose Your Plan</h2>
    <p>Flexible options for businesses of every size. </p>
  </div>
</section>

<section class="pricing-grid container">

    <!-- Basic Plan -->
    <div class="pricing-card">
      <h3>Basic Plan</h3>
      <p class="price">$300/month</p>
      <div class="tagline">Best for: Freelancers & Solo Consultants</div>
      <ul>
        <li>10 Social Posts (FB/IG)/Month</li>
        <li>Basic On-Page SEO (Homepage)</li>
        <li>4 Meta Ad Campaigns/Month</li>
        <li>Basic Website Audit</li>
      </ul>
      <details>
        <summary style="cursor:pointer;color:#007BFF;">View more</summary>
        <ul>
          <li>2 Instagram Reels/Month</li>
          <li>Email support for basic queries</li>  
          <li>Local SEO</li>        
        </ul>
      </details>
      <a href="purchase.php?plan=basic" class="btn-secondary">Select Plan</a>
    </div>

    <!-- Advanced Plan -->
    <div class="pricing-card">
      <h3>Advanced Plan</h3>
      <p class="price">$500/month</p>
      <div class="tagline">Best for: Local Businesses & Startups</div>
      <ul>
        <li>15 Social Posts</li>
        <li>8 Meta Ad Campaigns/Month</li>
        <li>4 Instagram Reels/Month</li>
        <li>SMM Growth Strategy</li>
      </ul>
      <details>
        <summary style="cursor:pointer;color:#007BFF;">View more</summary>
        <ul>
          <li>4 Google Ad Campaigns/Month</li>
          <li>Email Marketing</li>
          <li>On-Page SEO</li>
          <li>Local SEO</li>
          <li>Technical SEO</li>
        </ul>
      </details>
      <a href="purchase.php?plan=advanced" class="btn-secondary">Select Plan</a>
    </div>

    <!-- Pro Plan -->
    <div class="pricing-card">
      <h3>Pro Plan</h3>
      <p class="price">$800/month</p>
      <div class="tagline">Best for: Aggressive Growth & Automation</div>
      <ul>
        <li>20 Social Posts (Meta/Google)</li>
        <li>20 Meta Ad Campaigns/Month</li>
        <li>Advanced SEO</li>
        <li>Website Audit</li>
      </ul>
      <details>
        <summary style="cursor:pointer;color:#007BFF;">View more</summary>
        <ul>
          <li>10 Google Ad Campaigns/Month</li>
          <li>8 Instagram Reels/Month</li>
          <li>Monthly Reporting Dashboard</li>
        </ul>
      </details>
      <a href="purchase.php?plan=pro" class="btn-secondary">Select Plan</a>
    </div>

    <!-- Custom Plan -->
    <div class="pricing-card custom">
      <h3>Custom Plan</h3>
      <p class="price">Based on Quote</p>
      <div class="tagline">Best for: Agencies, Franchises, Enterprises</div>
      <ul>
        <li>Everything in Pro + Custom Integrations</li>
        <li>Dedicated Account Manager</li>
        <li>Tailored Funnel + Email Sequences</li>
        <li>CRM/ERP/Tracking Setup</li>
      </ul>
      <details>
        <summary style="cursor:pointer;color:#007BFF;">View more</summary>
        <ul>
          <li>Pick & choose services by line-item pricing</li>
          <li>Custom dashboard & analytics views</li>
          <li>Sales team enablement tools</li>
          <li>End-to-end digital growth strategy</li>
          <li>Ongoing A/B testing and CRO advisory</li>
        </ul>
      </details>
      <a href="book-appointment.php" class="btn-secondary">Book Consultation</a>
    </div>

</section>

    <!-- Pricing Table -->

 <div class="pricing-table-container">
 <table class="pricing-table">
  <thead>
    <tr>
      <th>Service</th>
      <th>Basic</th>
      <th>Advanced</th>
      <th>Pro</th>
      <th>Add-On Price (USD)</th>
    </tr>
  </thead>
  <tbody>
    <!-- SEO Services -->
    <tr>
      <td data-label="Service">SEO: Basic On-Page Optimization</td>
      <td data-label="Basic">✔️</td><td data-label="Advanced">✔️</td><td data-label="Pro">✔️</td><td data-label="Add-On Price (USD)">-</td>
    </tr>

    <tr>
      <td data-label="Service">SEO: Local SEO (Google My Business)</td>
      <td data-label="Basic">✔️</td><td data-label="Advanced">✔️</td><td data-label="Pro">✔️</td><td data-label="Add-On Price (USD)">-</td>
    </tr>

    <tr>
      <td data-label="Service">SEO: Technical SEO </td>
      <td data-label="Basic">-</td><td data-label="Advanced">✔️</td><td data-label="Pro">✔️</td><td data-label="Add-On Price (USD)">-</td>
    </tr>


    <!-- Ads -->
    <tr>
      <td data-label="Service">Google Ads (Campaign Setup)</td>
      <td data-label="Basic">-</td><td data-label="Advanced">4</td><td data-label="Pro">10</td><td data-label="Add-On Price (USD)">-</td>
    </tr>
    <tr>
      <td data-label="Service">Meta Ads (Instagram/Facebook/LinkedIn)</td>
      <td data-label="Basic">4</td><td data-label="Advanced">8</td><td data-label="Pro">20</td><td data-label="Add-On Price (USD)">-</td>
    </tr>


    <!-- SMM -->
    <tr>
      <td data-label="Service">SMM: Social Posts</td>
      <td data-label="Basic">10</td><td data-label="Advanced">15</td><td data-label="Pro">20</td><td data-label="Add-On Price (USD)">-</td>
    </tr>

    <tr>
      <td data-label="Service">SMM: Instagram Reels</td>
      <td data-label="Basic">2</td><td data-label="Advanced">4</td><td data-label="Pro">8</td><td data-label="Add-On Price (USD)">-</td>
    </tr>

    <tr>
      <td data-label="Service">SMM: Engagement & Growth Strategy</td>
      <td data-label="Basic">-</td><td data-label="Advanced">✔️</td><td data-label="Pro">✔️</td><td data-label="Add-On Price (USD)">-</td>
    </tr>

    <tr>
      <td data-label="Service">Content Marketing</td>
      <td data-label="Basic">-</td><td data-label="Advanced">-</td><td data-label="Pro">✔️</td><td data-label="Add-On Price (USD)">-</td>
    </tr>

    <!-- Email -->
    <tr>
      <td data-label="Service">Email Marketing (Setup + 1 Drip Campaign)</td>
      <td data-label="Basic">-</td><td data-label="Advanced">✔️</td><td data-label="Pro">✔️</td><td data-label="Add-On Price (USD)">-</td>
    </tr>


    <!-- Web Design -->
    <tr>
      <td data-label="Service">Website Development (Simple landing page)</td>
      <td data-label="Basic">-</td><td data-label="Advanced">-</td><td data-label="Pro">-</td><td data-label="Add-On Price (USD)">$500+</td>
    </tr>

    <tr>
      <td data-label="Service">Website Development (Full Website Redesign)</td>
      <td data-label="Basic">-</td><td data-label="Advanced">-</td><td data-label="Pro">-</td><td data-label="Add-On Price (USD)">$1000+</td>
    </tr>

    <tr>
      <td data-label="Service">Website Audit</td>
      <td data-label="Basic">Basic</td><td data-label="Advanced">Full</td><td data-label="Pro">Full</td><td data-label="Add-On Price (USD)">-</td>
    </tr>

    <tr>
      <td data-label="Service">Custom Add-Ons</td>
      <td data-label="Basic">-</td><td data-label="Advanced">-</td><td data-label="Pro">-</td><td data-label="Add-On Price (USD)">Let's Discuss</td>
    </tr>

  </tbody>
</table>
</div>

    <section class="cta-section">
    <div class="container">
      <h3>Need help choosing the right plan?</h3>
      <a href="book-appointment.php" class="btn-primary">Book Free Consultation</a>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?> <!-- Optional modular footer -->

</body>
</html>
