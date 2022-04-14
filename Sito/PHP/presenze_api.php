<?php
require_once "connect_db.php";
session_start();
if (!isset($_SESSION["userId"]))
    die("Error");

if (isset($_POST["genera"])) {
    if ($_POST["genera"] == true) {
        $sql = "SELECT Nome,Cognome,Cod FROM `dipendenti` WHERE CodAzienda=" . $_SESSION['aziendaId'];
        if ($result = mysqli_query($link, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $return = "";
                while ($row = mysqli_fetch_array($result)) {
                    $return .= '<tr>';
                    $return .= '<td class="column1">' . $row["Nome"] . '</td>';
                    $return .= '<td class="column2">' . $row['Cognome'] . '</td>';
                    $return .= '<td class="column3">' . '<input type="checkbox" name="checkpresenza" id="" onclick="AggiornaPresenza('.$row["Cod"].')">' . '</td>';
                    $sql2 = "SELECT DataInizio,DataFine,Tipo FROM `assenze` WHERE CodDipendente=" . $row['Cod'] . "";
                    if ($result2 = mysqli_query($link, $sql2)) {
                        if (mysqli_num_rows($result2) > 0) {
                            while ($row2 = mysqli_fetch_array($result2)) {
                                if ($row2['DataInizio'] <= date("Y-m-d") && date("Y-m-d") <= $row2['DataFine']) {
                                    $return .= '<td class="column4">' . 'Fino A: ' . $row2['DataFine'] . ' per: ' . $row2['Tipo'] . '</td>';
                                } else {
                                    $return .= '<td class="column4">' . '/' . '</td>';
                                }
                            }
                        } else if (mysqli_num_rows($result2) == 0) {
                            $return .= '<td class="column4">' . '/' . '</td>';
                        }
                        $return .= '<td class="column5">' . '<button onclick="console.log(0);">Aggiungi Assenza</button>' . '</td>';
                    }
                }

               
                $return .= '</tr>';

                die($return);
                // Free result set
                mysqli_free_result($result);
            }
            // Close connection
            mysqli_close($link);
        }
    }
}
