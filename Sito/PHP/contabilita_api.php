<?php
    require_once "connect_db.php";
    session_start();
    if(!isset($_SESSION["aziendaId"]))
        die("Errore");
    setlocale(LC_MONETARY, 'it_IT');
    //inserimento nuovo movimento
    if(isset($_POST["tipo"]) && isset($_POST["descrizione"]) && isset($_POST["valore"]) && isset($_POST["data"]))
    {
        $query="INSERT INTO movimento (Tipo, Valore, Data, Descrizione, CodAzienda) VALUES ('".$_POST["tipo"]."', '".$_POST["valore"]."', '".$_POST["data"]."', '".$_POST["descrizione"]."', '".$_SESSION["aziendaId"]."')";
        if($result=$link->query($query))
            die("true");
        die("false");
    }
    else if(isset($_GET["type"]) && isset($_GET["anno"]) && isset($_GET["mese"]))
    {
        //visualizzazione somma delle entrate generate con i movimenti generici
        if($_GET["type"]=="entrate-movimenti")
        {
            $query="
                SELECT SUM(movimento.Valore) as somma
                FROM movimento
                INNER JOIN aziende ON aziende.Cod=movimento.CodAzienda
                WHERE aziende.Cod=".$_SESSION["aziendaId"]."
                AND movimento.Tipo=0
                AND month(movimento.Data)=".$_GET["mese"]." AND year(movimento.Data)=".$_GET["anno"]."
            ";
            if($result=$link->query($query))
            {
                $link->close();
                die(mysqli_fetch_array($result)["somma"]);
            }
            die("Errore");
        }
        //visualizzazione somma delle entrate generate con la vendita dei prodotti
        else if($_GET["type"]=="entrate-prodotti")
        {
            $somma=0;
            $query="
                SELECT p.Quantita as quantita, p.Prezzo AS prezzo
                FROM prodotti_venduti p
                INNER JOIN aziende ON aziende.Cod=p.CodAzienda
                WHERE aziende.Cod='".$_SESSION["aziendaId"]."'
                AND month(p.DataVendita)=".$_GET["mese"]." AND year(p.DataVendita)=".$_GET["anno"]."
            ";
            if($result=$link->query($query))
            {
                $link->close();
                if(mysqli_num_rows($result)>0)
                {
                    //per ogni prodotto venduto moltiplico il prezzo per singolo prodotto alla quantita venduta
                    while($row=mysqli_fetch_array($result))
                        $somma.= $row["prezzo"]*$row["quantita"];
                    die($somma);
                }
                die("0");
            }
            die("Errore");
        }
        //visualizzazione delle uscite generate con i movimenti generici
        else if($_GET["type"]=="uscite-movimenti")
        {
            $query="
                SELECT SUM(movimento.Valore) as somma
                FROM movimento
                INNER JOIN aziende ON aziende.Cod=movimento.CodAzienda
                WHERE aziende.Cod=".$_SESSION["aziendaId"]."
                AND movimento.Tipo=1
                AND month(movimento.Data)=".$_GET["mese"]." AND year(movimento.Data)=".$_GET["anno"]."
            ";
            if($result=$link->query($query))
            {
                $link->close();
                die(mysqli_fetch_array($result)["somma"]);
            }
            die("Errore");
        }
        else if($_GET["type"]=="uscite-prodotti")
        {
            $somma=0;
            $query="
                SELECT p.Quantita as quantita, p.Prezzo AS prezzo
                FROM prodotti_acquistati p
                INNER JOIN aziende ON aziende.Cod=p.CodAzienda
                WHERE aziende.Cod='".$_SESSION["aziendaId"]."'
                AND month(p.DataAcquisto)=".$_GET["mese"]." AND year(p.DataAcquisto)=".$_GET["anno"]."
            ";
            if($result=$link->query($query))
            {
                $link->close();
                if(mysqli_num_rows($result)>0)
                {
                    //per ogni prodotto venduto moltiplico il prezzo per singolo prodotto alla quantita venduta
                    while($row=mysqli_fetch_array($result))
                        $somma.= $row["prezzo"]*$row["quantita"];
                    die($somma);
                }
            }
            die("Errore");
        }
        else if($_GET["type"]=="uscite-stipendi")
        {
            //prendo stipendi di tutti i dipendenti in tabella presenze ogni giorno in quel mese con presente=true
            //prendo stipendi di tutti i dipendenti in tabella assenze in quel mese con percentuale di stipendio giusta
            //le sommo

            $sommaTotaleStipendi=0;
            $numeroDipendenti=0;
            //prendo il numero di dipendenti dell'azienda per poi fare il ciclo for
            $query="SELECT dipendenti.Cod AS cod FROM dipendenti WHERE dipendenti.CodAzienda=".$_SESSION["aziendaId"]."";
            if(!$result=$link->query($query))
                die("Errore esecuzione query 1");
            $numeroDipendenti=mysqli_num_rows($result);
            while($row=mysqli_fetch_array($result))
            {
                $sommaStipendioDipendente=0;

                //mi salvo lo stipendio del dipendente e il numero di ore giornaliere
                $query="SELECT contratti.Salario AS salario , contratti.OreLavorative AS ore FROM contratti WHERE contratti.CodDipendente=".$row["cod"]."";
                if(!$result2=$link->query($query))
                    die("Errore esecuzione query 2");
                $temp=mysqli_fetch_array($result2);

                $salarioDipendente=$temp["salario"];
                $oreLavorative=$temp["ore"];
                //ora si prendono tutte le presenze di quel mese e si calcola lo stipendio in base a quello
                $query="SELECT presenza.presente AS presente FROM presenza WHERE CodDipendente=".$row["cod"]." AND year(presenza.giorno)=".$_GET["anno"]." AND month(presenza.giorno)=".$_GET["mese"]."";
                if(!$result2=$link->query($query))
                    die("Errore esecuzione query 3");
                while($row2=mysqli_fetch_array($result2))
                {
                    //se il dipendente ?? presente allora aggiungo il suo stipendio alla somma di tutti gli stipendi
                    if($row2["presente"]==1)
                        $sommaStipendioDipendente=$sommaStipendioDipendente+$salarioDipendente;
                }
                

                //dopo aver sommato tutte le presenze si va nella tabella assenze e si sommano tutti gli stipendi calcolati con la percentuale
                //per prima cosa prendo tutte le assenze che hanno datainizio o datafine nell'anno corretto == hanno qualche assenza in questo anno con probabilita di esserci nel mese giusto
                $query="SELECT * FROM assenze WHERE assenze.CodDipendente=".$row["cod"]." AND (year(assenze.DataInizio)=".$_GET["anno"]." OR year(assenze.DataFine)=".$_GET["anno"].")";
                if(!$result2=$link->query($query))
                    die("Errore esecuzione query 4");
                while($row2=mysqli_fetch_array($result2))
                {
                    
                    $numeroGiorniAssenza=0;
                    //ora per ogni assenza relativa a questo mese calcolo i giorni di assenza per poi poter calcolare lo stipendio

                    //se sia datainizio che datfine sono all'interno del mese giusto allora mi basta calcolare la differenza di giorni
                    if(date("m",strtotime($row2["DataInizio"])) == $_GET["mese"] && date("m",strtotime($row2["DataFine"])) == $_GET["mese"])
                    {
                        $date1 = new DateTime($row2["DataInizio"]);
                        $date2 = new DateTime($row2["DataFine"]);
                        $numeroGiorniAssenza = $date2->diff($date1)->format('%a');
                    }
                    //se invece datainizio ?? nel mese giusto ma datafine no allora prendo il numero di giorni da datainizio alla fine del mese
                    else if(date("m",strtotime($row2["DataInizio"]))==$_GET["mese"] && date("m",strtotime($row2["DataFine"]))!=$_GET["mese"])
                    {
                        $numeroGiorniAssenza= cal_days_in_month(CAL_GREGORIAN, $_GET["mese"], $_GET["anno"]) - date("d",strtotime($row2["DataInizio"]));
                    }
                    //se invece datafine ?? nel mese giusto ma datainizio no allora prendo il numero di giorni dall'inizio del mese a datafine
                    else if(date("m",strtotime($row2["DataInizio"]))!=$_GET["mese"] && date("m",strtotime($row2["DataFine"]))==$_GET["mese"])
                    {
                        $numeroGiorniAssenza=date("d",strtotime($row2["DataFine"]));
                    }
                    //se invece sia datainizio che datafine non sono nel mese giusto ma lo comprendono nell'intervallo allora prendo il numero di giorni del mese attuale
                    else if(date("m",strtotime($row2["DataInizio"]))!=$_GET["mese"] && date("m",strtotime($row2["DataFine"]))!=$_GET["mese"])
                    {
                        $dataInizio = date ('Y-m-01', strtotime($row2["DataInizio"]));
                        $dataFine = date ('Y-m-01', strtotime($row2["DataFine"]));
                        $mese = date ('Y-m-01', strtotime($_GET["anno"]."-".$_GET["mese"]));
                        if ( ($mese > $dataInizio) && (($mese < $dataFine)) )
                        {
                            $numeroGiorniAssenza=cal_days_in_month(CAL_GREGORIAN, $_GET["mese"], $_GET["anno"]);
                        }
                    }
                    $sommaStipendioDipendente= $sommaStipendioDipendente+(($salarioDipendente / 100) * $row2["PercentualeStipendio"]) * $numeroGiorniAssenza;
                }
                //alla fine sommo lo stipendio relativo al dipendente corrente alla somma di tutti gli stipendi
                $sommaTotaleStipendi=$sommaTotaleStipendi+$sommaStipendioDipendente;
            }
            die(strval($sommaTotaleStipendi));
        }
        if($_GET["type"]=="lista-movimenti")
        {
            $query="SELECT * FROM movimento WHERE movimento.CodAzienda=".$_SESSION["aziendaId"]." 
            AND month(movimento.Data)=".$_GET["mese"]." AND year(movimento.Data)=".$_GET["anno"]."";
            if($result=$link->query($query))
            {
                $return="";
                while($row=mysqli_fetch_array($result))
                {
                    if($row["Tipo"]==0)
                        $tipo="Entrata";
                    else
                        $tipo="Uscita";
                    $return.='<tr>
                                <td class="column1">'.$tipo.'</td>
                                <td class="column2">'.floatval($row["Valore"]).' ???</td>
                                <td class="column3">'.$row["Data"].'</td>
                                <td class="column4">'.$row["Descrizione"].'</td>
                            </tr>
                    ';
                }
                die($return);
            }
            die("Errore");
        }
        die("Errore");
        
    }
    die("No parameters given");
    

/*
    Query visualizzazione somma entrate
    SELECT SUM(movimento.Valore)
    FROM movimento
    INNER JOIN aziende ON aziende.Cod=movimento.CodAzienda
    WHERE aziende.Cod=1
    AND movimento.Tipo=0


    Query visualizzazione somma uscite
    SELECT SUM(movimento.Valore)
    FROM movimento
    INNER JOIN aziende ON aziende.Cod=movimento.CodAzienda
    WHERE aziende.Cod=1
    AND movimento.Tipo=0
*/
?>