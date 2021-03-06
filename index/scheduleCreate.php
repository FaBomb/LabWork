<?php
    session_start();

    $host = $_SERVER["HTTP_HOST"];
    $uri = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

    $year = $_POST["year"];
    $week = $_POST["week"];
    $month = $_POST["month"];
    $day = $_POST["day"];
    $_SESSION["year"] = $year;
    $_SESSION["month"] = $month;

    if (empty($_POST["title"])){
        $extra = "index.html.php";
        header( "Location: https://$host$uri/$extra" );
        exit;
    }

    $title = $_POST["title"];
    $content = $_POST["content"];
    $url =$_POST["url"];
    $start_hour = $_POST["start_hour"];
    $start_minute = $_POST["start_minute"];
    $end_hour = $_POST["end_hour"];
    $end_minute = $_POST["end_minute"];
    $user_id = $_POST["user_id"];

    include "../dbConnect.php";

    $sql = "INSERT INTO schedules(year, week, month, day, title, content, url, start_hour, start_minute, end_hour, end_minute, user_id) 
            VALUES($year, $week, $month, $day, '$title', '$content', '$url', $start_hour, $start_minute, $end_hour, $end_minute, $user_id)";

    mysqli_query($conn, $sql);

    mysqli_close($conn);
    $extra = "index.html.php";
    header( "Location: https://$host$uri/$extra");

?>