<?php
session_start();
require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
    $sql = "SELECT * FROM login WHERE IdUtente='" . $id . "'";
    if ($result = mysqli_query($link, $sql)) {

        $row = mysqli_fetch_array($result);

        $id = $row['IdUtente'];
        $username = $row['username'];
        $psw = $row['psw'];
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
    <form action="modificadati.php" method="POST">
        <label>ID</label>
        <input type="text" name="id"value="<?php echo $id; ?>">
        <br>
        <br>
        <label>username</label>
        <input type="text" name="username" value="<?php echo $username; ?>">
        <br>
        <br>
        <label>psw</label>
        <input type="text" name="psw" value="<?php echo $psw; ?>">
        <br>
        <br>
        <input type="submit" value="Modifica">
    </form>


</body>

</html>