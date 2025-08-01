<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'includes/head-main.html'; ?>
  <title>Book Appointment | VSN Networks</title>

   <meta name='description' content='Book an appointment for consultation'> 
   <meta property='og:title' content='Book Appointment | VSN Networks'> 
   <meta property='og:description' content='Book an appointment for consultation'>
   <meta property='og:url' content='vsnnetworks.com/book-appointment.php'>
   <meta name='author' content='VSN Networks'>
   <link rel='canonical' href='https://vsnnetworks.com/book-appointment.php'>

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
