<?php
session_start();
if(!isset($_SESSION["userId"]))
    die("Error");
require "../../PHP/Librerie/PHPMailer/PHPMailerAutoload.php";
if (isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['oggettoSegnalazione']) && isset($_POST['telefono']) && isset($_POST['societa']) && isset($_POST['mail'])) {
    //invio mail
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->SMTPDebug=0;
        $mail->isSMTP();
        $mail->Host       = "ssl://smtp.gmail.com";
        $mail->SMTPAuth   = true;
        $mail->Username   = "help.mynagement@gmail.com";
        $mail->Password   = 'PasswordProgetto';
        $mail->Port       = 465;
        $mail->setFrom('help.mynagement@gmail.com');
        $mail->addAddress('help.mynagement@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = $_POST['oggettoSegnalazione'];
        $mail->Body = "Utente: " . $_POST['nome'] . " " . $_POST['cognome'] . " " . "della società: " . $_POST['societa'] .
            "<br>" . "Ha riscontrato il seguente problema: " . $_POST['testo_richiesta'] . "<br>" .
            "Recapito telefonico: " . $_POST['telefono'] . "<br>" . "Mail: " . $_POST['mail'];
        $mail->send();
        die("true");
    } catch (Exception $e) {
        die("false");
    }
}
?>