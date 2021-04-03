<?php
    session_start();

    $host = $_SERVER["HTTP_HOST"];
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

    session_destroy();
    $extra = "login/userLogin.html.php";
    header( "Location: https://$host$uri/$extra");
?>