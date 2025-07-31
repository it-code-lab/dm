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

function sendContactEmail($to, $name, $email, $message) {
    $to = "mail2saurabhm@gmail.com";
    $subject = "Contact Form Submission from VSN-Networks";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $email = "donotreply@VSNNetworks.com";
    $headers = "From: $email\r\n";

    return mail($to, $subject, $body, $headers);
}