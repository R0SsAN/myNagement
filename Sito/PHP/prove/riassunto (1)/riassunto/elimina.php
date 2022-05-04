<?php
session_start();
require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
   
    $sql = "DELETE FROM `login` WHERE `login`.`IdUtente` = $id";
    if(mysqli_query($link,$sql)){
        header("location: page.php");
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

        <label for="">Inserire Id dell'utente da eliminare</label>
        <input type="text" name="id">
        <input type="submit" value="Inserisci">
    </form>
</body>

</html>