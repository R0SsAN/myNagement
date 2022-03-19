<?php
require_once '../../PHP/connect_db.php';

// Attempt select query execution
$sql = "SELECT * FROM attori";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo '
    <div class="content">
        <table>
            <tr>
                <th>seriale</th>
                <th>nome</th>
                <th>produttore</th>
                <th>quantità</th>
                <th>prezzo</th>             

            </tr>
            ';
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['Cod'] . "</td>";
            echo "<td>" . $row['Cod'] . "</td>";
            echo "<td>" . $row['Cod'] . "</td>";
            echo "<td>" . $row['Cod'] . "</td>";
            echo "<td>" . $row['Cod'] . "$" . "</td>";
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
    <link rel="stylesheet" href="../../../CSS/prodotti_style.css">
    <title>Document</title>
</head>

<body>
</body>

</html>