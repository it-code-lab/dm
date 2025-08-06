<?php
// mailer.php

function sendVerificationEmail($email, $first_name, $token) {
    $verify_link = "https://vsnnetworks.com/verify_email.php?token=" . urlencode($token);
    $subject = "Verify Your VSN-Networks Account";

    $htmlMessage = "
        <html>
        <head>
            <title>Verify Your VSN-Networks Account</title>
        </head>
        <body style='font-family: Arial, sans-serif;'>
            <h2>Hi $first_name,</h2>
            <p>Thank you for signing up on <strong>VSN-Networks</strong>! Please verify your email to activate your account.</p>
            <p>
                <a href=\"$verify_link\" style='display: inline-block; background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Verify My Email</a>
            </p>
            <p>If the button doesn’t work, copy and paste this link into your browser:</p>
            <p><a href=\"$verify_link\">$verify_link</a></p>
            <br>
            <p style='color: #777;'>— VSN-Networks Team</p>
        </body>
        </html>
    ";

    $headers = "From: VSN-Networks <no-reply@VSNNetworks.com>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    return mail($email, $subject, $htmlMessage, $headers);
}

function sendPasswordResetEmail($email, $token, $first_name = "User") {
    $reset_link = "https://vsnnetworks.com/reset-password.php?token=" . urlencode($token);
    $subject = "Reset Your VSN-Networks Password";

    $htmlMessage = "
        <html>
        <head>
            <title>Password Reset</title>
        </head>
        <body style='font-family: Arial, sans-serif;'>
            <h2>Password Reset Requested</h2>
            <p>Hi $first_name,\n\nWe received a request to reset your password for your <strong>VSN-Networks</strong> account.</p>
            <p>
                <a href=\"$reset_link\" style='display: inline-block; background-color: #FF5722; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Reset Password</a>
            </p>
            <p>If the button above doesn't work, paste this link into your browser:</p>
            <p><a href=\"$reset_link\">$reset_link</a></p>
            <br>
            <p style='color: #777;'>If you did not request this change, please ignore this email.<br>— VSN-Networks Team</p>
        </body>
        </html>
    ";

    $headers = "From: VSN-Networks <no-reply@VSNNetworks.com>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    return mail($email, $subject, $htmlMessage, $headers);
}

function sendInquiryEmailToAdmin($name, $email, $phone, $message, $service) {
    $adminEmail = "mail2saurabhm@gmail.com";  // <-- Change this to your admin email
    $subject = "New Contact Form Inquiry from $name";

    $htmlMessage = "
        <html>
        <head>
            <title>New Inquiry Received</title>
        </head>
        <body style='font-family: Arial, sans-serif; background-color: #f8f8f8; padding: 20px;'>
            <div style='max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
                <h2 style='color: #333;'>📩 New Inquiry Submitted</h2>
                <p><strong>Name:</strong> {$name}</p>
                <p><strong>Email:</strong> {$email}</p>
                <p><strong>Phone:</strong> {$phone}</p>
                <p><strong>Interested Service:</strong> {$service}</p>
                <p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>
                <hr style='margin: 20px 0;'>
                <p style='color: #888;'>This message was sent from the VSN-Networks contact form.</p>
            </div>
        </body>
        </html>
    ";

    $headers = "From: VSN-Networks <no-reply@vsnnetworks.com>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    return mail($adminEmail, $subject, $htmlMessage, $headers);
}

function sendPaymentNotificationToAdmin($order_id) {
    $adminEmail = "mail2saurabhm@gmail.com"; // Change as needed
    $subject = "✅ New Order Paid - Order ID #$order_id";

    $orderLink = "https://vsnnetworks.com/admin/order-detail.php?id=$order_id";

    $htmlMessage = "
        <html>
        <head>
            <title>New Paid Order Notification</title>
        </head>
        <body style='font-family: Arial, sans-serif; background-color: #f8f8f8; padding: 20px;'>
            <div style='max-width: 600px; margin: auto; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
                <h2 style='color: #2e7d32;'>🎉 New Order Paid</h2>
                <p><strong>Order ID:</strong> #$order_id</p>
                <p><strong>Status:</strong> Paid</p>
                <p>You can view full order details using the button below:</p>
                <p>
                    <a href='$orderLink' style='display:inline-block;background-color:#4CAF50;color:#fff;padding:12px 20px;text-decoration:none;border-radius:5px;'>View Order Details</a>
                </p>
                <p style='margin-top:20px;'>Or use this direct link:<br><a href='$orderLink'>$orderLink</a></p>
                <hr style='margin: 30px 0;'>
                <p style='color: #777;'>— VSN-Networks System Notification</p>
            </div>
        </body>
        </html>
    ";

    $headers = "From: VSN-Networks <no-reply@vsnnetworks.com>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    return mail($adminEmail, $subject, $htmlMessage, $headers);
}


function sendContactEmail($to, $name, $email, $message) {
    $to = "mail2saurabhm@gmail.com";
    $subject = "Contact Form Submission from VSN-Networks";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $email = "donotreply@VSNNetworks.com";
    $headers = "From: $email\r\n";

    return mail($to, $subject, $body, $headers);
}