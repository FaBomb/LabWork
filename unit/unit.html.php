<?php 
    session_start();
    unset($_SESSION["year"]);
    echo $_SESSION["login"];
?>