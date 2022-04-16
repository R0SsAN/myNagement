<?php
    require_once("connect_db.php");
    session_start();
    if(!isset($_SESSION["aziendaId"]))
        die("Errore");

    if(isset($_GET["type"]))
    {
        if($_GET["type"]=="generate-day")
        {
            $data=date("Y-m-d");
            //prendo la lista dei dipendenti di quell'azienda
            //per ogni dipendente creo la tupla relativa al giorno odierno
            $query="SELECT dipendenti.Cod FROM dipendenti WHERE 1";
            if($result=$link->query($query))
            {
                if(mysqli_num_rows($result)>0)
                {
                    
                    while($row=mysqli_fetch_array($result))
                    {
                        $query="INSERT INTO presenza(CodDipendente, presente, giorno) VALUES ('".$row["Cod"]."' , '0' , '$data')";
                        
                        $result2=$link->query($query);
                    }
                    die("Success -- ".$data);
                }
                die("Errore");
            }
            die("Errore");
        }
        die("Parameter not given");
    }
    die("Errore");
?>