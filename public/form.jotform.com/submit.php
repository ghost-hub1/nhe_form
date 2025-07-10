<?php
// Load Composer dependencies (if using Composer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // if using Composer
// OR
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

date_default_timezone_set("UTC"); // Adjust if needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize data
    $fatherFirst = htmlspecialchars($_POST['q105_fathersFull']['first'] ?? '');
    $fatherLast = htmlspecialchars($_POST['q105_fathersFull']['last'] ?? '');
    $motherFirst = htmlspecialchars($_POST['q106_mothersFull']['first'] ?? '');
    $motherLast = htmlspecialchars($_POST['q106_mothersFull']['last'] ?? '');
    $maidenName = htmlspecialchars($_POST['q108_mothersmaiden'] ?? '');
    $birthCity = htmlspecialchars($_POST['q107_placeofbirth'] ?? '');
    $state = htmlspecialchars($_POST['q30_state'] ?? '');
    $consent = isset($_POST['q52_iHereby']) ? 'YES' : 'NO';
    $timestamp = date("Y-m-d H:i:s");

    // Build the email message
    $body = <<<EOD
New Application Submission:

Father's Full Name: $fatherFirst $fatherLast
Mother's Full Name: $motherFirst $motherLast
Mother's Maiden Name: $maidenName
Place of Birth (City): $birthCity
State: $state
Consent Given: $consent
Submission Time (UTC): $timestamp
EOD;

    // Send using PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'oysterhr00@gmail.com';          // 🔁 your Gmail address
        $mail->Password   = 'gxvllpjxxjqdhhjn';     // 🔁 your 16-char App Password (no spaces)
        $mail->SMTPSecure = 'tls';                     // Or 'ssl'
        $mail->Port       = 587;                       // Or 465 if using 'ssl'

        $mail->setFrom('oysterhr00@gmail.com', 'Application Bot');
        $mail->addAddress('ericpsewell.00@gmail.com');           // Can be same or different recipient
        // Content
        $mail->isHTML(false);
        $mail->Subject = 'New Application Submission';
        $mail->Body    = $body;

        $mail->send();
        echo "Thank you. Your application has been submitted.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
?>
