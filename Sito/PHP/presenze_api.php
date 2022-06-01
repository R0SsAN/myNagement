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

                    $sql2 = "SELECT presente FROM `presenza` WHERE CodDipendente=" . $row["Cod"] . " AND giorno='" . date("Y-m-d") . "'";

                    if ($result2 = mysqli_query($link, $sql2)) {
                        if (mysqli_num_rows($result2) > 0) {
                            while ($row2 = mysqli_fetch_array($result2)) {
                                if ($row2["presente"] == 0) {
                                    $sql3 = "SELECT DataInizio,DataFine,Tipo FROM `assenze` WHERE CodDipendente=" . $row['Cod'] . "";
                                    if ($result3 = mysqli_query($link, $sql3)) {
                                        if (mysqli_num_rows($result3) > 0) {
                                            while ($row3 = mysqli_fetch_array($result3)) {
                                                if ($row3['DataInizio'] <= date("Y-m-d") && date("Y-m-d") <= $row3['DataFine']) {
                                                    $return .= '<td class="column3">' . '<input id="check" type="checkbox" disabled="disabled" name="checkpresenza" id="" onclick="SalvaCod(' . $row["Cod"] . ')">' . '</td>';
                                                    $return .= '<td class="column4">' . 'Fino A: ' . $row3['DataFine'] . ' per ' . $row3['Tipo'] . '</td>';
                                                    $return .= '<td class="column5">' . '<button data-bs-toggle="modal" data-bs-target="#myModal" onclick="AggiornaButton(true,' . $row["Cod"] . ')">Modifica Assenza</button>' . '</td>';
                                                } else if (date("Y-m-d") > $row3['DataFine']) {
                                                    $return .= '<td class="column3">' . '<input  id="check" type="checkbox" name="checkpresenza" id="" onclick="SalvaCod(' . $row["Cod"] . ')">' . '</td>';
                                                    $return .= '<td class="column4">' . '/' . '</td>';
                                                    $return .= '<td class="column5">' . '<button data-bs-toggle="modal" data-bs-target="#myModal" onclick="AggiornaButton(false,' . $row["Cod"] . ')">Aggiungi Assenza</button>' . '</td>';
                                                } else if (date("Y-m-d") < $row3['DataInizio']) {
                                                    $return .= '<td class="column3">' . '<input id="check" type="checkbox" name="checkpresenza" id="" onclick="SalvaCod(' . $row["Cod"] . ')">' . '</td>';
                                                    $return .= '<td class="column4">' . 'Assente dal:' . $row3['DataInizio'] . 'Fino A: ' . $row3['DataFine'] . ' per ' . $row3['Tipo'] . '</td>';
                                                    $return .= '<td class="column5">' . '<button data-bs-toggle="modal" data-bs-target="#myModal" onclick="AggiornaButton(true,' . $row["Cod"] . ')">Modifica Assenza</button>' . '</td>';
                                                }
                                            }
                                        } else {
                                            $return .= '<td class="column3">' . '<input id="check" type="checkbox" name="checkpresenza" id="" onclick="SalvaCod(' . $row["Cod"] . ')">' . '</td>';
                                            $return .= '<td class="column4">' . '/' . '</td>';
                                            $return .= '<td class="column5">' . '<button data-bs-toggle="modal" data-bs-target="#myModal" onclick="AggiornaButton(false,' . $row["Cod"] . ')">Aggiungi Assenza</button>' . '</td>';
                                        }
                                    }
                                } else if ($row2["presente"] == 1) {
                                    $sql3 = "SELECT DataInizio,DataFine,Tipo FROM `assenze` WHERE CodDipendente=" . $row['Cod'] . "";
                                    if ($result3 = mysqli_query($link, $sql3)) {
                                        if (mysqli_num_rows($result3) > 0) {
                                            while ($row3 = mysqli_fetch_array($result3)) {
                                                if ($row3['DataInizio'] <= date("Y-m-d") && date("Y-m-d") <= $row3['DataFine']) {
                                                    $return .= '<td class="column3">' . '<input id="check" checked type="checkbox" disabled="disabled" name="checkpresenza" id="" onclick="SalvaCod(' . $row["Cod"] . ')">' . '</td>';
                                                    $return .= '<td class="column4">' . 'Fino A: ' . $row3['DataFine'] . ' per ' . $row3['Tipo'] . '</td>';
                                                    $return .= '<td class="column5">' . '<button data-bs-toggle="modal" data-bs-target="#myModal" onclick="AggiornaButton(true,' . $row["Cod"] . ')">Modifica Assenza</button>' . '</td>';
                                                } else if (date("Y-m-d") > $row3['DataFine']) {
                                                    $return .= '<td class="column3">' . '<input  id="check" checked type="checkbox" name="checkpresenza" id="" onclick="SalvaCod(' . $row["Cod"] . ')">' . '</td>';
                                                    $return .= '<td class="column4">' . '/' . '</td>';
                                                    $return .= '<td class="column5">' . '<button data-bs-toggle="modal" data-bs-target="#myModal" onclick="AggiornaButton(false,' . $row["Cod"] . ')">Aggiungi Assenza</button>' . '</td>';
                                                } else if (date("Y-m-d") < $row3['DataInizio']) {
                                                    $return .= '<td class="column3">' . '<input id="check" checked type="checkbox" name="checkpresenza" id="" onclick="SalvaCod(' . $row["Cod"] . ')">' . '</td>';
                                                    $return .= '<td class="column4">' . 'Assente dal:' . $row3['DataInizio'] . 'Fino A: ' . $row3['DataFine'] . ' per ' . $row3['Tipo'] . '</td>';
                                                    $return .= '<td class="column5">' . '<button data-bs-toggle="modal" data-bs-target="#myModal" onclick="AggiornaButton(true,' . $row["Cod"] . ')">Modifica Assenza</button>' . '</td>';
                                                }
                                            }
                                        } else {
                                            $return .= '<td class="column3">' . '<input id="check" checked type="checkbox" name="checkpresenza" id="" onclick="SalvaCod(' . $row["Cod"] . ')">' . '</td>';
                                            $return .= '<td class="column4">' . '/' . '</td>';
                                            $return .= '<td class="column5">' . '<button data-bs-toggle="modal" data-bs-target="#myModal" onclick="AggiornaButton(false,' . $row["Cod"] . ')">Aggiungi Assenza</button>' . '</td>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $return .= '</tr>';

                die($return);
                mysqli_free_result($result);
            }
            mysqli_close($link);
        }
    }
}

if (isset($_POST["aggiorna"]) && isset($_POST["CodDipendente"])) {
    if ($_POST["aggiorna"] == true) {
        $dipendente = $_POST["CodDipendente"];
        $sql = "SELECT * FROM `presenza` WHERE CodDipendente=$dipendente AND giorno='" . date("Y-m-d") . "'";
        if ($result = mysqli_query($link, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                $return = "";
                while ($row = mysqli_fetch_array($result)) {
                    if ($row['presente'] == 0) {
                        $sql2 = "UPDATE `presenza` SET `presente`=1 WHERE CodDipendente=$dipendente AND giorno='" . date("Y-m-d") . "'";
                        if (mysqli_query($link, $sql2)) {
                            mysqli_close($link);
                        }
                    } else {
                        $sql2 = "UPDATE `presenza` SET `presente`=0 WHERE CodDipendente=$dipendente AND giorno='" . date("Y-m-d") . "'";
                        if (mysqli_query($link, $sql2)) {
                            mysqli_close($link);
                        }
                    }
                }
            }
            mysqli_close($link);
        }
    }
}

if (isset($_POST["aggiornapresenza"]) && isset($_POST["tipomalattia"]) && isset($_POST["datainizio"]) && isset($_POST["datafine"]) && isset($_POST["percstipendio"]) && isset($_POST["idutente"])) {
    if ($_POST["aggiornapresenza"] == "Aggiungi") {
        $sql = "INSERT INTO `assenze` (`CodDipendente`, `DataInizio`, `DataFine`, `Tipo`,`PercentualeStipendio`) VALUES ('" . $_POST["idutente"] . "', '" . $_POST["datainizio"] . "', '" . $_POST["datafine"] . "', '" . $_POST["tipomalattia"] . "', "  . $_POST["percstipendio"] . ")";
    } else {
        $sql = "UPDATE `assenze` SET DataInizio ='" . $_POST["datainizio"] . "',DataFine ='" . $_POST["datafine"] . "',Tipo='" . $_POST["tipomalattia"] . "', `PercentualeStipendio` = '" . $_POST["percstipendio"] . "' WHERE `assenze`.`CodDipendente` = '" . $_POST["idutente"] . "'";
    }
    if ($result = mysqli_query($link, $sql)) {
      
        mysqli_close($link);
    }
    if($_POST['datainizio']>=date("Y-m-d")){
        $sql = "UPDATE `presenza` SET `presente` = '0' WHERE `presenza`.`CodDipendente` = '" . $_POST["idutente"] . "'";
        $result = mysqli_query($link, $sql);
    }
   
}
