<?php

require_once("../../../PHP/connect_db.php");
session_start();
if (!empty($_POST["Seriale"]) && !empty($_POST["Nome"]) && !empty($_POST["Prezzo"]) && !empty($_POST["Quantita"])) {
    $sql = "INSERT INTO prodotti_da_vendere (Seriale,Nome,Prezzo,Quantita,CodAzienda) VALUES (?,?,?,?,?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        $s = 0;
        mysqli_stmt_bind_param($stmt, "sssss", $_POST["Seriale"], $_POST["Nome"], $_POST["Prezzo"], $_POST["Quantita"], $_SESSION["IDazienda"]);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../GestioneProdotti/Vendita.php");
            exit();
        } else {
            echo mysqli_stmt_error($stmt);
        }
    } else  header("Location: ../GestioneProdotti/Vendita.php");
} else  header("Location: ../GestioneProdotti/Vendita.php");
