<?php
    require_once "connect_db.php";
    
    if(isset($_POST["rfid"]))
    {
        $data=date("Y-m-d");
        //controllo se è già presente
        $query="SELECT presenza.Cod AS id, presenza.presente AS presente FROM presenza INNER JOIN contratti ON presenza.CodDipendente=contratti.CodDipendente
        WHERE contratti.RFID='".$_POST["rfid"]."' AND presenza.giorno='$data'";
        if($result=$link->query($query))
        {
            if(mysqli_num_rows($result)>0)
            {
                $row=mysqli_fetch_array($result);
                if($row["presente"]==0)
                {
                    $query="UPDATE presenza SET presenza.presente=1 WHERE Cod=".$row["id"]."";
                    if($result=$link->query($query))
                    {
                        die("true");
                    }
                }
            }
            die("No row found");
        }
        die("false");
    }
    die("No parameters");
?>