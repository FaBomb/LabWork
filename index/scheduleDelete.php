<?php
    include "../dbConnect.php";

    $host = $_SERVER["HTTP_HOST"];
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    
    $id = $_POST["schedule_id"];

    $sql = "DELETE FROM joinMembers WHERE schedule_id = $id";
    
    mysqli_query($conn, $sql);

    $sql = "DELETE FROM schedules WHERE schedule_id = $id";

    if ($result = mysqli_query($conn, $sql)){
        mysqli_close($conn);
        $extra = "index.html.php";
        header( "Location: https://$host$uri/$extra" );
    }
?>