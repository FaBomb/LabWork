<?php
    include "../dbConnect.php";

    $host = $_SERVER["HTTP_HOST"];
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    
    $id = $_POST["id"];

    $sql = "DELETE FROM users WHERE user_id = $id";
    
    if ($result = mysqli_query($conn, $sql)){
        mysqli_close($conn);
        $extra = "labAdmin.html.php";
        header( "Location: https://$host$uri/$extra" );
    }
?>