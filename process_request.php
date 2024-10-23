<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ensure the path is correct

// Load SMTP credentials from config.php
$config = require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $language = htmlspecialchars(trim($_POST['languages'])); // For language selection
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format'); window.history.back();</script>";
        exit();
    }

    // Set recipient and subject
    $to = 'vivek.pandit@somaiya.edu';
    $subject = "New request from: $name for $language"; // Include language in the subject

    // Prepare email body
    $emailBody = "<p><strong>Name:</strong> $name</p>
                  <p><strong>Email:</strong> $email</p>
                  <p><strong>Language:</strong> $language</p>
                  <p><strong>Message:</strong> $message</p>";

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Use your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp_username']; // Use the username from the config
        $mail->Password = $config['smtp_password']; // Use the password from the config
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($config['smtp_username'], $name); // Sender's email
        $mail->addAddress($to); // Recipient's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $emailBody;

        // Send email
        if ($mail->send()) {
            // Show alert and redirect on success
            echo "<script>
                    alert('Request sent successfully!');
                    window.location.href = 'index.html'; // Redirect to your desired page
                  </script>";
        } else {
            // Show error message if sending fails
            echo "<script>alert('Failed to send request: {$mail->ErrorInfo}');</script>";
        }
    } catch (Exception $e) {
        // Catch and display any errors during the mail process
        echo "<script>alert('Mailer Error: {$mail->ErrorInfo}');</script>";
    }
} else {
    // Show alert if accessed directly
    echo "<script>alert('Invalid request method.'); window.location.href = 'index.html';</script>";
}
?>
