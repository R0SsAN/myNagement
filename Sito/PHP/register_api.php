<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
require_once "connect_db.php";
    if(isset($_POST["tipo"]))
    {
        echo "entrato";
        if($_POST["tipo"]=="titolare")
        {
            //registrazione di un titolare
            if(isset($_POST["nome"]) && isset($_POST["cognome"]) && isset($_POST["telefono"]) && isset($_POST["email"]) && isset($_POST["azienda"]) && isset($_POST["password"]))
            {
                
                $query="INSERT INTO titolari(Nome, Cognome, Telefono, Email, Password, CodAzienda) VALUES ('".$_POST["nome"]."','".$_POST["cognome"]."','".$_POST["telefono"]."','".$_POST["email"]."','".md5($_POST["password"])."','".$_POST["azienda"]."')";
                if($result = $link->query($query))
                {
                    die("true");
                }
                die("false");
            }

        }
        else if($_POST["tipo"]=="azienda")
        {
            echo "entrato2";
            //registrazione di un azienda
            if(isset($_POST["nome"]) && isset($_POST["ragione"]) && isset($_POST["email"]) && isset($_POST["telefono"]) && isset($_POST["indirizzo"]) )
            {

                echo "entrato3";
                $query="INSERT INTO aziende(Nome, RagioneSociale, Email, Telefono, `Indirizzo`) VALUES ('".$_POST["nome"]."','".$_POST["ragione"]."','".$_POST["email"]."','".$_POST["telefono"]."','".$_POST["indirizzo"]."')";
                if($result = $link->query($query))
                {
                    die("true");
                }
                die("false");
            }
        }
        else if($_POST["tipo"]=="check")
        {
            $lista="";
            $query="SELECT * FROM aziende";
            if($result = $link->query($query))
            {
                if(mysqli_num_rows($result) > 0)
                {
                    
                    while ($row = mysqli_fetch_array($result)) 
                    {
                        $lista.='<option value="'.$row["Cod"].'">'.$row["Nome"].'</option>';
                    }
                }
            }
            die($lista);
        }
    }
    else
        echo "Errore";
?>