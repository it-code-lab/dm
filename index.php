<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home | MAD Networks</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
  <link rel="stylesheet" href="assets/css/animations.css">
</head>
<body>

  <!-- Header -->
<header class="site-header">
  <div class="container">
    <h1 class="logo">MAD Networks</h1>

    <!-- Hamburger Icon -->
    <div class="menu-toggle" id="menu-toggle">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <!-- Navigation -->
    <nav class="main-nav" id="main-nav">
      <a href="index.php">Home</a>
      <a href="services.php">Services</a>
      <a href="portfolio.php">Portfolio</a>
      <a href="contact.php">Contact</a>
    </nav>
  </div>
</header>


  <!-- Hero Section -->
  <section class="hero-section fade-in">
    <div class="container">
      <h2>Grow Your Business with Smart Digital Marketing</h2>
      <p>Affordable and effective services for startups and small businesses.</p>
      <a href="contact.php" class="btn-primary">Get Started</a>
    </div>
  </section>

  <!-- Services Summary -->
  <section class="services-section slide-up">
    <div class="container">
      <h3>Our Services</h3>
      <div class="service-boxes">
        <div class="service-card">
          <h4>Social Media Marketing</h4>
          <p>Grow your reach with engaging content and paid campaigns.</p>
        </div>
        <div class="service-card">
          <h4>SEO & Google Ads</h4>
          <p>Rank higher and convert faster with optimized strategies.</p>
        </div>
        <div class="service-card">
          <h4>Content & Blog Writing</h4>
          <p>Boost brand authority with high-quality, SEO-optimized content.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Why Choose Us -->
  <section class="why-section fade-in">
    <div class="container">
      <h3>Why Choose Us?</h3>
      <ul class="why-list">
        <li>✅ Affordable starter packages</li>
        <li>✅ Personalized service from a dedicated team</li>
        <li>✅ Transparent reporting & clear deliverables</li>
        <li>✅ Experience across multiple industries</li>
      </ul>
    </div>
  </section>

  <!-- Contact CTA -->
  <section class="cta-section slide-up">
    <div class="container">
      <h3>Ready to Take Your Brand to the Next Level?</h3>
      <a href="contact.php" class="btn-primary">Contact Us</a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="site-footer">
    <div class="container">
      <p>&copy; <?= date('Y') ?> MAD Networks. All rights reserved.</p>
    </div>
  </footer>

  <script>
  const menuToggle = document.getElementById('menu-toggle');
  const nav = document.getElementById('main-nav');

  menuToggle.addEventListener('click', () => {
    nav.classList.toggle('show');
  });
</script>

</body>
</html>
