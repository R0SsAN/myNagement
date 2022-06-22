<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
require_once "connect_db.php";
session_start();
if (isset($_SESSION["email"]))
    header("Location: dashboard.html");
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $stmt = $link->prepare("SELECT Cod FROM titolari WHERE titolari.Email=? AND titolari.Password=? ");
    $stmt->bind_param("ss", $email, $password);
    $email = $_POST["email"];
    $password = md5($_POST["password"]);
    $stmt->execute();
    if ($result = $stmt->get_result()) {
        $_SESSION["email"] = $email;
        echo "true";
    } else
        echo "false";
} else
    echo "Errore :)";
?>