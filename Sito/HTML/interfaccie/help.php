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
        echo '<p style="font-size:25px;">Segnalazione inviata con successo</p>';
    } catch (Exception $e) {
        echo '<p style="font-size:25px;">'."Errore nell'invio della segnalazione</p>";
    }
} else {
    echo '
    <link rel="stylesheet" href="../CSS/contatti.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dongle:wght@300&display=swap" rel="stylesheet">
    <div class="tutto">
    <div class="titolo">
    <br>
    <p class="titoletti">Mail ► maildainserire@mail.it</p></div>
    <div class="contatti">
        <div class="contatti-full">
            <div class="contatti-semi">
                <p>
                    <label for=""class="titoletti">Nome*</label>&nbsp;&nbsp;&nbsp;
                    <input type="text" name="nome" id="nome" class="campi_info">
                </p>
                <p>
                    <label for=""class="titoletti">Società*</label>&nbsp;
                    <input type="text" name="societa" id="societa" class="campi_info">
                </p>
                <p>
                    <label for=""class="titoletti">Mail*</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" name="mail" id="mail" class="campi_info">
                </p>
            </div>
            <div class="contatti-semi">
                <p>
                    <label for=""class="titoletti">Cognome*</label>&nbsp;
                    <input type="text" name="cognome" id="cognome" class="campi_info">
                </p>
                <p>
                    <label for=""class="titoletti">Oggetto della segnalazione*</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" name="oggettoSegnalazione" id="oggettoSegnalazione" class="campi_info">
                </p>
                <p>
                    <label for=""class="titoletti">Telefono*</label>&nbsp;&nbsp;
                    <input type="text" name="telefono" id="telefono" class="campi_info">
                </p>
            </div>
        </div>
        <br>
        <div class="contatti-testo">
            <input type="text" name="testo_richiesta" id="testo_richiesta" placeholder="Inserisci testo...">
        </div>
        <div>
            <button class="invia" onclick="inviaHelp()" > Invia Messaggio </button>
        </div>
    </div>
</div>

';
}
?>
