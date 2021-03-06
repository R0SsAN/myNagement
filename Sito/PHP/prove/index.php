<?php

session_start();
require_once "connect_db.php";



$sql = "SELECT COUNT(`CodDipendente`) as cod FROM `assenze` WHERE Tipo=0";
$sql2 = "SELECT COUNT(`CodDipendente`)as cod2 FROM `presenza` where presente=1";
if (($result = mysqli_query($link, $sql)) && ($result2 = mysqli_query($link, $sql2))) {
    if ((mysqli_num_rows($result) > 0) && (mysqli_num_rows($result2) > 0)) {
        $row = mysqli_fetch_array($result);
        $row2 = mysqli_fetch_array($result2);
        $ris = $row["cod"];
        $ris2 = $row2["cod2"];
        $data = date("d/m/Y");
        echo '<!DOCTYPE html>
                <html lang="en">
                
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Document</title>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
                    <link rel="stylesheet" href="style.css">
                    <link rel="preconnect" href="https://fonts.googleapis.com" />
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
                    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet" />
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
                        integrity="sha384-wvfxpqpZZVQGK6TAh5PV1GOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous" />
                
                </head>
                
                <body>
                
                    <div class="cardBox">
                        <div class="card">
                            <p id=data>Data: &nbsp' . $data . '</p>
                        </div>
                    </div>
                
                    <div class="details">
                        <div class="recentOrders">
                            <div class="cont">
                                <h1 id="titoloPresenze" class="titoloPresenze">Presenze giornaliere</h1>
                                <canvas id="canvas" class="cont"></canvas>
                            </div>
                        </div>
                
                        <div class="recentCustomers">
                            <div class="container2">
                                <h1 id="andamento" class="andamento">Andamento</h1>
                                <canvas id="canvas2"></canvas>
                            </div>
                
                        </div>
                
                        <div class="info">
                            <div class="container3">
                                <h1 id="informazioni" class="andamento">Informazioni</h1><br>
                                <label for="">Nome azienda</label><br>
                                <label for="">Numero dipendenti</label><br>
                                <label for="">Ammontare stipendi</label><br>
                                <label for="">Note</label><br>
                                <input type="text"><br>
                            </div>
                        </div>
                    </div>
                
                    <script>
                        let myCanvas = document.getElementById("canvas").getContext("2d");
                
                        let citta = ["Assenti", "Presenti"];
                        let Data = [' . $ris . ',' . $ris2 . '];
                
                        let myChart = new Chart(canvas, {
                            type: "doughnut", //tipo di grafico bar, pie , line , doughnut
                
                            //dati del grafico
                            data: {
                                labels: citta,
                
                                datasets: [{
                                    label: "numero a caso",
                                    data: Data,
                
                                    backgroundColor: [
                                        "rgba(255, 99, 132, 0.2)",
                                        "rgba(54, 162, 235, 0.2)"
                
                
                                    ],
                                    borderColor: [
                                        "rgba(255, 99, 132, 1)",
                                        "rgba(54, 162, 235, 1)"
                
                                    ],
                
                                }]
                            },
                
                
                            options: {
                                title: {
                                    display: true,
                                    text: "Ciaoooooooooooooooooo",
                                    fontSize: 25,
                                    position: top
                                }
                            }
                        });
                    </script>
                
                    <script>
                        let myCanvas2 = document.getElementById("canvas2").getContext("2d");
                
                        let citta2 = ["Assenti", "Presenti"];
                        let Data2 = [1, 3];
                
                        let myChart2 = new Chart(canvas2, {
                            type: "line", //tipo di grafico bar, pie , line , doughnut
                
                            //dati del grafico
                            data: {
                                labels: citta2,
                
                                datasets: [{
                                    label: "numero a caso",
                                    data: Data2,
                
                                    backgroundColor: [
                                        "rgba(255, 99, 132, 0.2)",
                                        "rgba(54, 162, 235, 0.2)"
                
                
                                    ],
                                    borderColor: [
                                        "rgba(255, 99, 132, 1)",
                                        "rgba(54, 162, 235, 1)"
                
                                    ],
                
                                }]
                            },
                
                
                            options: {
                
                            }
                        });
                
                    </script>
                </body>
                
                </html>';


        // Free result set
        mysqli_free_result($result);
    }
}
