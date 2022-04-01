<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
    require_once "connect_db.php";
    session_start();

    if(isset($_POST["tipo"]))
    {
        if($_POST["tipo"]=="ingaggio")
        {
            //registrazione di un titolare
            if(isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["telefono"]) && isset($_POST["email"]) && isset($_POST["indirizzo"]) && isset($_POST["cf"])&& isset($_POST["mansione"])&&
                 isset($_POST["orario"])&& isset($_POST["salario"]) && isset($_POST["tipoContratto"]) && isset($_POST["dataInizio"]) && isset($_POST["dataFine"]))
            {
                //creo l'anagrafica del dipendente
                $query="INSERT INTO dipendenti(CodiceFiscale, Nome, Cognome, Telefono, Email, DataNascita, Indirizzo, Mansione, CodAzienda) 
                        VALUES ('".$_POST["cf"]."','".$_POST["nome"]."','".$_POST["cognome"]."','".$_POST["telefono"]."','".$_POST["email"].
                        "','".$_POST["nascita"]."','".$_POST["indirizzo"]."','".$_POST["mansione"]."','".$_SESSION["userId"]."')";
                if($result = $link->query($query))
                {
                    //ricavo l'id del dipendente appena creato
                    $query="SELECT Cod FROM dipendenti WHERE dipendenti.CodiceFiscale='".$_POST["cf"]."'";
                    if($result=$link->query($query))
                    {
                        $cod=mysqli_fetch_array($result)["Cod"];

                        //ora creo il contratto per il dipendente
                        $query="INSERT INTO contratti(Salario, Durata, DataInizio, DataFine, CodDipendente) 
                                VALUES ('".$_POST["salario"]."', '".$_POST["orario"]."', '".$_POST["dataInizio"]."', '".$_POST["dataFine"]."', '".$cod."')";
                        if($result=$link->query($query))
                        {
                            die("true");
                        }
                        die("Errore query creazione contratto");
                    }
                    die("Errore query select cod dipendente");
                }
                die("Errore query creazione dipendente");
            }
            die("Parametri non passati");
        }
        die("Tipo non riconosciuto");
    }
    else
        die("Errore");
?>