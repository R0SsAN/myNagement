<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
    if(isset($_POST["email"]) && isset($_POST["password"]))
    {
        $email=$_POST["email"];
        $password=$_POST["password"];
        //mi connetto al server sql
        if($conx=mysqli_connect("b1yzhtxfs1l3kmuousjz-mysql.services.clever-cloud.com","udk4l84vcxclrpyq","BWqKOkPCdBuILkRM7vSZ","b1yzhtxfs1l3kmuousjz"))
        {
            //controllo se l'email è già registrata
            $comando="SELECT count(*) as cntUser from users where email='".$email."'";
            $result=mysqli_query($conx,$comando);
            $row = mysqli_fetch_array($result);
            $count = $row['cntUser'];
            if($count > 0)
                echo "false";
            else
            {
                //se non è già registrata allora lo inserisco nel database
                $comando="INSERT INTO `users` (`id`, `email`, `password`) VALUES (NULL, '".$_POST["email"]."', '".$_POST["password"]."');";
                mysqli_query($conx,$comando);
                echo "true";
            }
        }
        else
            echo "false";
    }
    else
        echo "Errore :)";
?>