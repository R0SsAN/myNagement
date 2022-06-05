<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
    require_once "connect_db.php";
    session_start();

    if(isset($_POST["tipo"]))
    {
        if($_POST["tipo"]=="titolare")
        {
            //registrazione di un titolare
            if(isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["telefono"]) && isset($_POST["email"]) && isset($_POST["azienda"]) && isset($_POST["password"]))
            {
                
                $query="INSERT INTO titolari(Nome, Cognome, Telefono, Email, Password, CodAzienda) VALUES ('".$_POST["nome"]."','".$_POST["cognome"]."','".$_POST["telefono"]."','".$_POST["email"]."','".md5($_POST["password"])."','".$_POST["azienda"]."')";
                if($result = $link->query($query))
                {
                    die(json_encode(array("status" => "true")));
                }
                die(json_encode(array("status" => "false")));
            }

        }
        else if($_POST["tipo"]=="azienda")
        {
            //registrazione di un azienda
            if(isset($_POST["nome"]) && isset($_POST["ragione"]) && isset($_POST["email"]) && isset($_POST["telefono"]) && isset($_POST["indirizzo"]) )
            {
                $query="INSERT INTO aziende(Nome, RagioneSociale, Email, Telefono, `Indirizzo`) VALUES ('".$_POST["nome"]."','".$_POST["ragione"]."','".$_POST["email"]."','".$_POST["telefono"]."','".$_POST["indirizzo"]."')";
                if($result = $link->query($query))
                {
                    die(json_encode(array("status" => "true")));
                }
                die(json_encode(array("status" => "false")));
            }
        }
        else if($_POST["tipo"]=="check" && isset($_POST["id"]))
        {
            //restituzione di tutte le aziende per visualizzarle nel login
            $lista="";
            if($_POST["id"]!=-1)
                $query="SELECT * FROM aziende WHERE aziende.Cod=".$_POST["id"]."";
            else
                $query="SELECT * FROM aziende";
            if($result = $link->query($query))
            {
                if(mysqli_num_rows($result) > 0)
                {
                    $return=array("status"=>"true", "aziende" => mysqli_fetch_all($result, MYSQLI_ASSOC));
                    die(json_encode($return));
                    /* while ($row = mysqli_fetch_array($result)) 
                    {
                        $lista.='<option value="'.$row["Cod"].'">'.$row["Nome"].'</option>';
                    } */
                }
                die(json_encode(array("status"=>"false")));
            }
            die($lista);
        }
        else if($_POST["tipo"]=="login")
        {
            
            //login di un titolare
            if(isset($_POST["email"]) && isset($_POST["password"]))
            {
                $stmt=$link->prepare("SELECT Cod FROM titolari WHERE titolari.Email=? AND titolari.Password=? ");
                $stmt->bind_param("ss",$email , $password);
                $email=$_POST["email"];
                $password=md5($_POST["password"]);
                $stmt->execute();
                
                if($result=$stmt->get_result())
                {
                    if(mysqli_num_rows($result)>0)
                    {
                        $row=mysqli_fetch_array($result);
                        $_SESSION["userEmail"]=$_POST["email"];
                        $_SESSION["userId"]=$row["Cod"];
                        //ricavo id azienda
                        $query="SELECT aziende.Cod FROM aziende INNER JOIN titolari ON titolari.CodAzienda=aziende.Cod WHERE titolari.Cod='".$row["Cod"]."'";
                        if($result=$link->query($query))
                        {
                            $row=mysqli_fetch_array($result);
                            $_SESSION["aziendaId"]=$row["Cod"];
                            die(json_encode(array("status" => "true")));
                        }
                        die(json_encode(array("status" => "false")));
                        
                    }
                }
            }
            die(json_encode(array("status" => "false")));
        }
    }
    else
        die("Errore");

    function ciao($mess)
    {
        echo '<script>console.log("'.$mess.'")</script>';
    }
?>