<?php
  //session_start(); // Ensure session is started
  $current_page = basename($_SERVER['PHP_SELF']);
  $isLoggedIn = isset($_SESSION['user_id']);
  $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
?>
<header class="site-header">
  <div class="container">
    <h1 class="logo">
      <a href="../index.php" style="color: white; text-decoration: none;">
        <img class="logoimage" src="../assets/icons/logo.png" alt="VSN Networks">
      </a>
    </h1>

    <!-- Hamburger Toggle for Mobile -->
    <div class="menu-toggle" id="menu-toggle">
      <span></span><span></span><span></span>
    </div>

    <!-- Navigation -->
    <nav class="main-nav" id="main-nav">
      <a href="../index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">Home</a>
      <a href="../pricing.php" class="<?= $current_page == 'pricing.php' ? 'active' : '' ?>">Pricing</a>
      <a href="../blog.php" class="<?= $current_page == 'blog.php' ? 'active' : '' ?>">Blogs</a>
      <a href="../contact.php" class="<?= $current_page == 'contact.php' ? 'active' : '' ?>">Contact</a>

      <?php if ($isLoggedIn): ?>
        <a href="../dashboard.php" class="<?= $current_page == 'dashboard.php' ? 'active' : '' ?>">My Dashboard</a>

        <?php if ($isAdmin): ?>
          <div class="dropdown">
            <a href="#" class="dropdown-toggle">Admin ▾</a>
            <div class="dropdown-menu">
              <a href="../admin/index.php">Dashboard</a>
              <!-- <a href="../admin/create-order.php">Create Order</a> -->
              <!-- <a href="../admin/orders.php">All Orders</a> -->
            </div>
          </div>
        <?php endif; ?>

        <a href="../logout.php">Logout</a>
      <?php else: ?>
        <a href="../login.php" class="<?= $current_page == 'login.php' ? 'active' : '' ?>">Login</a>
      <?php endif; ?>
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
