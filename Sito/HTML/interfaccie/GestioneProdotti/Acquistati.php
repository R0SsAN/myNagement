<?php
require_once '../../../PHP/connect_db.php';

$sql = "SELECT * FROM prodotti_acquistati";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo '        
   <div class="content2">
  <button class="buttonanagrafica" id="btn">INSERISCI PRODOTTI ACQUISTATI</button>
    <div id="modal" class="modal">
    <form action="inserisci_acquistati.php" method="post" class="modal-content">
    <span class="close">&times;</span>
       <div class="only-start">INSERIMENTO PRODOTTO</div>
       <div class="row">
       <div class="column">
       <p>Seriale:</p> <input  name="Seriale" type="text"><br>
       <p>Nome:</p> <input  name="Nome" type="text"><br>
       <p>Prezzo:</p> <input type="range" name="Prezzo" value="24" min="1" max="50000" oninput="this.nextElementSibling.value = this.value">
       <output style="margin-left: 28%;">1</output>$
       </div>
       <div class="column" >
       <p>Quantità:</p> <input  name="Quantita" style="width: 87%; text-align: center" type="number" min=1 max = 50000><br>
       <p> Produttore:</p> <input  name="Produttore" type="text"><br>
       <p>Data:</p> <input  name="Data" type="date">
       </div>
       </div>     
       <input type="submit" class="submit" value="INSERISCI">
     </form>
     </div>
        <table>
            <tr>
                <th>seriale</th>
                <th>nome</th>
                <th>prezzo</th>
                <th>quantità</th>
                <th>produttore</th>
                <th>data acquisto</th>               

            </tr>
            ';
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['Seriale'] . "</td>";
            echo "<td>" . $row['Nome'] . "</td>";
            echo "<td>" . $row['Prezzo'] . " $" . "</td>";
            echo "<td>" . $row['Quantita'] . "</td>";
            echo "<td>" . $row['Produttore'] . "</td>";
            echo "<td>" . $row['DataAcquisto'] . "</td>";
            echo "</tr>";
        }
        echo '</table>
    </div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../CSS/GestioneProdotti_style.css">
    <script src="../../../JS/gestione-prodotti.js"></script>
    <title>Document</title>
</head>

<body>
</body>

</html>