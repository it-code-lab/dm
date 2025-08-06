<?php
require_once 'includes/db.php';
require_once 'mailer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $service = $_POST['service_interest'];

    $sql = "INSERT INTO inquiries (name, email, phone, message, service_interest) 
            VALUES (?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $phone, $message, $service);

    if ($stmt->execute()) {
        // Send email to admin
        sendInquiryEmailToAdmin($name, $email, $phone, $message, $service);
        header("Location: thankyou.php");
        exit;
    } else {
        echo "Failed to process.";
    }
    exit;
} else {
    echo "Failed to process.";
}

