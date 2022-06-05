<?php
session_start();
if (!isset($_SESSION["userId"]))
    header("Location: ../../../../login.php");
require_once '../../../PHP/connect_db.php';
$sql = "SELECT * FROM prodotti_venduti WHERE CodAzienda='" . $_SESSION['aziendaId'] . "'";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo '  
        <div class="content2">      
        <table>
            <tr>
                <th>seriale</th>
                <th>nome</th>
                <th>prezzo</th>
                <th>quantità</th>
                <th>data vendita</th>               
            </tr>
            ';
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['Seriale'] . "</td>";
            echo "<td>" . $row['Nome'] . "</td>";
            echo "<td>" . $row['Prezzo'] . " $" . "</td>";
            echo "<td>" . $row['Quantita'] . "</td>";
            echo "<td>" . $row['DataVendita'] . "</td>";
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