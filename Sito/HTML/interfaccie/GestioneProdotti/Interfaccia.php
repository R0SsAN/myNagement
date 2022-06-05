<?php
  session_start();
  if(!isset($_SESSION["userId"]))
    header("Location: login.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../CSS/GestioneProdotti_style.css">
    <title>Gestione prodotti</title>
</head>

<body>
    <div class="content" style="display: flex; flex-wrap: nowrap; flex-direction: row; justify-content: space-between;">
        <a href="Acquistati.php">
            <button class="buttonanagraficaBig" value="PRODOTTI ACQUISTATI">PRODOTTI<br>ACQUISTATI</button>
        </a>
        <a href="Storico.php">
             <button class="buttonanagraficaBig" value="PRODOTTI ACQUISTATI">STORICO<br>VENDITE</button>
        </a>
        <a href="Vendita.php">
            <button class="buttonanagraficaBig" value="PRODOTTI ACQUISTATI">IN VENDITA</button>
        </a>
    </div>
</body>

</html>