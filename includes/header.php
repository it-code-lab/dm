<?php
  $current_page = basename($_SERVER['PHP_SELF']);
?>
<header class="site-header">
  <div class="container">
    <h1 class="logo"><a href="index.php" style="color: white; text-decoration: none;">VSN Networks</a></h1>

    <!-- Hamburger Toggle for Mobile -->
    <div class="menu-toggle" id="menu-toggle">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <!-- Navigation -->
    <nav class="main-nav" id="main-nav">
      <a href="index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">Home</a>
      <a href="pricing.php" class="<?= $current_page == 'pricing.php' ? 'active' : '' ?>">Pricing</a>


      <a href="blog.php" class="<?= $current_page == 'blog.php' ? 'active' : '' ?>">Blogs</a>
      <a href="contact.php" class="<?= $current_page == 'contact.php' ? 'active' : '' ?>">Contact</a>
    </nav>
  </div>

  <script>
    // Toggle menu on mobile
    let menuToggle = document.getElementById('menu-toggle');
    const nav = document.getElementById('main-nav');

    menuToggle.addEventListener('click', () => {
      nav.classList.toggle('show');
    });
  </script>
</header>
