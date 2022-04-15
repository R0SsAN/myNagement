<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
require_once "connect_db.php";
session_start();

// -Nome dipendente -Contratto dipendente -Ore totali -stipendio -Giorni cassa integrazione -Giorni malattia -Giorni ferie -Giorni maternita 

if (isset($_POST["mese"])) {
    $query = "SELECT dipendenti.Cod,dipendenti.Nome,contratti.DataFine, (COUNT(presenza.presente)*contratti.OreLavorative) AS ore FROM dipendenti INNER JOIN contratti ON dipendenti.Cod=contratti.CodDipendente INNER JOIN presenza ON dipendenti.Cod=presenza.CodDipendente WHERE MONTH(presenza.giorno)=" . $_POST['mese'] . " AND YEAR(presenza.giorno)=" . $_POST['year'] . " AND presenza.presente=1 GROUP BY dipendenti.Cod";
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


            $sommaTotaleStipendi = 0;
            $numeroDipendenti = 0;
            //prendo il numero di dipendenti dell'azienda per poi fare il ciclo for
            $stip = "SELECT dipendenti.Cod AS cod FROM dipendenti WHERE dipendenti.CodAzienda=" . $_SESSION["aziendaId"] . "";
            if (!$resstip = $link->query($stip))
                die("Errore esecuzione query 1");
            $numeroDipendenti = mysqli_num_rows($resstip);


            $sommaStipendioDipendente = 0;

            //mi salvo lo stipendio del dipendente e il numero di ore giornaliere
            $stip = "SELECT contratti.Salario AS salario , contratti.OreLavorative AS ore FROM contratti WHERE contratti.CodDipendente=" . $row["Cod"] . "";
            if (!$resstip2 = $link->query($stip))
                die("Errore esecuzione query 2");
            $temp = mysqli_fetch_array($resstip2);
            $salarioDipendente = $temp["salario"];
            $oreLavorative = $temp["ore"];
            //ora si prendono tutte le presenze di quel mese e si calcola lo stipendio in base a quello
            $stip = "SELECT presenza.presente AS presente FROM presenza WHERE CodDipendente=" . $row["Cod"] . " AND year(presenza.giorno)=" . $_POST["year"] . " AND month(presenza.giorno)=" . $_POST["mese"] . "";
            if (!$resstip2 = $link->query($stip))
                die("Errore esecuzione query 3");
            while ($rowstip2 = mysqli_fetch_array($resstip2)) {
                //se il dipendente è presente allora aggiungo il suo stipendio alla somma di tutti gli stipendi
                if ($rowstip2["presente"] == 1)
                    $sommaStipendioDipendente = $sommaStipendioDipendente + $salarioDipendente;
            }


            //dopo aver sommato tutte le presenze si va nella tabella assenze e si sommano tutti gli stipendi calcolati con la percentuale
            //per prima cosa prendo tutte le assenze che hanno datainizio o datafine nel mese corretto == hanno qualche assenza in questo mese
            $stip = "SELECT * FROM assenze WHERE assenze.CodDipendente=" . $row["Cod"] . " AND ((month(assenze.DataInizio)=" . $_POST["mese"] . " AND year(assenze.DataInizio)=" . $_POST["year"] . ") OR (month(assenze.DataFIne)=" . $_POST["mese"] . " AND year(assenze.DataFine)=" . $_POST["year"] . "))";
            if (!$resstip2 = $link->query($stip))
                die("Errore esecuzione query 4");
            while ($rowstip2 = mysqli_fetch_array($resstip2)) {

                $numeroGiorniAssenza = 0;
                //ora per ogni assenza relativa a questo mese calcolo i giorni di assenza per poi poter calcolare lo stipendio

                //se sia datainizio che datfine sono all'interno del mese giusto allora mi basta calcolare la differenza di giorni
                if (date("m", strtotime($rowstip2["DataInizio"])) == date("m", strtotime($rowstip2["DataFine"]))) {
                    $date1 = new DateTime($rowstip2["DataInizio"]);
                    $date2 = new DateTime($rowstip2["DataFine"]);
                    $numeroGiorniAssenza = $date2->diff($date1)->format('%a');
                }
                //se invece datainizio è nel mese giusto ma datafine no allora prendo il numero di giorni da datainizio alla fine del mese
                else if (date("m", strtotime($rowstip2["DataInizio"])) == $_POST["mese"] && date("m", strtotime($rowstip2["DataFine"])) != $_POST["mese"]) {
                    $numeroGiorniAssenza = cal_days_in_month(CAL_GREGORIAN, $_POST["mese"], $_POST["year"]) - date("d", strtotime($rowstip2["DataInizio"]));
                }
                //se invece datafine è nel mese giusto ma datainizio no allora prendo il numero di giorni dall'inizio del mese a datafine
                else if (date("m", strtotime($rowstip2["DataInizio"])) != $_POST["mese"] && date("m", strtotime($rowstip2["DataFine"])) == $_POST["mese"]) {
                    $numeroGiorniAssenza = date("d", strtotime($rowstip2["DataFine"]));
                }
                $sommaStipendioDipendente = $sommaStipendioDipendente + (($salarioDipendente / 100) * $rowstip2["PercentualeStipendio"]) * $numeroGiorniAssenza;
            }
            //alla fine sommo lo stipendio relativo al dipendente corrente alla somma di tutti gli stipendi
            $sommaTotaleStipendi = $sommaTotaleStipendi + $sommaStipendioDipendente;


            $res .= "<td>" . strval($sommaTotaleStipendi) . "</td>";
            $dataM =  mysqli_fetch_array($link->query("SELECT MONTH(assenze.DataFine) AS fine ,MONTH(assenze.DataInizio) AS inizio, DAY(assenze.DataInizio) AS iniziod FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Malattia' AND assenze.CodDipendente=" . $row["Cod"] . " AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " GROUP BY assenze.CodDipendente"));
            $dataC =  mysqli_fetch_array($link->query("SELECT MONTH(assenze.DataFine) AS fine ,MONTH(assenze.DataInizio) AS inizio, DAY(assenze.DataInizio) AS iniziod FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Cassa integrazione' AND assenze.CodDipendente=" . $row["Cod"] . " AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " GROUP BY assenze.CodDipendente"));
            $dataF =  mysqli_fetch_array($link->query("SELECT MONTH(assenze.DataFine) AS fine ,MONTH(assenze.DataInizio) AS inizio, DAY(assenze.DataInizio) AS iniziod FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Ferie' AND assenze.CodDipendente=" . $row["Cod"] . " AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " GROUP BY assenze.CodDipendente"));
            $dataMa =  mysqli_fetch_array($link->query("SELECT MONTH(assenze.DataFine) AS fine ,MONTH(assenze.DataInizio) AS inizio, DAY(assenze.DataInizio) AS iniziod FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Maternita' AND assenze.CodDipendente=" . $row["Cod"] . " AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " GROUP BY assenze.CodDipendente"));
            if (intval($dataM["fine"]) > intval($dataM["inizio"])) {
                $queryCassa = "SELECT (DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Cassa integrazione' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                $queryFerie = "SELECT (DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Ferie' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                $queryMat = "SELECT COUNT(DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Maternita' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                $resultCassa = mysqli_fetch_array($link->query($queryCassa));
                $resultFerie = mysqli_fetch_array($link->query($queryFerie));
                $resultMat = mysqli_fetch_array($link->query($queryMat));
                //print("<pre>".print_r($row2,true)."</pre>");
                if ($resultCassa["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultCassa["malattia"]  . "</td>";
                $res .= "<td>" . (cal_days_in_month(CAL_GREGORIAN, $_POST["mese"], $_POST["year"]) - intval($dataM["iniziod"]))  . "</td>";
                if ($resultFerie["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultFerie["malattia"] . "</td>";
                if ($resultMat["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultMat["malattia"] . "</td>";
            } else if (intval($dataC["fine"]) > intval($dataC["inizio"])) {
                $res .= "<td>" . (cal_days_in_month(CAL_GREGORIAN, $_POST["mese"], $_POST["year"]) - intval($dataC["iniziod"]))  . "</td>";
                $queryMalattia = "SELECT (DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Malattia' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                $queryFerie = "SELECT (DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Ferie' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                $queryMat = "SELECT COUNT(DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Maternita' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                $resultMalattia = mysqli_fetch_array($link->query($queryMalattia));
                $resultFerie = mysqli_fetch_array($link->query($queryFerie));
                $resultMat = mysqli_fetch_array($link->query($queryMat));
                //print("<pre>".print_r($row2,true)."</pre>");
                if ($resultMalattia["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultMalattia["malattia"] . "</td>";
                if ($resultFerie["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultFerie["malattia"] . "</td>";
                if ($resultMat["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultMat["malattia"] . "</td>";
            } else if (intval($dataF["fine"]) > intval($dataF["inizio"])) {
                $queryMalattia = "SELECT (DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Malattia' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                $queryCassa = "SELECT (DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Cassa integrazione' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                $queryMat = "SELECT COUNT(DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Maternita' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                $resultMalattia = mysqli_fetch_array($link->query($queryMalattia));
                $resultCassa = mysqli_fetch_array($link->query($queryCassa));
                $resultMat = mysqli_fetch_array($link->query($queryMat));
                //print("<pre>".print_r($row2,true)."</pre>");
                if ($resultCassa["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultCassa["malattia"]  . "</td>";
                if ($resultMalattia["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultMalattia["malattia"] . "</td>";
                $res .= "<td>" . (cal_days_in_month(CAL_GREGORIAN, $_POST["mese"], $_POST["year"]) - intval($dataF["iniziod"]))  . "</td>";
                if ($resultMat["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultMat["malattia"] . "</td>";
            } else if (intval($dataMa["fine"]) > intval($dataMa["inizio"])) {
                $queryMalattia = "SELECT (DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Malattia' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                $queryCassa = "SELECT (DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Cassa integrazione' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                $queryFerie = "SELECT (DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Ferie' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                $resultMalattia = mysqli_fetch_array($link->query($queryMalattia));
                $resultCassa = mysqli_fetch_array($link->query($queryCassa));
                $resultFerie = mysqli_fetch_array($link->query($queryFerie));
                //print("<pre>".print_r($row2,true)."</pre>");
                if ($resultCassa["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultCassa["malattia"]  . "</td>";
                if ($resultMalattia["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultMalattia["malattia"] . "</td>";
                if ($resultFerie["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultFerie["malattia"] . "</td>";
                $res .= "<td>" . (cal_days_in_month(CAL_GREGORIAN, $_POST["mese"], $_POST["year"]) - intval($dataMa["iniziod"]))  . "</td>";
            } else {
                $queryMalattia = "SELECT dipendenti.Nome,(DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Malattia' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY dipendenti.Nome";
                $queryCassa = "SELECT dipendenti.Nome,(DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Cassa integrazione' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY dipendenti.Nome";
                $queryFerie = "SELECT dipendenti.Nome,(DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Ferie' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY dipendenti.Nome";
                $queryMat = "SELECT dipendenti.Nome,(DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS malattia FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Maternita' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY dipendenti.Nome";
                $resultMalattia = mysqli_fetch_array($link->query($queryMalattia));
                $resultCassa = mysqli_fetch_array($link->query($queryCassa));
                $resultFerie = mysqli_fetch_array($link->query($queryFerie));
                $resultMat = mysqli_fetch_array($link->query($queryMat));
                //print("<pre>" . print_r($queryFerie, true) . "</pre>");
                if ($resultCassa["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultCassa["malattia"]  . "</td>";
                if ($resultMalattia["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultMalattia["malattia"] . "</td>";
                if ($resultFerie["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultFerie["malattia"] . "</td>";
                if ($resultMat["malattia"] == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultMat["malattia"] . "</td>";
            }
            $res .= "<td><button class='buttonanagrafica'>grafico</button></td>";
            $res .= "</tr>";
        }
        die($res);
    } else
        die(mysqli_error($link));
} else
    die("Errore");
?>



