<?php
// After successful login, `checkout.php` should check if `$_SESSION['form_data']` is set
// and rehydrate the form fields in purchase.php accordingly.

// logout.php
session_start();
session_unset();
session_destroy();
header('Location: login.php');
exit();


