<?php
    //elimino la sessione e ritorno al login
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../HTML/login.php");
?>