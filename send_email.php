<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Adjust path if needed

// Load SMTP credentials from config.php
$config = require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format'); window.history.back();</script>";
        exit();
    }

    $to = 'vivek.pandit@somaiya.edu';
    $subject = "New message from: $name";
    $emailBody = "<p><strong>Name:</strong> $name</p>
                  <p><strong>Email:</strong> $email</p>
                  <p><strong>Message:</strong> $message</p>";

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp_username']; // Use config variable
        $mail->Password = $config['smtp_password']; // Use config variable
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($config['smtp_username'], $name); // Use your SMTP username
        $mail->addAddress($to); // Recipient's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $emailBody;

        $mail->send();
        
        // Show alert and refresh the page
        echo "<script>
                alert('Email sent successfully!');
                window.location.href = 'contact.html'; // Redirect to the same page or another
              </script>";
    } catch (Exception $e) {
        echo "<script>alert('Failed to send email: {$mail->ErrorInfo}');</script>";
    }
} else {
    echo "<script>alert('Invalid request method.');</script>";
}
?>
