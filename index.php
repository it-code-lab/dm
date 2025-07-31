<?php
// login.php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home | VSN Networks</title>  
  <?php include 'includes/head-main.html'; ?>
  <meta name='description' content='Grow Your Business with Smart Digital Marketing'> 
   <meta property='og:title' content='Home | VSN Networks'> 
   <meta property='og:description' content='Grow Your Business with Smart Digital Marketing'>
   <meta property='og:url' content='vsnnetworks.com/index.php'>
   <meta name='author' content='VSN Networks'>
   <link rel='canonical' href='https://vsnnetworks.com/index.php'>

</head>
<body>


<!-- <header class="site-header">
  <div class="container">
    <h1 class="logo">VSN Networks</h1>


    <div class="menu-toggle" id="menu-toggle">
      <span></span>
      <span></span>
      <span></span>
    </div>


    <nav class="main-nav" id="main-nav">
      <a href="index.php">Home</a>
      <a href="services.php">Services</a>
      <a href="portfolio.php">Portfolio</a>
      <a href="contact.php">Contact</a>
    </nav>
  </div>
</header> -->
<?php include 'includes/header.php'; ?>

  <!-- Hero Section -->
  <!-- <section class="hero-section fade-in">
    <div class="container">
      <h2>Grow Your Business with Smart Digital Marketing</h2>
      <p>Affordable and effective services for startups and small businesses.</p>
      <a href="contact.php" class="btn-primary">Get Started</a>
    </div>
  </section> -->

  <section class="hero-section hero-bg">
 
  <div class="hero-overlay">
    <div class="container">
      <h2>Grow Your Business with Smart Digital Marketing</h2>
      <p>Affordable and effective services for startups and growing businesses.</p>
      <a href="pricing.php" class="btn-primary">Get Started</a>
    </div>
  </div>
</section>


  <!-- Services Summary -->
<section class="services-overview container">
  <h2 class="section-title">What We Offer</h2>
  <p class="section-subtitle">Solutions that help you grow online — from strategy to execution.</p>

  <div class="service-grid">

    <div class="service-card fade-in">
      <img src="assets/images/service-social.jpeg" alt="Social Media" />
      <h3>Social Media Marketing</h3>
      <p>Grow your brand with engaging posts, reels, and paid ad campaigns on platforms like Instagram and Facebook.</p>
    </div>

    <div class="service-card fade-in">
      <img src="assets/images/service-seo.jpeg" alt="SEO & Google Ads" />
      <h3>SEO & Google Ads</h3>
      <p>Rank higher on Google and reach potential clients through search and display ads with trackable ROI.</p>
    </div>

    <div class="service-card fade-in">
      <img src="assets/images/service-content.jpeg" alt="Content Creation" />
      <h3>Content & Blog Writing</h3>
      <p>Drive organic traffic and establish expertise with well-written SEO-friendly blog articles and captions.</p>
    </div>

    <div class="service-card fade-in">
      <img src="assets/images/service-website.jpeg" alt="Website Design" />
      <h3>Website Creation</h3>
      <p>We build fast, responsive websites that reflect your brand and drive conversions — built with HTML, WordPress or PHP.</p>
    </div>

    <div class="service-card fade-in">
      <img src="assets/images/service-hosting.jpeg" alt="Hosting" />
      <h3>Website Hosting & Maintenance</h3>
      <p>Reliable web hosting on platforms like Hostinger or Cloudways, plus ongoing site updates and backups.</p>
    </div>

    <div class="service-card fade-in">
      <img src="assets/images/service-branding.jpeg" alt="Brand Identity" />
      <h3>Branding & Design</h3>
      <p>From logos to Instagram templates — we help your business look sharp, professional, and consistent across platforms.</p>
    </div>

  </div>
</section>

  <!-- Why Choose Us -->
  <!-- <section class="why-section fade-in">
    <div class="container">
      <h2>Why Choose Us?</h2>
      <ul class="why-list">
        <li>✅ Affordable starter packages</li>
        <li>✅ Personalized service from a dedicated team</li>
        <li>✅ Transparent reporting & clear deliverables</li>
        <li>✅ Experience across multiple industries</li>
      </ul>
    </div>
  </section> -->

  <section class="why-section alt-bg">
  <div class="container">
    <h3 class="section-title">Why Choose Us?</h3>

    <div class="why-grid">
      <div class="why-card fade-in">
        <img src="assets/icons/price-tag.svg" alt="Affordable">
        <h4>Affordable Packages</h4>
        <p>Tailored plans starting at just ₹5,000/month — perfect for startups and small teams.</p>
      </div>
      <div class="why-card fade-in">
        <img src="assets/icons/support.svg" alt="Dedicated Team">
        <h4>Dedicated Team</h4>
        <p>Work with real people who understand your brand and care about your results.</p>
      </div>
      <div class="why-card fade-in">
        <img src="assets/icons/analytics.svg" alt="Reporting">
        <h4>Transparent Reporting</h4>
        <p>Track what matters — impressions, leads, growth, and ROI, all in one monthly dashboard.</p>
      </div>
      <div class="why-card fade-in">
        <img src="assets/icons/experience.svg" alt="Experience">
        <h4>Cross-Industry Experience</h4>
        <p>We've helped clients in fitness, education, retail, real estate, and more.</p>
      </div>
    </div>
  </div>
</section>

  <!-- Contact CTA -->
  <section class="cta-section slide-up">
    <div class="container">
      <h3>Ready to Take Your Brand to the Next Level?</h3>
      <a href="pricing.php" class="btn-primary">Select a Plan</a>
      <a href="book-appointment.php" class="btn-primary">Book Free Consultation </a>
      <a href="contact.php" class="btn-primary">Contact Us</a>
    </div>
  </section>


  <!-- <footer class="site-footer">
    <div class="container">
      <p>&copy; <?= date('Y') ?> VSN Networks. All rights reserved.</p>
    </div>
  </footer> -->

  <?php include 'includes/footer.php'; ?>

  <!-- <script>
  let menuToggle = document.getElementById('menu-toggle');
  const nav = document.getElementById('main-nav');

  menuToggle.addEventListener('click', () => {
    nav.classList.toggle('show');
  });
</script> -->

<script>
  // Scroll animation for fade-in
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.fade-in').forEach(el => {
    observer.observe(el);
  });
</script>

</body>
</html>
