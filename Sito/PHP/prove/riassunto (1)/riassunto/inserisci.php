<?php
session_start();
require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
    $username = $_POST["username"];
    $psw = $_POST["psw"];
    
    //inserire dal database e copiare la query mettendo i punti di domanda al posto dei VALUES 
    $sql = "INSERT INTO `login` (`IdUtente`, `username`, `psw`) VALUES (?,?,?);";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "iss",  $id, $username, MD5($psw)); //intercambiare iss con i tipi desiderati
        if (mysqli_stmt_execute($stmt)) {
            header("location: inserisci.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($stmt);
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
        <label for="">Id</label>
        <input type="text" name="id">
        <br>
        <br>

        <label for="">username</label>
        <input type="text" name="username">
        <br>
        <br>

        <label for="">psw</label>
        <input type="text" name="psw">
        <br>
        <br>
        
        <input type="submit" value="Inserisci">
    </form>
    <br>
    <a href="page.php"><button>Back</button></a>
</body>

</html>