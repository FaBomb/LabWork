<?php
    session_start();
    $host = $_SERVER["HTTP_HOST"];
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), substr($uri, strrpos($uri,"/")));
    if (!isset($_SESSION["login"])){
        $extra = "login/userLogin.html.php";
        header( "Location: https://$host$uri/$extra" );
    }
?>