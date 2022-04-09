<?php
    require_once "connect_db.php";
    session_start();
    if(!isset($_SESSION["aziendaId"]))
        die("Errore");
        
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
        //visualizzazione somma entrate
        if($_GET["type"]=="somma-entrate-totale")
        {

            $somma=0;
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
                $row=mysqli_fetch_array($result);
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
                    $row=mysqli_fetch_array($result);
                    

                    die($row["somma"]);
                }
            }
            die("false");
        }
        else if($_GET["type"]=="somma-uscite-totale")
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
                $row=mysqli_fetch_array($result);
                die($row["somma"]);
            }
            die("false");
        }
        else if($_GET["type"]=="somma-entrate-movimenti")
        {

        }
        else if($_GET["type"]=="somma-uscite-movimenti")
        {

        }
        else if($_GET["type"]=="somma-entrate-prodotti")
        {

        }
        else if($_GET["type"]=="somma-uscite-prodotti")
        {

        }
        else if($_GET["type"]=="somma-stipendi")
        {
            //prendo stipendi di tutti i dipendenti in tabella presenze ogni giorno in quel mese con presente=true
            //prendo stipendi di tutti i dipendenti in tabella assenze in quel mese con percentuale di stipendio giusta
            //le sommo
                
        }
        die("Errore");
        
    }
    

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