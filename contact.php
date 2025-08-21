<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$receiving_email_address = 'shashisalwathura@gmail.com';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name    = strip_tags(trim($_POST["name"]));
  $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $subject = strip_tags(trim($_POST["subject"]));
  $message = trim($_POST["message"]);

  $mail = new PHPMailer(true);

  try {
    //Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'shashisalwathura@gmail.com';      // Replace with YOUR Gmail
    $mail->Password   = 'frqx oczo wwru uqqe';        // Use Gmail App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Recipient (always your email)
        $mail->setFrom('shashisalwathura@gmail.com', '4USDESIGNS - Contact Form');
        $mail->addAddress('shashi.salwathura78@gmail.com'); // All forms go here

     // Format email to match screenshot style
    $emailBody = "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
           
                              
                <h3 style='color: #333; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;'>New message from 4USDESIGNS - Contact Form</h3>
                
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr>
                        <td style='padding: 8px; width: 80px; color: #555; font-weight: bold;'>Name:</td>
                        <td style='padding: 8px;'>$name</td>
                    </tr>
                    <tr>
                        <td style='padding: 8px; color: #555; font-weight: bold;'>Email:</td>
                        <td style='padding: 8px;'>$email</td>
                    </tr>
                    <tr>
                        <td style='padding: 8px; color: #555; font-weight: bold; vertical-align: top;'>Message:</td>
                        <td style='padding: 8px;'>" . nl2br(htmlspecialchars($message)) . "</td>
                    </tr>
                </table>
    </div>";

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $emailBody;
    $mail->AltBody = "Name: $name\nEmail: $email\nMessage:\n$message";


    $mail->send();
    echo "OK";
  } catch (Exception $e) {
    echo "Sorry, there was an error sending your message. Please try again later.";
  }
} else {
  echo "Invalid request.";
}
?>