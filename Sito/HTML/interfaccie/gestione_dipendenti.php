<?php
session_start();
if (!isset($_SESSION["userId"]))
    header("Location: ../login.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://kit.fontawesome.com/b1ee2cf5f1.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-growl/1.0.0/jquery.bootstrap-growl.min.js" integrity="sha512-pBoUgBw+mK85IYWlMTSeBQ0Djx3u23anXFNQfBiIm2D8MbVT9lr+IxUccP8AMMQ6LCvgnlhUCK3ZCThaBCr8Ng==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" type="text/css" href="../../CSS/tabella_dinamica.css">
    <link rel="stylesheet" href="../../CSS/gestionedipendenti_style.css">

</head>

<body>
    <div id="vue-container">
        <div class="tabella">
            <div class="date">
                <i class="fa-solid fa-angles-left fa-xl" @click="aggiornadata(-1,0)" style="cursor: pointer;"></i>
                <i class="fa-solid fa-angle-left fa-xl" @click="aggiornadata(0,-1)" style="cursor: pointer;"></i>
                <label id="current_date"></label>
                <i class="fa-solid fa-angle-right fa-xl" @click="aggiornadata(0,1)" style="cursor: pointer;"></i>
                <i class="fa-solid fa-angles-right fa-xl" @click="aggiornadata(1,0)" style="cursor: pointer;"></i>
            </div>
            <div class="container-table100">
                <div class="wrap-table100">
                    <div class="table100">
                        <table style="border-radius: 10px;" id="tabellla">
                            <div class="searchbar">
                                <input type="text" id="myInput" onkeyup="cercaInTabella()" placeholder="Search for names..">
                            </div>
                            <thead>
                                <tr>
                                    <th>nome</th>
                                    <th>cognome</th>
                                    <th>contratto</th>
                                    <th>ore totali</th>
                                    <th>stipendio</th>
                                    <th>cassa integrazione</th>
                                    <th>malattia</th>
                                    <th>ferie</th>
                                    <th>maternità</th>
                                    <th>anagrafiche</th>
                                </tr>
                            </thead>
                            <tbody id="table">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="myModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titoloAnagrafica">Anagrafica di:</h5>
                    </div>
                    <div class="modal-body" id="modal-body">

                    </div>
                    <div class="modal-footer" style="justify-content:space-between;">
                        <button class="buttonanagrafica" id="edit" onclick="disable()">Modifica Contratto</button>
                        <button class="buttonanagrafica" id="salva" onclick="save()" visibility="hidden">Salva</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="loader-wrapper">
            <span class="loader"><span class="loader-inner"></span></span>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="../../JS/gestione-dipendenti_script.js"></script>
</body>

</html>