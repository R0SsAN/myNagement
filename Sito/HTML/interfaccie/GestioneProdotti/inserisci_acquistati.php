<?php

require_once("../../../PHP/connect_db.php");
session_start();
if (!empty($_POST["Seriale"]) && !empty($_POST["Nome"]) && !empty($_POST["Prezzo"]) && !empty($_POST["Quantita"]) && !empty($_POST["Produttore"]) && !empty($_POST["Data"])) {
    $sql = "INSERT INTO prodotti_acquistati (Seriale,Nome,Prezzo,Quantita,Produttore,DataAcquisto,CodAzienda) VALUES (?,?,?,?,?,?,?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssss", $_POST["Seriale"], $_POST["Nome"], $_POST["Prezzo"], $_POST["Quantita"], $_POST["Produttore"], $_POST["Data"],$_SESSION["IDazienda"]);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../GestioneProdotti/Acquistati.php");
            exit();
        } else {
            echo mysqli_stmt_error($stmt);
        }            
    } else  header("Location: ../GestioneProdotti/Acquistati.php");
} else  header("Location: ../GestioneProdotti/Acquistati.php");
