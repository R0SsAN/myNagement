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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../CSS/dipendenti_style.css" />
    <link rel="stylesheet" type="text/css" href="../../CSS/contabilita_style.css" />
    <link rel="stylesheet" href="../../CSS/tabella_dinamica.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://kit.fontawesome.com/b1ee2cf5f1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
</head>

<body>
    <div id="vue-container">
        <div class="container-button">
            <button type="button" class="submit2" data-bs-toggle="modal" data-bs-target="#myModal">Inserisci nuovo movimento</button>
            <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-dialog-centered">
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
                                <input type="radio" id="tipo-1" name="input-tipo" value="0" style="margin-left:25px" checked="checked"> &nbsp; Entrata <br>
                                <input type="radio" id="tipo-2" name="input-tipo" value="1" style="margin-left:25px"> &nbsp; Uscita
                            </div>
                            <br><br>

                            <div class="input-container ic1">
                                <input id="input-descrizione" class="input" type="text" placeholder=" " name="descrizione" />
                                <div class="cut"></div>
                                <label for="firstname" class="placeholder">Descrizione</label>
                            </div>
                            <div class="input-container ic1">
                                <input id="input-valore" class="input" type="number" placeholder=" " name="valore" style="margin-left:10px;width:200px;" />
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
            <div class="date">
                <i class="fa-solid fa-angles-left fa-xl" @click="aggiornadata(-1,0)" style="cursor: pointer;"></i>
                <i class="fa-solid fa-angle-left fa-xl" @click="aggiornadata(0,-1)" style="cursor: pointer;"></i>
                <label id="current_date"></label>
                <i class="fa-solid fa-angle-right fa-xl" @click="aggiornadata(0,1)" style="cursor: pointer;"></i>
                <i class="fa-solid fa-angles-right fa-xl" @click="aggiornadata(1,0)" style="cursor: pointer;"></i>
            </div>
        </div>
        <div class="container-content">

            <div class="riepilogo">
                <div class="content-movimenti">
                    <h3 style="margin:0;">Entrate a <a class="mese-anno">Marzo 2022</a>: <a style="color:green;" id="somma-entrate">19576 €</a></h3>
                    &nbsp;
                    <div style="margin-left:7px">
                        <h4 style="margin:0;margin-bottom:4px;">Di cui:</h4>
                        <ul>
                            <li>
                                <h4>Entrate per vendita prodotti: &nbsp;
                                    <a style="color:green;" id="entrate-prodotti">19576 €</a>
                                </h4>
                            </li>
                            <li>
                                <h4>Entrate per movimenti generici: &nbsp;
                                    <a style="color:green;" id="entrate-movimenti">19576 €</a>
                                </h4>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="content-movimenti">
                    <h3 style="margin:0;">Uscite a <a class="mese-anno">Marzo 2022</a>: <a style="color:red;" id="somma-uscite">19576 €</a></h3>
                    &nbsp;
                    <div style="margin-left:7px">
                        <h4 style="margin:0; margin-bottom:4px;">Di cui:</h4>
                        <ul>
                            <li>
                                <h4>Uscite per acquisto prodotti: &nbsp;
                                    <a style="color:red;" id="uscite-prodotti">19576 €</a>
                                </h4>
                            </li>
                            <li>
                                <h4>Uscite per movimenti generici: &nbsp;
                                    <a style="color:red;" id="uscite-movimenti">19576 €</a>
                                </h4>
                            </li>
                            <li>
                                <h4>Uscite per Stipendi pagati: &nbsp;
                                    <a style="color:red;" id="uscite-stipendi">19576 €</a>
                                </h4>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="content-movimenti" style="margin-top:30px">
                    <h3 style="margin:0;">Ricavi a <a class="mese-anno">Marzo 2022</a>: <a style="color:green;" id="ricavi">8455 €</a></h3>
                    <!-- <div style="margin-left:7px">
                        <h4 style="margin:0; margin-top:5px;"><a id="percentuale" style="color:green;">+19%</a> rispetto al mese precedente</h4>
                    </div> -->
                </div>

            </div>
            <div class="tabella-movimenti">
                <div class="container-table100">
                    <div class="wrap-table100">
                        <div class="table100">
                            <table style="border-radius: 10px;" id="tabella">
                                <div class="searchbar">
                                    <input type="text" id="myInput" onkeyup="cercaInTabella()" placeholder="Search for names..">
                                </div>
                                <thead>
                                    <tr class="table100-head">
                                        <th class="column1">Date</th>
                                        <th class="column2">Order ID</th>
                                        <th class="column3">Name</th>
                                        <th class="column4">Price</th>
                                        <th class="column5">Quantity</th>
                                        <th class="column6">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="column1">2017-09-29 01:22</td>
                                        <td class="column2">200398</td>
                                        <td class="column3">iPhone X 64Gb Grey</td>
                                        <td class="column4">$999.00</td>
                                        <td class="column5">1</td>
                                        <td class="column6">$999.00</td>
                                    </tr>
                                    <tr>
                                        <td class="column1">2017-09-29 01:22</td>
                                        <td class="column2">200398</td>
                                        <td class="column3">iPhone X 64Gb Grey</td>
                                        <td class="column4">$999.00</td>
                                        <td class="column5">1</td>
                                        <td class="column6">$999.00</td>
                                    </tr>
                                    <tr>
                                        <td class="column1">2017-09-29 01:22</td>
                                        <td class="column2">200398</td>
                                        <td class="column3">iPhone X 64Gb Grey</td>
                                        <td class="column4">$999.00</td>
                                        <td class="column5">1</td>
                                        <td class="column6">$999.00</td>
                                    </tr>
                                    <tr>
                                        <td class="column1">2017-09-29 01:22</td>
                                        <td class="column2">200398</td>
                                        <td class="column3">iPhone X 64Gb Grey</td>
                                        <td class="column4">$999.00</td>
                                        <td class="column5">1</td>
                                        <td class="column6">$999.00</td>
                                    </tr>
                                    <tr>
                                        <td class="column1">2017-09-29 01:22</td>
                                        <td class="column2">200398</td>
                                        <td class="column3">iPhone X 64Gb Grey</td>
                                        <td class="column4">$999.00</td>
                                        <td class="column5">1</td>
                                        <td class="column6">$999.00</td>
                                    </tr>
                                    <tr>
                                        <td class="column1">2017-09-29 01:22</td>
                                        <td class="column2">200398</td>
                                        <td class="column3">iPhone X 64Gb Grey</td>
                                        <td class="column4">$999.00</td>
                                        <td class="column5">1</td>
                                        <td class="column6">$999.00</td>
                                    </tr>
                                    <tr>
                                        <td class="column1">2017-09-29 01:22</td>
                                        <td class="column2">200398</td>
                                        <td class="column3">iPhone X 64Gb Grey</td>
                                        <td class="column4">$999.00</td>
                                        <td class="column5">1</td>
                                        <td class="column6">$999.00</td>
                                    </tr>
                                    <tr>
                                        <td class="column1">2017-09-29 01:22</td>
                                        <td class="column2">200398</td>
                                        <td class="column3">iPhone X 64Gb Grey</td>
                                        <td class="column4">$999.00</td>
                                        <td class="column5">1</td>
                                        <td class="column6">$999.00</td>
                                    </tr>
                                    <tr>
                                        <td class="column1">2017-09-29 01:22</td>
                                        <td class="column2">200398</td>
                                        <td class="column3">iPhone X 64Gb Grey</td>
                                        <td class="column4">$999.00</td>
                                        <td class="column5">1</td>
                                        <td class="column6">$999.00</td>
                                    </tr>
                                    <tr>
                                        <td class="column1">2017-09-29 01:22</td>
                                        <td class="column2">200398</td>
                                        <td class="column3">iPhone X 64Gb Grey</td>
                                        <td class="column4">$999.00</td>
                                        <td class="column5">1</td>
                                        <td class="column6">$999.00</td>
                                    </tr>
                                    <tr>
                                        <td class="column1">2017-09-29 01:22</td>
                                        <td class="column2">200398</td>
                                        <td class="column3">iPhone X 64Gb Grey</td>
                                        <td class="column4">$999.00</td>
                                        <td class="column5">1</td>
                                        <td class="column6">$999.00</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="../../JS/gestione-contabilita_script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>

</html>