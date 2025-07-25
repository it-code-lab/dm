<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Blog | MAD Networks</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
  <link rel="stylesheet" href="assets/css/animations.css">
</head>
<body>

  <?php include 'includes/header.php'; ?>

  <section class="page-hero">
    <div class="container">
      <h2>Latest Articles & Insights</h2>
      <p>Tips, trends, and case studies to help your business grow.</p>
    </div>
  </section>

  <section class="blog-list-section container">

    <div class="blog-post-card">
      <img src="assets/images/blog-1.jpg" alt="Blog 1">
      <div class="blog-content">
        <h3><a href="blog-post.php?id=1">5 Reasons Your Business Needs a Digital Presence</a></h3>
        <p>Still thinking about whether to invest in digital marketing? These 5 points will help you decide...</p>
        <a href="blog-post.php?id=1" class="read-more">Read More →</a>
      </div>
    </div>

    <div class="blog-post-card">
      <img src="assets/images/blog-2.jpg" alt="Blog 2">
      <div class="blog-content">
        <h3><a href="blog-post.php?id=2">Instagram Ads vs. Google Ads: What’s Better for You?</a></h3>
        <p>Understand the differences and when to use each platform for the best ROI.</p>
        <a href="blog-post.php?id=2" class="read-more">Read More →</a>
      </div>
    </div>

    <!-- Add more blog entries as needed -->

  </section>

  <section class="cta-section">
    <div class="container">
      <h3>Have a topic you'd like us to write about?</h3>
      <a href="contact.php" class="btn-primary">Suggest a Topic</a>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>

</body>
</html>
