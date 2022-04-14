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
    <link rel="stylesheet" href="../../CSS/gestionedipendenti_style.css">
    <link rel="stylesheet" type="text/css" href="../../CSS/tabella_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
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
    </div>

    <script src="../../JS/gestione-presenze.js"></script>
</body>

</html>