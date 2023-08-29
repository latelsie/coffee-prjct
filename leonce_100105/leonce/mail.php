<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
     $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.freshinkgarments.com';  // Set the SMTP server to send through
    $mail->SMTPAuth   = true;               // Enable SMTP authentication
    $mail->Username   = 'website@freshinkgarments.com';  // SMTP username
    $mail->Password   = 'password';  // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  // Enable implicit TLS encryption
    $mail->Port       = 465;

    //Recipients
    $mail->setFrom('website@freshinkgarments.com', 'Fresh Ink Garments');
    $mail->addAddress('info@freshinkgarments.com', 'freshinkgarments');     //Add a recipient
    $mail->addAddress('info@freshinkgarments.com');               
    $mail->addReplyTo($email, 'Information');
    
    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'New E-mail From Website';
    
    // Build the email body using form data
   

    $mail->Body = "<h2>New E-mail From Website</h2>
                   <p>Name: $name</p>
                   <p>Email: $email</p>
                   <p>Message: $message</p>";

    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
   header("location: index.php?err=sent");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}