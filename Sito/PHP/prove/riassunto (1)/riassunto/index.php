<?php
session_start();
require_once "config.php";


if (!empty($_POST['nome']) && !empty($_POST['psw'])) {
    $sql = "SELECT * FROM `login` WHERE username ='" . $_POST["nome"] . "' AND psw= '" . md5($_POST["psw"]) . "'";
    if ($result = mysqli_query($link, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            header("location: page.php");
        } else {
            header("location: index.php");
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
        <label for="">Utente</label>
        <input type="text" name="nome" id="nome">
        <br>
        <br>
        <label for="">Password</label>
        <input type="text" name="psw" id="psw">
        <br>
        <br>
        <input type="submit" value="Login">
    </form>
</body>
</html>