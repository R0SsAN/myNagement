<?php
    require_once "connect_db.php";
    
    if(isset($_PUT["rfid"]))
    {
        $data=date("Y-m-d");
        //controllo se è già presente
        $query="SELECT presenza.presente AS presente FROM presenza INNER JOIN contratti ON presenza.CodDipendente=contratti.CodDipendente
        WHERE presenza.RFID='".$_PUT["rfid"]."' AND presenza.giorno='".$data."'";
        if($result=$link->query($query))
        {
            if(mysqli_num_rows($result)>0)
            {
                if(mysqli_fetch_array($result)["presente"]==0)
                {
                    $query="UPDATE presenza SET presenza.presente=1 FROM presenza 
                    INNER JOIN contratti ON presenza.CodDipendente=contratti.CodDipendente WHERE contratti.RFID='".$_PUT["rfid"]."' AND
                    presenza.giorno='.$data.'";
                    if($result=$link->query($query))
                    {
                        die("true");
                    }
                }
            }
        }
        die("false");
    }
    die("No parameters");
?>