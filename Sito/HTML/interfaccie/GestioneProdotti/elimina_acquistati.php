<?php
require_once("../../../PHP/connect_db.php");
session_start();
$vect = explode(",", $_POST["vect"]);
$count = 0;
for ($i = 0; $i < count($vect); $i++) {
    $sql = "DELETE FROM prodotti_acquistati WHERE Seriale='" . $vect[$i] . "'";
    if ($stmt = mysqli_prepare($link, $sql)) {
        $count++;
        try {
            mysqli_stmt_execute($stmt);
        } catch (Exception $e) {
            die(mysqli_stmt_error($stmt));
        }
    } else header("Location: ../GestioneProdotti/Acquistati.php");
}
if ($count == count($vect)) {
    $sql = "INSERT INTO prodotti_venduti (Seriale,Nome,Prezzo,Quantita,DataVendita,CodAzienda) VALUES (?,?,?,?,?,?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssss", $_POST["Seriale"], $_POST["Nome"], $_POST["Prezzo"], $_POST["Quantita"], $_POST["Data"], $_SESSION["aziendaId"]);
        header("Location: ../GestioneProdotti/Acquistati.php");
        exit();
    }
} else exit();
