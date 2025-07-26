<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Contact Us</title>
  <?php include 'includes/head-main.html'; ?>
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
      <option value="Starter Plan">Starter Plan</option>
      <option value="Growth Plan">Growth Plan</option>
      <option value="Pro Plan">Pro Plan</option>
    </select><br><br>

    <label>Message:</label><br>
    <textarea name="message" rows="5" required></textarea><br><br>

    <input type="submit" value="Submit">
  </form>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
