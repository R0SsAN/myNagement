<?php
    session_start();
    if(!isset($_SESSION["userId"]))
        header("Location: ../login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../CSS/dipendenti_style.css" />
    <link rel="stylesheet" type="text/css" href="../../CSS/contabilita_style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
</head>
<body>
    <div id="vue-container" class="container mt-5">
        <button type="button" class="submit" data-bs-toggle="modal" data-bs-target="#myModal" >Inserisci nuovo movimento</button>
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inserimento movimento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="padding-top:0;">
                        <div class="input-container ic2">
                            <div class="cut"></div>
                            <label for="lastname" class="placeholder">Tipo movimento</label>
                            <br><br>
                            <input type="radio" id="tipo-1" name="input-tipo" value="0" style="margin-left:25px" checked="checked"> Entrata <br>
                            <input type="radio" id="tipo-2" name="input-tipo" value="1" style="margin-left:25px"> Uscita
                        </div>
                        <br><br>

                        <div class="input-container ic1">
                            <input id="input-descrizione" class="input" type="text" placeholder=" " name="descrizione" />
                            <div class="cut"></div>
                            <label for="firstname" class="placeholder">Descrizione</label>
                        </div>
                        <div class="input-container ic1">
                            <input id="input-valore" class="input" type="number" placeholder=" " name="valore" style="margin-left:10px;width:200px;"/>
                            <div class="cut"></div>
                            <label for="firstname" class="placeholder">Valore</label>
                        </div>
                        <div class="input-container ic1">
                            <div class="cut"></div>
                            <label for="firstname" class="placeholder">Nome</label>
                            <br><br>
                            <div class="form-group">
                                <input type="date" id="input-data" name="dateStandard" style="margin-left:25px;">
                            </div>
                        </div>
                        <br><br>
                    </div>
                    <div class="modal-footer" style="justify-content:space-between;">
                        <p id="errore" style="color:red; font-size:15px; font-style:sans-serif;"></p>
                        <button type="submit" class="submit" style="width:40%; margin-top:0;" @click="aggiungiMovimento()">Inserisci movimento</button>
                    </div>
                </div>
            </div>
        </div>
        <button @click="visualizzaStipendiMensili()"></button>
    </div>

    <script src="../../JS/gestione-contabilita_script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>