<?php 
    $host = $_SERVER["HTTP_HOST"];
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    
    include "../dbConnect.php";

    
    $number = $_POST["num"];
    $title = $_POST["title"];
    $date = $_POST["date"];
    
    session_start();
    
    if (isset($_SESSION["number"]) && isset($_SESSION["title"]) && isset($_SESSION["date"])){
        unset($_SESSION["number"]);
        unset($_SESSION["title"]);
        unset($_SESSION["date"]);
    }
    $_SESSION["number"] = $number;
    $_SESSION["title"] = $title;
    $_SESSION["date"] = $date;

    mysqli_close($conn);
    $extra = "seminarMinute.html.php";
    header( "Location: https://$host$uri/$extra");

?>