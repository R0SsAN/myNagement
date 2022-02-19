<?php
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
        echo '<div class="esito"><p style="font-size:50px; text-align:center;">Segnalazione inviata con successo</p></div>';
    } catch (Exception $e) {
        echo '<div class="esito"><p style="font-size:50px;">'."Errore nell'invio della segnalazione</p></esito>";
    }
}
else
{
    echo '
    <div class="tutto">
        <div class="contatti">
            <form action="" method="POST">
                <div class="contatti-full">
                    <div class="contatti-semi">
                        <div class="input-container ic2">
                            <input id="lastname" class="input" type="text" placeholder=" " name="nome" />
                            <div class="cut"></div>
                            <label for="lastname" class="placeholder">Nome</label>
                        </div>

                        <div class="input-container ic2">
                        <input id="lastname" class="input" type="text" placeholder=" " name="cognome"/>
                        <div class="cut"></div>
                        <label for="lastname" class="placeholder">Cognome</label>
                        </div>

                        <div class="input-container ic2">
                        <input id="lastname" class="input" type="text" placeholder=" " name="societa" />
                        <div class="cut"></div>
                        <label for="lastname" class="placeholder">Società</label>
                        </div>
                    </div>
                    <div class="contatti-semi">
                        <div class="input-container ic2">
                            <input id="lastname" class="input" type="text" placeholder=" " name="oggettoSegnalazione" />
                            <div class="cut"></div>
                            <label for="lastname" class="placeholder">Oggetto della segnalazione</label>
                        </div>

                        <div class="input-container ic2">
                        <input id="lastname" class="input" type="text" placeholder=" " name="mail"/>
                        <div class="cut"></div>
                        <label for="lastname" class="placeholder">Mail</label>
                        </div>

                        <div class="input-container ic2">
                        <input id="lastname" class="input" type="text" placeholder=" " name="telefono" />
                        <div class="cut"></div>
                        <label for="lastname" class="placeholder">Telefono</label>
                        </div>
                    </div>
                </div>
                <br><br><br><br><br><br><br>
                <div class="contatti-testo">
                    <textarea name="testo_richiesta" id="testo_richiesta" placeholder="Inserisci testo..."></textarea>
                </div>
                <div class="divSubmit">
                    <input type="submit" class="submit" value="Invia Messaggio"/>
                </div>
            </form>
        </div>
    </div>
    ';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../CSS/contatti_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dongle:wght@300&display=swap" rel="stylesheet">
    <style>
    </style>
</head>
<body>
    

    </form>
</body>
</html>