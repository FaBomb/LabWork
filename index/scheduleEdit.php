<?php
    session_start();
    
    $host = $_SERVER["HTTP_HOST"];
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

    $schedule_id = $_POST["schedule_id"];
    $title = $_POST["title"];
    $content = $_POST["content"];
    $url =$_POST["url"];
    $start_hour = $_POST["start_hour"];
    $start_minute = $_POST["start_minute"];
    $end_hour = $_POST["end_hour"];
    $end_minute = $_POST["end_minute"];
    $user_id = $_POST["user_id"];

    $_SESSION["year"] = $_POST["year"];
    $_SESSION["month"] = $_POST["month"];

    if (empty($_POST["title"])){
        $extra = "index.html.php";
        header( "Location: https://$host$uri/$extra" );
        exit;
    }

    include "../dbConnect.php";

    $sql = 'UPDATE schedules SET title = "'.$title.'", content = "'.$content.'", url = "'.$url.'",
            start_hour = '.$start_hour.', start_minute = '.$start_minute.',
            end_hour = '.$end_hour.', end_minute = '.$end_minute.', user_id = '.$user_id.' 
            WHERE schedule_id = '.$schedule_id;
    
    if ($result = mysqli_query($conn, $sql)){
        mysqli_close($conn);
        $extra = "index.html.php";
        header( "Location: https://$host$uri/$extra" );
    }else{
        echo "データベース接続エラー";
    }
?>