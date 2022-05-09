<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
require_once "connect_db.php";
session_start();

// -Nome dipendente -Contratto dipendente -Ore totali -stipendio -Giorni cassa integrazione -Giorni malattia -Giorni ferie -Giorni maternita 

if (isset($_POST["mese"])) {
    $query = "SELECT dipendenti.Cod,dipendenti.Nome,contratti.DataFine, (COUNT(presenza.presente)*contratti.OreLavorative) AS ore FROM dipendenti INNER JOIN contratti ON dipendenti.Cod=contratti.CodDipendente INNER JOIN presenza ON dipendenti.Cod=presenza.CodDipendente WHERE MONTH(presenza.giorno)=" . $_POST['mese'] . " AND YEAR(presenza.giorno)=" . $_POST['year'] . " GROUP BY dipendenti.Cod";
    if ($result = $link->query($query)) {
        //$cod = mysqli_fetch_array($result)["Cod"];        
        $res = "";
        while ($row = mysqli_fetch_array($result)) {
            $param = $row["Cod"];
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
            //$dataM =  mysqli_fetch_array();


            $ress = $link->query("SELECT MONTH(assenze.DataFine) AS fine ,MONTH(assenze.DataInizio) AS inizio, DAY(assenze.DataInizio) AS iniziod FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Malattia' AND assenze.CodDipendente=" . $row["Cod"] . " AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " GROUP BY assenze.CodDipendente");
            if (mysqli_num_rows($ress) > 0) {
                $dataM =  mysqli_fetch_array($ress);
            } else {
                $dataM["fine"] = "0";
                $dataM["inizio"] = "0";
            }

            $ress =  $link->query("SELECT MONTH(assenze.DataFine) AS fine ,MONTH(assenze.DataInizio) AS inizio, DAY(assenze.DataInizio) AS iniziod FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Cassa integrazione' AND assenze.CodDipendente=" . $row["Cod"] . " AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " GROUP BY assenze.CodDipendente");
            if (mysqli_num_rows($ress) > 0) {
                $dataC =  mysqli_fetch_array($ress);
            } else {
                $dataC["fine"] = "0";
                $dataC["inizio"] = "0";
            }

            $ress =  $link->query("SELECT MONTH(assenze.DataFine) AS fine ,MONTH(assenze.DataInizio) AS inizio, DAY(assenze.DataInizio) AS iniziod FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Ferie' AND assenze.CodDipendente=" . $row["Cod"] . " AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " GROUP BY assenze.CodDipendente");

            if (mysqli_num_rows($ress) > 0) {
                $dataF =  mysqli_fetch_array($ress);
            } else {
                $dataF["fine"] = "0";
                $dataF["inizio"] = "0";
            }

            $ress =  $link->query("SELECT MONTH(assenze.DataFine) AS fine ,MONTH(assenze.DataInizio) AS inizio, DAY(assenze.DataInizio) AS iniziod FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Maternita' AND assenze.CodDipendente=" . $row["Cod"] . " AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " GROUP BY assenze.CodDipendente");

            if (mysqli_num_rows($ress) > 0) {
                $dataMa =  mysqli_fetch_array($ress);
            } else {
                $dataMa["fine"] = "0";
                $dataMa["inizio"] = "0";
            }

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
            } else if ((intval($dataM["inizio"]) < intval($dataM["fine"])) || (intval($dataC["inizio"]) < intval($dataC["fine"])) || (intval($dataF["inizio"]) < intval($dataF["fine"])) || (intval($dataMa["inizio"]) < intval($dataMa["fine"]))) {
                if (intval($dataM["inizio"]) < intval($dataM["fine"])) {
                    $q = "SELECT DAY(assenze.DataInizio) AS d FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Malattia' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                    $r = mysqli_fetch_array($link->query($queryCassa));
                    $res .= "<td>" . $r["d"]  . "</td>";
                } else {
                    $q = "SELECT (DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS d FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Malattia' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                    $r = mysqli_fetch_array($link->query($queryCassa));
                    $res .= "<td>" . $r["d"]  . "</td>";
                }
                if (intval($dataC["inizio"]) < intval($dataC["fine"])) {
                    $q = "SELECT DAY(assenze.DataInizio) AS d FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Cassa integrazione' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                    $r = mysqli_fetch_array($link->query($queryCassa));
                    $res .= "<td>" . $r["d"]  . "</td>";
                } else {
                    $q = "SELECT (DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS d FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Cassa integrazione' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                    $r = mysqli_fetch_array($link->query($queryCassa));
                    $res .= "<td>" . $r["d"]  . "</td>";
                }
                if (intval($dataF["inizio"]) < intval($dataF["fine"])) {
                    $q = "SELECT DAY(assenze.DataInizio) AS d FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Ferie' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                    $r = mysqli_fetch_array($link->query($queryCassa));
                    $res .= "<td>" . $r["d"]  . "</td>";
                } else {
                    $q = "SELECT (DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS d FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Ferie' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                    $r = mysqli_fetch_array($link->query($queryCassa));
                    $res .= "<td>" . $r["d"]  . "</td>";
                }
                if (intval($dataMa["inizio"]) < intval($dataMa["fine"])) {
                    $q = "SELECT DAY(assenze.DataInizio) AS d FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Maternita' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                    $r = mysqli_fetch_array($link->query($queryCassa));
                    $res .= "<td>" . $r["d"]  . "</td>";
                } else {
                    $q = "SELECT (DAY(assenze.DataFine)-DAY(assenze.DataInizio)) AS d FROM dipendenti INNER JOIN assenze ON dipendenti.Cod=assenze.CodDipendente WHERE assenze.Tipo='Maternita' AND MONTH(assenze.DataInizio)=" . $_POST['mese'] . " AND YEAR(assenze.DataInizio)=" . $_POST['year'] . " AND assenze.CodDipendente=" . $row["Cod"] . " GROUP BY assenze.CodDipendente";
                    $r = mysqli_fetch_array($link->query($queryCassa));
                    $res .= "<td>" . $r["d"]  . "</td>";
                }
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
                if ($resultCassa == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultCassa["malattia"]  . "</td>";
                if ($resultMalattia == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultMalattia["malattia"] . "</td>";
                if ($resultFerie == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultFerie["malattia"] . "</td>";
                if ($resultMat == NULL)
                    $res .= "<td>" . 0  . "</td>";
                else
                    $res .= "<td>" . $resultMat["malattia"] . "</td>";
            }
            $res .= "<td><button class='buttonanagrafica' data-bs-toggle='modal' data-bs-target='#myModal' onclick='anagraficaDip(" . $param . ")'>Informazioni</button></td>";
            $res .= "</tr>";
        }
        die($res);
    } else
        die(mysqli_error($link));
} else if (isset($_POST["idDip"]) && !isset($_POST["salario"])) {
    $anagrafica = "SELECT * FROM dipendenti INNER JOIN contratti ON dipendenti.Cod=contratti.CodDipendente WHERE dipendenti.Cod=" . $_POST["idDip"];
    if ($result = $link->query($anagrafica)) {
        $row = mysqli_fetch_array($result);
        die('<div class="dipendente">
                            <b>Nome:</b> <label type="text" name="nome" id="nome">' . $row["Nome"] . " " . $row["Cognome"] . '</label><br><br>
                            <b>Codice Fiscale:</b><label type="text" name="cf" id="cf">'  . $row["CodiceFiscale"] . '</label><br><br>
                            <b>Telefono:</b><label type="tel" name="tel" id="tel">'  . $row["Telefono"] . '</label><br><br>
                            <b>Email:</b><label type="mail" name="mail" id="mail">' . $row["Email"] . '</label><br><br>
                            <b>Indirizzo:</b><label type="ind" name="ind" id="ind">'  . $row["Indirizzo"] . '</label><br><br>
                </div>
                <div class="contratto" id="' . $_POST["idDip"] . '">
                            <b>Mansione:</b><input type="text" id="mans" class="txt" value="'  . $row["Mansione"] . '" disabled></input><br><br>
                            <b>Salario:</b><input type="text" id="sal" class="txt" value="' . $row["Salario"] . '"disabled></input><br><br>
                            <b>Ore:</b><input type="text" id="ore" class="txt" value="' . $row["OreLavorative"] . '"disabled></input><br><br>
                            <b>Data inizio:</b><input type="text" id="inizio" class="txt" value="' . $row["DataInizio"] . '"disabled></input><br><br>
                            <b>Data fine:</b><input type="text" id="fine" class="txt" value="' . $row["DataFine"] . '"disabled></input><br><br>                        
                </div>');
    }
} else if (isset($_POST["mansione"]) && isset($_POST["salario"]) && isset($_POST["ore"]) && isset($_POST["datai"]) && isset($_POST["dataf"])) {
    $modifica = "UPDATE contratti SET Salario = '" . $_POST["salario"] . "', OreLavorative = '" . $_POST["ore"] . "', DataInizio = '" . $_POST["datai"] . "', DataFine = '" . $_POST["dataf"] . "' WHERE contratti.CodDipendente = " . $_POST["idDip"];
    if ($result = $link->query($modifica)) {
        $modifica = "UPDATE dipendenti SET Mansione='" . $_POST["mansione"] . "' WHERE dipendenti.Cod = " . $_POST["idDip"];
        if ($result = $link->query($modifica)) {
            die($modifica);
        }
    } else {
        die($modifica);
    }
} else
    die("Errore");
?>