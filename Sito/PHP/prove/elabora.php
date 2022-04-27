<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/gestionedipendenti_style.css">
    <title>Document</title>
</head>

<body>
    <div class="content">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

            <tr>
                <!-- <td>Luca</td>
                    <td>Cattaneo</td>
                    <td><input type="checkbox"></td>
                    <td><input type="date" name="prova" id=""></td>
                    <td><input type="date" name="" id=""></td>
                    <td>1</td> -->

                <?php
                // Include config file
                require_once "connect_db.php";
                
                $sql = "SELECT p.CodDipendente FROM presenza p WHERE p.presente=0";
                echo $sql;
                if ($result = mysqli_query($link, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        $row=mysqli_fetch_array($result);
                      $count= mysqli_num_rows($result);
                        echo '<!DOCTYPE html>
                        <html lang="en">
                        
                        <head>
                            <meta charset="UTF-8">
                            <meta http-equiv="X-UA-Compatible" content="IE=edge">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Document</title>
                           <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
                            <link rel="stylesheet" href="../CSS/contattiStyle.css">
                            <link rel="preconnect" href="https://fonts.googleapis.com">
                            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                            <link href="https://fonts.googleapis.com/css2?family=Dongle:wght@300&display=swap" rel="stylesheet">
                        </head>
                        
                        <body>
                            <div class="container" style="margin: 40%;">
                                <h1>ciao</h1>
                                <canvas id="canvas"></canvas>
                            </div>
                        <p id="par"></p>
                            <script>
                                let myCanvas = document.getElementById("canvas").getContext("2d");
                                let citta= ["Presenza, Assenza"];
                                let Data =['.$row["CodDipendente"].',2];
                                document.getElementById("par").innerHTML='.$row["CodDipendente"].' 
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
                                        "rgba(54, 162, 235, 0.2)",
                                        "rgba(255, 206, 86, 0.2)"
                                        
                                    ],
                                    borderColor: [
                                        "rgba(255, 99, 132, 1)",
                                        "rgba(54, 162, 235, 1)",
                                        "rgba(255, 159, 64, 1)"
                                    ],
                                   
                                }]
                            },
                        
                            //opzioni aggiuntive
                            options: {
                               title: {
                                   display: true,
                                  
                                   fontSize: 25,
                                   position: top
                               }
                            }
                        });
                        
                            </script>
                        </body>
                        
                        </html>';
                    } else {
                        echo "<p class='lead'><em>No records were found.</em></p>";
                    }
                } else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }

                // Close connection
                mysqli_close($link);
                ?>

                <input type="submit" value="wsregd">
        </form>
    </div>
</body>

</html>