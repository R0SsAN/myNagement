<?php
session_start();
require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["nome"];
   
    $sql = "SELECT * FROM login WHERE username='".$id."'";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>#</th>";
            echo "<th>Username</th>";
            echo "<th>Password</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['IdUtente'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['psw'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            // Free result set
            mysqli_free_result($result);
        } 
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

        <label for="">Inserire Id dell'utente da cercare</label>
        <input type="text" name="nome">
        <input type="submit" value="Inserisci">
    </form>
</body>

</html>