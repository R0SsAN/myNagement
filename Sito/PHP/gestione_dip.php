<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
require_once "connect_db.php";
session_start();

// -Nome dipendente -Contratto dipendente -Ore totali -stipendio -Giorni cassa integrazione -Giorni malattia -Giorni ferie -Giorni maternita 

if (isset($_POST["mese"])) {
    $query = "SELECT dipendenti.Nome,contratti.DataFine, (COUNT(presenza.presente)*contratti.OreLavorative) AS ore FROM dipendenti INNER JOIN contratti ON dipendenti.Cod=contratti.CodDipendente INNER JOIN presenza ON dipendenti.Cod=presenza.CodDipendente WHERE MONTH(presenza.giorno)=" . $_POST['mese'] . " AND YEAR(presenza.giorno)=" . $_POST['year'] . " AND presenza.presente=1 GROUP BY dipendenti.Cod";
    if ($result = $link->query($query)) {
        //$cod = mysqli_fetch_array($result)["Cod"];
        $res = "";
        while ($row = mysqli_fetch_array($result)) {
            $res .= "<tr>";
            $res .= "<td>" . $row["Nome"] . "</td>";
            if ($row["DataFine"] != NULL)
                $res .= "<td>" . "Determinato" . "</td>";
            else
                $res .= "<td>" . "Indeterminato" . "</td>";
            $res .= "<td>" . $row["ore"] . "</td>";
            $query2 = "SELECT dipendenti.Nome, (DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS assenze, assenze.Tipo FROM dipendenti INNER JOIN assenze ON dipendenti.Cod = assenze.CodDipendente INNER JOIN presenza ON presenza.CodDipendente=dipendenti.Cod WHERE MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND dipendenti.Nome='" . $row["Nome"] . "'";
            $result2 = $link->query($query2);
            $res .= "<td>" . "€" . "</td>";
            $row2 = mysqli_fetch_array($result2);
            //print("<pre>".print_r($row2,true)."</pre>");
            if ($row2["Tipo"] == "Malattia") {
                $res .= "<td>" . "0" . "</td>";
                $res .= "<td>" . $row2["assenze"] . "</td>";
                $res .= "<td>" . "0" . "</td>";
                $res .= "<td>" . "0" . "</td>";
                $res .= "<td><button class='buttonanagrafica'>grafico</button></td>";
                $res .= "</tr>";
            } else if ($row2["Tipo"] == "Cassa Integrazione") {
                $res .= "<td>" . $row2["assenze"] . "</td>";
                $res .= "<td>" . "0" . "</td>";
                $res .= "<td>" . "0" . "</td>";
                $res .= "<td>" . "0" . "</td>";
                $res .= "<td><button class='buttonanagrafica'>grafico</button></td>";
                $res .= "</tr>";
            } else if ($row2["Tipo"] == "Ferie") {
                $res .= "<td>" . "0" . "</td>";
                $res .= "<td>" . "0" . "</td>";
                $res .= "<td>" . $row2["assenze"] . "</td>";
                $res .= "<td>" . "0" . "</td>";
                $res .= "<td><button class='buttonanagrafica'>grafico</button></td>";
                $res .= "</tr>";
            } else if ($row2["Tipo"] == "Maternita") {
                $res .= "<td>" . "0" . "</td>";
                $res .= "<td>" . "0" . "</td>";
                $res .= "<td>" . "0" . "</td>";
                $res .= "<td>" . $row2["assenze"] . "</td>";
                $res .= "<td><button class='buttonanagrafica'>grafico</button></td>";
                $res .= "</tr>";
            } else {
                $res .= "<td>" . "assente" . "</td>";
                $res .= "<td>" . "assente" . "</td>";
                $res .= "<td>" . "assente" . "</td>";
                $res .= "<td>" . "assente" . "</td>";
                $res .= "<td><button class='buttonanagrafica'>grafico</button></td>";
                $res .= "</tr>";
            }
        }
        die($res);
    } else
        die(mysqli_error($link));
} else
    die("Errore");
?>