<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $message  = $_POST['message'];
    $service  = $_POST['service_interest'];

    $sql = "INSERT INTO inquiries (name, email, phone, message, service_interest) 
            VALUES (:name, :email, :phone, :message, :service)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name'    => $name,
        ':email'   => $email,
        ':phone'   => $phone,
        ':message' => $message,
        ':service' => $service,
    ]);

    header("Location: thankyou.php");
    exit;
} else {
    echo "Invalid request.";
}
?>
