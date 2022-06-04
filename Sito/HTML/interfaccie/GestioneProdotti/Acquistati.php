<?php
session_start();
if (!isset($_SESSION["userId"]))
    header("Location: ../../../login.php");
require_once '../../../PHP/connect_db.php';

$sql = "SELECT * FROM prodotti_acquistati WHERE CodAzienda='" . $_SESSION['aziendaId'] . "'";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo '    
        <div class="content2" id="all">
        <div class="row">
        <div class="column">
       <button class="buttonanagraficamin" id="btn">INSERISCI PRODOTTI</button> 
       </div>
       <div class="column">
       <button class="buttonanagraficamin" id="btn2">ELIMINA PRODOTTI</button>   
       </div>
       </div>
         <div id="modal" class="modal">
        <form action="inserisci_acquistati.php" method="post" class="modal-content-minor">
        <span class="close">&times;</span>
        <div style="padding-top: 1.5%" class="only-start">INSERIMENTO PRODOTTO</div>
       <div style="padding-top: 3%" class="rowin">
       <div class="column">
      <p>Seriale:</p> <input  name="Seriale" type="text"><br>
      <p>Nome:</p> <input  name="Nome" type="text"><br>
      <p>Prezzo:</p> <input type="range" name="Prezzo" value="1" min="1" max="50000" oninput="this.nextElementSibling.value = this.value">
      <input type="number" max=50000 style="text-align: center; margin-left: 22%" value="1" min=1>$
      </div>
    <div class="column" >
    <p>Quantità:</p> <input  name="Quantita" style="width: 60%; text-align: center" type="number" value="1" min=1 max = 50000><br>
    <p> Produttore:</p> <input  name="Produttore" type="text"><br>
    <p>Data:</p> <input  name="Data" type="date">
    </div>
    </div> 
            <input type="submit" class="subbut" value="INSERISCI">
          </form>
          </div> 
          <div id="delete" class="modal">
          <form id="deletef" method=POST action="elimina_acquistati.php" class="modal-content-minor">
          <span class="close2">&times;</span>
             <div class="only-start-del">ELIMINAZIONE PRODOTTO</div>
             <p id="choose">Sei sicuro di voler eliminare i prodotti selezionati?</p> 
             <p id="error" style="padding-top: 15px; margin-left: 30%" hidden>Seleziona almeno un prodotto...</p> 
             <div class="rowdel">
             <div class="column">
             <input type="submit" id="si" class="subbut-del" value="SI">
             <input name="vect" id="ele" type="hidden" >
             </div>
             <div class="column">
             <input type="button" id="nobtn" class="subbut-del" value="NO">
             </div>
             </div>
           </form>
           </div> 
        <table id="table">
        <tr id="title">
                <th>seriale</th>
                <th>nome</th>
                <th>prezzo</th>
                <th>quantità</th>
                <th>produttore</th>
                <th>data acquisto</th>               
            </tr>';
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            $name = "row" . $i;
            echo "<tr id='$name'>";
            echo "<td id='serial$i'>" . $row['Seriale'] . "</td>";
            echo "<td>" . $row['Nome'] . "</td>";
            echo "<td>" . $row['Prezzo'] . " $" . "</td>";
            echo "<td>" . $row['Quantita'] . "</td>";
            echo "<td>" . $row['Produttore'] . "</td>";
            echo "<td>" . $row['DataAcquisto'] . "</td>";
            echo "</tr>";
            $i++;
        }
        echo '</table>
        </div>';
    } else {
        echo '    
        <div class="content2" id="all">
        <div class="row">
        <div class="column">
       <button class="buttonanagraficamin" id="btn">INSERISCI PRODOTTI</button> 
       </div>
       <div class="column">
       <button class="buttonanagraficamin" id="btn2">ELIMINA PRODOTTI</button>   
       </div>
       </div>
         <div id="modal" class="modal">
        <form action="inserisci_acquistati.php" method="post" class="modal-content-minor">
        <span class="close">&times;</span>
        <div style="padding-top: 1.5%" class="only-start">INSERIMENTO PRODOTTO</div>
       <div style="padding-top: 3%" class="rowin">
       <div class="column">
      <p>Seriale:</p> <input  name="Seriale" type="text"><br>
      <p>Nome:</p> <input  name="Nome" type="text"><br>
      <p>Prezzo:</p> <input type="range" name="Prezzo" value="1" min="1" max="50000" oninput="this.nextElementSibling.value = this.value">
      <input type="number" max=50000 style="text-align: center; margin-left: 22%" value="1" min=1>$
      </div>
    <div class="column" >
    <p>Quantità:</p> <input  name="Quantita" style="width: 60%; text-align: center" type="number" value="1" min=1 max = 50000><br>
    <p> Produttore:</p> <input  name="Produttore" type="text"><br>
    <p>Data:</p> <input  name="Data" type="date">
    </div>
    </div> 
            <input type="submit" class="subbut" value="INSERISCI">
          </form>
          </div> 
          <div id="delete" class="modal">
          <form id="deletef" method=POST action="elimina_acquistati.php" class="modal-content-minor">
          <span class="close2">&times;</span>
             <div class="only-start-del">ELIMINAZIONE PRODOTTO</div>
             <p id="choose">Sei sicuro di voler eliminare i prodotti selezionati?</p> 
             <p id="error" style="padding-top: 15px; margin-left: 30%" hidden>Seleziona almeno un prodotto...</p> 
             <div class="rowdel">
             <div class="column">
             <input type="submit" id="si" class="subbut-del" value="SI">
             <input name="vect" id="ele" type="hidden" >
             </div>
             <div class="column">
             <input type="button" id="nobtn" class="subbut-del" value="NO">
             </div>
             </div>
           </form>
           </div> 
        <table id="table">
        <tr id="title">
                <th>seriale</th>
                <th>nome</th>
                <th>prezzo</th>
                <th>quantità</th>
                <th>produttore</th>
                <th>data acquisto</th>               
            </tr>';
        $i = 0;
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var modalel = document.getElementById("delete");
        var span = document.getElementsByClassName("close2")[0];
        document.getElementById("btn2").onclick = function deleteProducts() {
            if (document.getElementById('table').rows[0].cells.length == 6) {
                var tr = document.getElementById("title");
                tr.innerHTML = tr.innerHTML + "<th style='background-color: #1260ab;color: #fafafa;font-family: 'Open Sans', Sans-serif;font-weight: 200;text-transform: uppercase;'>CANCELLA</th>";
                var nrow = "<?php echo $i ?>";
                for (var i = 0; i < nrow; i++) {
                    var rows = document.getElementById("row" + i);
                    rows.innerHTML = rows.innerHTML + "<td> <input type='checkbox' id='" + i + "' /> </td>";
                }
                document.getElementById("btn2").innerHTML = "ELIMINA?";
                document.getElementById("btn").disabled = true;

            } else {
                modalel.style.display = "block";
                var elements = new Array();
                var count = 0;
                var countel = 0;
                $('table tr').each(function(i) {
                    var $chkbox = $(this).find('input[type="checkbox"]');
                    if ($chkbox.length) {
                        if ($chkbox.prop('checked')) {
                            elements.push($("#serial" + count).text());
                            document.getElementById(count).disabled = true;
                            countel++;
                            count++;
                        } else {
                            document.getElementById(count).disabled = true;
                            count++;
                        }
                    }
                });
                if (countel == 0) {
                    $("#choose").attr("hidden", true);
                    $("#nobtn").attr("hidden", true);
                    $("#si").attr("hidden", true);
                    $("#error").attr("hidden", false);
                } else {
                    $("#choose").attr("hidden", false);
                    $("#nobtn").attr("hidden", false);
                    $("#si").attr("hidden", false);
                    $("#error").attr("hidden", true);
                }
                document.getElementById("ele").value = elements;
            }
        }

        document.getElementById("nobtn").onclick = function() {
            deletefun();
        }

        function deletefun() {
            modalel.style.display = "none";
            var rows2 = document.getElementById('table').rows;
            for (var l = 0; l < rows2.length; l++) {
                rows2[l].deleteCell(6);
            }
            document.getElementById("btn").disabled = false;
            document.getElementById("btn2").innerHTML = "ELIMINA PRODOTTI";
        }

        span.onclick = function() {
            deletefun();
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <title>Document</title>
</head>

<body>
</body>