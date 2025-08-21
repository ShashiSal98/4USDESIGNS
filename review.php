<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Replace with the email where you want to receive reviews
$receiving_email_address = 'shashisalwathura@gmail.com';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating         = strip_tags(trim($_POST["rating"]));
    $review_title   = strip_tags(trim($_POST["review_title"]));
    $review_message = trim($_POST["review_message"]);
    $review_name    = strip_tags(trim($_POST["review_name"]));
    $review_email   = filter_var(trim($_POST["review_email"]), FILTER_SANITIZE_EMAIL);

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'shashisalwathura@gmail.com'; // Your Gmail
        $mail->Password   = 'frqx oczo wwru uqqe';        // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

         // Recipient (always your email)
        $mail->setFrom('shashisalwathura@gmail.com', '4USDESIGNS - Review Form');
        $mail->addAddress('shashi.salwathura78@gmail.com'); // All forms go here

         // Format email to match the style from the screenshot
        $emailBody = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                        
            <div style='padding: 20px; background-color: #f9f9f9;'>
            
                    <h3 style='color: #333; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;'>New Review from 4USDESIGNS - Review Form</h3>
                    
                    <table style='width: 100%; border-collapse: collapse;'>
                        <tr>
                            <td style='padding: 8px; width: 120px; color: #555; font-weight: bold;'>Name:</td>
                            <td style='padding: 8px;'>$review_name</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px; color: #555; font-weight: bold;'>Email:</td>
                            <td style='padding: 8px;'>$review_email</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px; color: #555; font-weight: bold;'>Rating:</td>
                            <td style='padding: 8px;'>
                                <div style='color: #ffc107; font-size: 18px;'>" . str_repeat('★', $rating) . str_repeat('☆', 5 - $rating) . " ($rating/5)</div>
                            </td>
                        </tr>
                        <tr>
                            <td style='padding: 8px; color: #555; font-weight: bold;'>Review Title:</td>
                            <td style='padding: 8px;'>$review_title</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px; color: #555; font-weight: bold; vertical-align: top;'>Message:</td>
                            <td style='padding: 8px;'>" . nl2br(htmlspecialchars($review_message)) . "</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>";

        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Review: $review_title";
        $mail->Body    = $emailBody;
        $mail->AltBody = "New Review from 4USDESIGNS - Review Form\n\n" .
                         "Name: $review_name\n" .
                         "Email: $review_email\n" .
                         "Rating: $rating/5\n" .
                         "Review Title: $review_title\n" .
                         "Review Message:\n$review_message\n\n";

        $mail->send();
        echo "OK";
    } catch (Exception $e) {
        echo "Sorry, there was an error sending your review. Please try again later.";
    }
} else {
    echo "Invalid request.";
}
?>
