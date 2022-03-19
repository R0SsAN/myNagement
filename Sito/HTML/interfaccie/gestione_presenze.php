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
                require_once "../../PHP/conncet_db.php";
                // Attempt select query execution
                $sql = "SELECT * FROM dipendenti";
                if ($result = mysqli_query($link, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table>";
                        echo "<tr>";
                        echo " <th>nome</th>";
                        echo " <th>cognome</th>";
                        echo " <th>presente</th>";
                        echo "  <th>ferie</th>";
                        echo "  <th>malattia</th>";
                        echo "   <th>cassa integrazione</th>";
                        echo " </tr>";
                        echo "<tbody>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['nome'] . "</td>";
                            echo "<td>" . $row['cognome'] . "</td>";
                            echo "<td>" . $row['presente'] . "</td>";
                            echo "<td>" . $row['ferie'] . "</td>";
                            echo "<td>" . $row['malattia'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
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