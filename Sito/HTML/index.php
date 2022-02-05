<?php
if(isset($_POST['nome'])&&isset($_POST['cognome'])&&isset($_POST['ruolo'])&&isset($_POST['telefono'])&&isset($_POST['societa'])&&isset($_POST['mail']))
{
    //invio mail
}else 
{
echo '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/contattiStyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dongle:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <div class="titolo">
        <img src="logo.jpeg" alt="attento" width="100">     
    </div>
    <div class="titolo"><p class="titoletti">Mail ► maildainserire@mail.it</p></div>
    <div class="contatti">
        <div class="contatti-full">
            <div class="contatti-semi">
                <p>
                    <label for=""class="titoletti">Nome*</label>&nbsp;&nbsp;&nbsp;
                    <input type="text" name="nome" id="">
                </p>
                <p>
                    <label for=""class="titoletti">Società*</label>&nbsp;
                    <input type="text" name="società" id="">
                </p>
                <p>
                    <label for=""class="titoletti">Mail*</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" name="mail" id="">
                </p>
            </div>
            <div class="contatti-semi">
                <p>
                    <label for=""class="titoletti">Cognome*</label>&nbsp;
                    <input type="text" name="cognome" id="">
                </p>
                <p>
                    <label for=""class="titoletti">Ruolo*</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" name="ruolo" id="">
                </p>
                <p>
                    <label for=""class="titoletti">Telefono*</label>&nbsp;&nbsp;
                    <input type="text" name="telefono" id="">
                </p>
            </div>
        </div>
        <br>
        <div class="contatti-testo">
            <input type="text" name="testo" id="testo_richiesta" placeholder="Inserisci testo...">
        </div>
        <div>
            <input type="submit" value="Invia Messaggio" class="invia">
        </div>
    </div>


</body>

</html>';
}
