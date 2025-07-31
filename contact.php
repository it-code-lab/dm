<?php 
session_start();
include 'includes/db.php'; 
?>
<!DOCTYPE html>
<html>
<head>
  <title>Contact Us</title>
  <?php include 'includes/head-main.html'; ?>
  <meta name='description' content='Contact us for any questions on the plans or packages'> 
   <meta property='og:title' content='Contact Us'> 
   <meta property='og:description' content='Contact us for any questions on the plans or packages'>
   <meta property='og:url' content='vsnnetworks.com/contact.php'>
   <meta name='author' content='VSN Networks'>
   <link rel='canonical' href='https://vsnnetworks.com/contact.php'>

</head>

<body>
    <?php include 'includes/header.php'; ?>
<div class="container contactus fade-in">
  <h2 class="slide-up">Contact Us</h2>
  <form action="process_contact.php" method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone"><br><br>

    <label>Service Interested In:</label><br>
    <select name="service_interest">
      <option value="Basic Plan">Basic Plan</option>
      <option value="Advanced Plan">Advanced Plan</option>
      <option value="Pro Plan">Pro Plan</option>
      <option value="Custom Plan">Custom Plan</option>
    </select><br><br>

    <label>Message:</label><br>
    <textarea name="message" rows="5" required></textarea><br><br>

    <input type="submit" value="Submit">
  </form>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
