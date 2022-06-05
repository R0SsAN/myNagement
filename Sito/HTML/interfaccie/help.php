<?php
session_start();
if(!isset($_SESSION["userId"]))
    header("Location: index.html");
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-growl/1.0.0/jquery.bootstrap-growl.min.js" integrity="sha512-pBoUgBw+mK85IYWlMTSeBQ0Djx3u23anXFNQfBiIm2D8MbVT9lr+IxUccP8AMMQ6LCvgnlhUCK3ZCThaBCr8Ng==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <style>
    </style>
</head>

<body>
    <div class="tutto" id="vue-container">
        <div class="contatti">
            <form action="" method="POST">
                <div class="contatti-full">
                    <div class="contatti-semi">
                        <div class="input-container ic2">
                            <input id="nome" class="input" type="text" placeholder=" " name="nome" />
                            <div class="cut"></div>
                            <label for="lastname" class="placeholder">Nome</label>
                        </div>

                        <div class="input-container ic2">
                            <input id="cognome" class="input" type="text" placeholder=" " name="cognome" />
                            <div class="cut"></div>
                            <label for="lastname" class="placeholder">Cognome</label>
                        </div>

                        <div class="input-container ic2">
                            <input id="societa" class="input" type="text" placeholder=" " name="societa" />
                            <div class="cut"></div>
                            <label for="lastname" class="placeholder">Società</label>
                        </div>
                    </div>
                    <div class="contatti-semi">
                        <div class="input-container ic2">
                            <input id="oggettoSegnalazione" class="input" type="text" placeholder=" " name="oggettoSegnalazione" />
                            <div class="cut"></div>
                            <label for="lastname" class="placeholder">Oggetto della segnalazione</label>
                        </div>

                        <div class="input-container ic2">
                            <input id="mail" class="input" type="text" placeholder=" " name="mail" />
                            <div class="cut"></div>
                            <label for="lastname" class="placeholder">Mail</label>
                        </div>

                        <div class="input-container ic2">
                            <input id="telefono" class="input" type="text" placeholder=" " name="telefono" />
                            <div class="cut"></div>
                            <label for="lastname" class="placeholder">Telefono</label>
                        </div>
                    </div>
                </div>
                <br><br><br><br>
                <div class="contatti-testo">
                    <textarea name="testo_richiesta" id="testo_richiesta"  placeholder=" Inserisci testo..."></textarea>
                </div>
                <div class="divSubmit">
                    <input type="button" class="submit" value="Invia Messaggio" @click="inviaRichiesta()" />
                </div>
            </form>
        </div>
    </div>
    <script src="../../JS/help.js"></script>
</body>

</html>