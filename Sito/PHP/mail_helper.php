<?php
require "PHPMailerAutoload.php";

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                    
    $mail->isSMTP();                                            
    $mail->Host       ="ssl://smtp.gmail.com";                  
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = "help.mynagement@gmail.com";                    
    $mail->Password   = 'PasswordProgetto';                             
    $mail->Port       = 465;                                    

    //Recipients
    $mail->setFrom('help.mynagement@gmail.com');
    $mail->addAddress('help.mynagement@gmail.com');
    //Content
    $mail->isHTML(true);                       
    $mail->Body = "Prova mail";
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>