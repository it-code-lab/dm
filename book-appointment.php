<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Book Appointment | MAD Networks</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>

  <?php include 'includes/header.php'; ?>

  <section class="page-hero">
    <div class="container">
      <h2>Book Your Free Consultation</h2>
      <p>Pick a time that works for you. We’ll meet online and help you choose the right services.</p>
    </div>
  </section>

  <section class="container" style="max-width:900px; margin: auto;">
    <!-- Calendly embed -->
    <div style="min-width:320px;height:800px;">
      <iframe src="https://calendly.com/consulati0n"
              width="100%" height="100%" frameborder="0"
              style="border: 1px solid #ddd; border-radius: 10px;"
              allowfullscreen></iframe>
    </div>
  </section>

  <div class="back-home-btn-wrapper" style="text-align: center; margin-top: 20px; margin-bottom: 100px;">
  <a href="index.php" class="btn-primary">← Back to Home</a>
  </div>

  <?php include 'includes/footer.php'; ?>

</body>
</html>
