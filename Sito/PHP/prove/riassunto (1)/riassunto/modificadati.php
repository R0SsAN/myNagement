<?php
session_start();
require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"];
    $username = $_POST["username"];
    $psw = $_POST["psw"];

    //$sql = "UPDATE `login` SET username = $username.psw=$psw WHERE `login`.`IdUtente` = $id";
    $sql = "UPDATE `login` SET username = '".$username."',psw='".$psw."'WHERE login.IdUtente ='".$id."'";

    
    if(mysqli_query($link,$sql)){
        header("location: page.php");
    }

}
