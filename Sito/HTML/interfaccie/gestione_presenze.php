<?php
session_start();
if (!isset($_SESSION["userId"]))
    header("Location: login.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet" /> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../../CSS/gestionedipendenti_style.css">
    <link rel="stylesheet" href="../../CSS/gestione_presenze.css">
    <link rel="stylesheet" type="text/css" href="../../CSS/tabella_style.css">
    <link rel="stylesheet" type="text/css" href="../../CSS/dipendenti_style.css">

   
    <title>Document</title>
    <style>
        .column1 {
            width: 150px;
        }

        .column2 {
            width: 160px;
        }

        .column3 {
            width: 100px;
        }

        .column4 {
            width: 210px;
        }

        .column5 {
            width: 300px;
        }
    </style>

</head>

<body>
    <div class="content" id="vue-container">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <table style="border-radius: 10px;" id="tabella">
                        <div class="searchbar">
                            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names..">
                        </div>
                        <thead>
                            <tr class="table100-head">
                                <th class="column1">Nome</th>
                                <th class="column2">Cognome</th>
                                <th class="column3">Presente</th>
                                <th class="column4">Assenze</th>
                                <th class="column5">Aggiungi Assenza</th>
                            </tr>
                        </thead>
                        <tbody id="contenutotabella">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- <table> 
            <thead>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Presente</th>
                <th>Assenza</th>

            </thead>
            <tbody id="contenutotabella">

            </tbody>
        </table>-->

        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titoloAnagrafica">Anagrafica di:</h5>
                    </div>
                    <div class="modal-body">
                        <div class="dipendente">
                            Tipo Assenza: <select name="tipoassenza" id="assenza">
                                <option selected>Choose...</option>
                                <option value="malattia">Malattia</option>
                                <option value="ferie">Ferie</option>
                                <option value="cassa integrazione">Cassa Integrazione</option>
                            </select><br><br><br>
                            Data-Inizio: <input type="date" name="" id="datainizio"><br><br>
                            Data-Fine: <input type="date" name="" id="datafine"></label><br><br>
                            Percentuale Dello Stipendio:
                            <input type="range" class="form-range" id="customRange1" step="5"> <label for="" id="percstipendio"></label><br><br>
                        </div>
                    </div>
                    <div class="modal-footer" style="justify-content: space-between;">
                        <p id="errore" style="color: red; font-size: 15px;"></p> <button type="submit" id="btnam" class="submit" style="width: 40%; margin-top: 0px;" onclick="AggiornaAssenze()"></button>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="../../JS/gestione-presenze.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>